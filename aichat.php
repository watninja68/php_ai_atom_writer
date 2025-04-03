<?php
// aichat.php - Full Code

// --- Core Includes and Setup ---
require_once __DIR__ . '/auth0_handler.php'; // Handles Auth0, session_start()
require_once __DIR__ . '/db_init.php';      // Defines $dsn, $dbUser, $dbPass
require_once __DIR__ . '/vendor/autoload.php'; // Composer autoload

use Dotenv\Dotenv;
use OpenAI\Client; // Assuming you might use this alias

// --- Authentication Check ---
if (!isAuthenticated()) {
    $_SESSION['redirect_url_pending'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit;
}

// --- Get Authenticated User ID ---
// Ensure user_id is set correctly by auth0_handler.php (should be Auth0 'sub')
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    // This shouldn't happen if isAuthenticated is true, but good practice
    error_log("Error: User ID not found in session for authenticated user.");
    redirectToLoginWithError('Session error. Please log in again.');
    exit;
}

// --- Load Environment Variables ---
try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    // Ensure API Key is loaded (adjust if name differs in your .env)
    $dotenv->required(['QWEN_API', 'AUTH0_DOMAIN', 'AUTH0_CLIENT_ID', 'AUTH0_CLIENT_SECRET', 'AUTH0_COOKIE_SECRET', 'AUTH0_BASE_URL']);
} catch (Exception $e) {
    error_log("Error loading .env file: " . $e->getMessage());
    // Critical error, might want a user-friendly page instead of die() in prod
    die('Required environment variables are missing. Check server configuration or .env file and logs.');
}
$yourApiKey = $_ENV['QWEN_API'];


// --- Database Connection ---
try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection failed in aichat.php: " . $e->getMessage());
    // Show a user-friendly error page or message
    die("Database service unavailable. Please try again later.");
}

// --- OpenAI Client Setup ---
// Assuming the QWEN API uses OpenAI compatible client structure
try {
    $client = OpenAI::factory()
        ->withApiKey($yourApiKey)
        ->withBaseUri('https://dashscope-intl.aliyuncs.com/compatible-mode/v1') // Make sure this is correct
        ->make();
} catch(Exception $e) {
     error_log("Failed to create OpenAI client: " . $e->getMessage());
     die("AI Service configuration error.");
}

// --- Chat Functions ---

function getConversationHistory(PDO $pdo, $sessionId, $conversationId, $userId) {
    try {
        $stmt = $pdo->prepare("SELECT role, content, created_at FROM chat_messages
                               WHERE session_id = :session_id AND conversation_id = :conversation_id AND user_id = :user_id
                               ORDER BY created_at ASC");
        $stmt->execute([
            ':session_id'      => $sessionId,
            ':conversation_id' => $conversationId,
            ':user_id'         => $userId
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching conversation history: " . $e->getMessage());
        return []; // Return empty array on error
    }
}

function getConversationTitle(PDO $pdo, $conversationId, $userId) {
    try {
        // Get first user message as the conversation title, truncate if needed
        $stmt = $pdo->prepare("SELECT content FROM chat_messages
                              WHERE conversation_id = :conversation_id AND user_id = :user_id AND role = 'user'
                              ORDER BY created_at ASC LIMIT 1");
        $stmt->execute([
            ':conversation_id' => $conversationId,
            ':user_id'         => $userId
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && !empty($result['content'])) {
            $title = $result['content'];
            // Ensure title is not excessively long
            return (mb_strlen($title) > 35) ? mb_substr($title, 0, 32) . '...' : $title;
        }
    } catch (PDOException $e) {
        error_log("Error fetching conversation title: " . $e->getMessage());
    }
    return 'New Conversation'; // Default title
}

function addChatMessage(PDO $pdo, $sessionId, $conversationId, $role, $content, $userId) {
    try {
        $stmt = $pdo->prepare("INSERT INTO chat_messages (session_id, conversation_id, role, content, user_id)
                               VALUES (:session_id, :conversation_id, :role, :content, :user_id)");
        $stmt->execute([
            ':session_id'      => $sessionId,
            ':conversation_id' => $conversationId,
            ':role'            => $role,
            ':content'         => $content,
            ':user_id'         => $userId
        ]);
        return true;
    } catch (PDOException $e) {
        error_log("Error adding chat message: " . $e->getMessage());
        return false;
    }
}

function chatWithQwen(Client $client, PDO $pdo, $conversationId, $userInput, $userId) {
    if (!addChatMessage($pdo, session_id(), $conversationId, 'user', $userInput, $userId)) {
        return "Error: Could not save your message."; // Inform user if DB save fails
    }

    $conversationHistory = getConversationHistory($pdo, session_id(), $conversationId, $userId);
    $messages = [];
    // System prompt - adjust as needed
    $messages[] = [
        'role'    => 'system',
        'content' => 'You are Coreho AI, a helpful Blog writer and assistant designed by Coreho Solutions LLP. You help people create engaging content, generate ideas, and improve their writing.'
    ];
    foreach ($conversationHistory as $message) {
        $messages[] = [
            'role'    => $message['role'],
            'content' => $message['content']
        ];
    }
    // Prevent excessively long histories being sent to the API (adjust limit as needed)
     if (count($messages) > 20) {
         $messages = array_merge(
             [$messages[0]], // Keep system prompt
             array_slice($messages, -19) // Keep the last 19 messages
         );
     }


    try {
        $result = $client->chat()->create([
            'model'    => 'qwen-plus', // Ensure this model name is correct
            'messages' => $messages,
            // Add other parameters if needed (temperature, max_tokens, etc.)
        ]);

        $assistantResponse = $result->choices[0]->message->content ?? 'Sorry, I could not generate a response.';

        if (!addChatMessage($pdo, session_id(), $conversationId, 'assistant', $assistantResponse, $userId)) {
             error_log("Failed to save assistant response for conversation $conversationId");
             // Respond to user anyway, but log the failure
        }
        return $assistantResponse;

    } catch (Exception $e) { // Catch generic SDK or network errors
        error_log("Error calling Qwen API: " . $e->getMessage());
        $errorMsg = "Error: Could not connect to the AI service. Please try again later.";
        // Attempt to save the error message as an assistant response for context
        addChatMessage($pdo, session_id(), $conversationId, 'assistant', $errorMsg, $userId);
        return $errorMsg;
    }
}

// --- Conversation ID Handling ---
$conversationId = null;
if (isset($_GET['conversation_id'])) {
    // Basic validation: ensure it looks like a potential conversation ID format
    if (preg_match('/^[a-zA-Z0-9_.-]+$/', $_GET['conversation_id'])) {
        $conversationId = $_GET['conversation_id'];
        $_SESSION['conversation_id'] = $conversationId; // Store the valid ID
    } else {
         // Invalid format, redirect to base chat page
         header('Location: aichat.php');
         exit;
    }

} elseif (isset($_SESSION['conversation_id'])) {
    $conversationId = $_SESSION['conversation_id'];
}

// If no valid conversation ID exists, generate one and redirect
if ($conversationId === null) {
    $conversationId = 'conv_' . bin2hex(random_bytes(12)); // More robust generation
    $_SESSION['conversation_id'] = $conversationId;
    header("Location: " . $_SERVER['PHP_SELF'] . "?conversation_id=" . urlencode($conversationId));
    exit;
}


// --- Handle POST Request (Process User Input) ---
// Using PRG (Post/Redirect/Get) pattern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $userInput = trim($_POST['message']);
    if ($userInput !== '') {
        // Store the message in a session variable to process after redirect
        $_SESSION['pending_message'] = $userInput;
        // Redirect to the same page (with conversation ID) to prevent re-submission on refresh
        header("Location: " . $_SERVER['PHP_SELF'] . "?conversation_id=" . urlencode($conversationId));
        exit;
    } else {
        // Empty message submitted, just redirect back
         header("Location: " . $_SERVER['PHP_SELF'] . "?conversation_id=" . urlencode($conversationId));
         exit;
    }
}

// --- Process Pending Message (After Redirect) ---
if (isset($_SESSION['pending_message'])) {
    $userInput = $_SESSION['pending_message'];
    // Clear the pending message immediately
    unset($_SESSION['pending_message']);
    // Call the AI - The response is saved inside chatWithQwen
    chatWithQwen($client, $pdo, $conversationId, $userInput, $userId);
    // No need to redirect again here
}


// --- Fetch Data for Display ---
$chatHistory = getConversationHistory($pdo, session_id(), $conversationId, $userId);

// Fetch conversations list for the sidebar
$stmt = $pdo->prepare("
    SELECT conversation_id
    FROM chat_messages
    WHERE user_id = :user_id
    GROUP BY conversation_id
    ORDER BY MAX(created_at) DESC
");
$stmt->execute([':user_id' => $userId]);
$conversations = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Determine if the current conversation is new/empty (based *only* on fetched history)
$isNewConversation = empty($chatHistory);

?>
<?php // --- Start HTML --- ?>
<?php $pageTitle = "AI Chat"; ?>
<?php require_once 'layout/header.php'; // Include Head, Meta, CSS links, etc. ?>

    <!-- Include Main Navigation Sidebar -->
    <?php require_once 'layout/sidebar.php'; ?>

    <div id="mainContent" class="main-content h-screen md:p-4 overflow-hidden md:ml-0">
         <!-- Include Page Header -->
         <?php require_once 'layout/main-header.php'; ?>

        <div class="flex flex-col glass-card pl-3 flex-1 h-screen">
            <!-- Chat Page Header -->
            <div class="flex justify-between p-2 items-center border-b dark:border-none border-gray-700/50">
                <!-- Mobile Toggle for Chat Sidebar -->
                <button id="sidebar-toggle" onclick="toggleChatSidebar()"
                    class="md:hidden bg-cyan-500/80 px-2 py-1 rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-2xl font-semibold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                    Coreho Chat AI
                </h1>
                <a href="new_chat.php" title="Start a New Conversation"
                    class="bg-cyan-500/80 px-4 py-2 dark:text-white rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow">New Chat</a>
            </div>

            <div class="flex flex-1 gap-x-2 overflow-hidden"> <?php // Added overflow-hidden ?>
                <!-- Main Chat Area -->
                <main class="flex-1 bg-gray-800 dark:bg-white flex flex-col overflow-hidden rounded border-gray-700 dark:border-gray-700 p-3 h-[calc(100vh-160px)] md:h-[85%] relative"> <?php // Adjusted height ?>

                    <!-- Chat History Display Area -->
                    <div id="chat-content" class="flex-1 overflow-y-auto scrollbar-thin py-4 space-y-4 <?php echo $isNewConversation ? 'hidden' : ''; ?>" style="max-height: calc(100% - 80px);"> <?php // Adjusted max-height ?>
                        <?php if (!empty($chatHistory)): ?>
                            <?php foreach ($chatHistory as $message): ?>
                                <?php if ($message['role'] === 'user'): ?>
                                <div class="flex justify-start items-start space-x-3 mb-4">
                                    <div class="flex-shrink-0">
                                        <img src="assets/images/user.png" alt="User" class="w-8 h-8 rounded-full">
                                    </div>
                                    <div class="message-user bg-blue-600 text-white p-3 rounded-lg max-w-[80%] break-words">
                                        <p><?php echo nl2br(htmlspecialchars($message['content'])); ?></p>
                                    </div>
                                </div>
                                <?php else: // Assistant ?>
                                <div class="flex justify-end items-start space-x-3 mb-4">
                                     <div class="message-assistant bg-gray-700 dark:bg-gray-200 text-white dark:text-black p-3 rounded-lg max-w-[80%] break-words">
                                        <?php // Basic markdown detection (bold, italic, code) - can be expanded
                                            $formattedContent = htmlspecialchars($message['content']);
                                            $formattedContent = preg_replace('/```(.*?)```/s', '<pre class="bg-gray-900 dark:bg-gray-100 text-white dark:text-black p-2 rounded text-sm overflow-x-auto my-2"><code>$1</code></pre>', $formattedContent);
                                            $formattedContent = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $formattedContent);
                                            $formattedContent = preg_replace('/__(.*?)__/', '<strong>$1</strong>', $formattedContent);
                                            $formattedContent = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $formattedContent);
                                            $formattedContent = preg_replace('/_(.*?)_/', '<em>$1</em>', $formattedContent);
                                            $formattedContent = preg_replace('/`(.*?)`/', '<code class="bg-gray-600 dark:bg-gray-300 px-1 rounded text-sm">$1</code>', $formattedContent);
                                        ?>
                                        <p><?php echo nl2br($formattedContent); // Use formatted content ?></p>
                                    </div>
                                    <div class="flex-shrink-0 rounded-full border dark:border-gray-300">
                                        <img src="assets/images/ai.svg" alt="AI" class="w-8 h-8 rounded-full">
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                         <div id="scroll-anchor"></div> <?php // Anchor for scrolling ?>
                    </div>

                    <!-- Quick Start Cards (Shown only if conversation is new/empty) -->
                    <div id="quick-start-cards" class="flex-1 mt-2 pb-2 md:pb-0 scrollbar-thin <?php echo !$isNewConversation ? '' : 'hidden'; ?> flex flex-col justify-center items-center text-center p-4" style="max-height: calc(100% - 80px);"> <?php // Adjusted max-height ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl w-full">
                            <!-- Card 1: Examples -->
                            <div class="glass-card p-4 rounded-lg">
                                <h2 class="flex justify-center gap-x-2 items-center text-lg font-semibold text-white dark:text-gray-800 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" /></svg>
                                    Examples
                                </h2>
                                <div class="space-y-2">
                                    <button class="quick-start-button" onclick="startChat('Write a blog post outline about sustainable travel')">"Write a blog post outline about sustainable travel"</button>
                                    <button class="quick-start-button" onclick="startChat('Explain the concept of AI hallucinations simply')">"Explain the concept of AI hallucinations simply"</button>
                                    <button class="quick-start-button" onclick="startChat('Suggest 5 catchy titles for an article on productivity hacks')">"Suggest 5 catchy titles for an article on productivity hacks"</button>
                                </div>
                            </div>
                             <!-- Card 2: Capabilities -->
                             <div class="glass-card p-4 rounded-lg">
                                 <h2 class="flex justify-center gap-x-2 items-center text-lg font-semibold text-white dark:text-gray-800 mb-3">
                                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                     Capabilities
                                 </h2>
                                 <ul class="list-none space-y-1 text-gray-300 dark:text-gray-600 text-sm">
                                     <li>Generate blog posts & articles</li>
                                     <li>Brainstorm content ideas</li>
                                     <li>Rewrite and improve text</li>
                                     <li>Explain complex topics</li>
                                     <li>Assist with code snippets</li>
                                 </ul>
                             </div>
                         </div>
                     </div>


                    <!-- Input Form - sticky at the bottom -->
                    <div class="sticky bottom-0 flex items-center gap-x-2 mt-auto pt-2 bg-gray-800 dark:bg-white"> <?php // Added bg color for overlap ?>
                        <form method="POST" class="w-full flex items-center gap-x-2">
                            <div class="relative flex-grow">
                                 <textarea id="chat-input" name="message-editable" rows="1"
                                    class="w-full min-h-[4rem] max-h-[15rem] dark:text-black p-3 pr-10 rounded-xl bg-gray-700/50 dark:bg-gray-200 text-white border border-gray-600 dark:border-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300 placeholder:text-gray-400 resize-none overflow-y-auto scrollbar-thin"
                                    placeholder="Ask Coreho AI..." oninput="autoGrow(this);" onkeydown="handleKeyDown(event);"></textarea>
                                <input type="hidden" id="hidden-message" name="message" value="">
                            </div>
                            <button type="submit" id="send-button" onclick="prepareSubmit()" title="Send Message"
                                class="relative flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-cyan-400 to-blue-600 hover:from-cyan-300 hover:to-blue-500 hover:shadow-cyan-400/60 hover:scale-110 transition-all duration-300 flex-shrink-0">
                                <i class="fas fa-paper-plane text-white text-xl"></i>
                            </button>
                        </form>
                    </div>
                </main>

                <!-- Chat Sidebar (Conversations List) -->
                <aside id="chatSidebar" class="chatSidebar md:w-1/3 bg-gray-800/80 dark:bg-white/90 md:relative border-r border-gray-700/50 dark:border-gray-300 hidden rounded backdrop-blur-md p-4 md:flex h-[calc(100vh-160px)] md:h-[85%] flex-col"> <?php // Adjusted height ?>
                    <!-- Fixed Search Bar -->
                    <div class="sticky top-0 bg-gray-800/70 dark:bg-white/70 backdrop-blur-md z-10 pb-2">
                        <input type="text" id="search-conversation" placeholder="Search conversations..."
                            class="w-full p-2 rounded-lg bg-gray-700/50 dark:bg-gray-200 dark:text-black dark:border-black text-white border border-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-black transition-all duration-300">
                    </div>

                    <!-- Scrollable Chat Titles -->
                    <div class="mt-2 flex-1 overflow-y-auto scrollbar-thin" style="max-height: calc(100% - 60px);"> <?php // Adjusted max-height ?>
                        <?php if (empty($conversations)): ?>
                            <div class="p-4 text-center text-gray-400 dark:text-gray-600">
                                No conversations yet. <br> Start a new chat!
                            </div>
                        <?php else: ?>
                            <?php foreach ($conversations as $conv):
                                $title = getConversationTitle($pdo, $conv, $userId);
                                $isActive = ($conv === $conversationId);
                            ?>
                            <div class="conversation-item p-2 rounded-lg cursor-pointer hover:bg-gray-700/40 dark:hover:bg-gray-200 transition-all duration-300 flex items-center justify-between space-x-3 <?php echo $isActive ? 'bg-gray-700/30 dark:bg-gray-300' : ''; ?>">
                                <a href="?conversation_id=<?php echo urlencode($conv); ?>" class="flex items-center space-x-3 flex-grow overflow-hidden" title="<?php echo htmlspecialchars($title); ?>">
                                    <i class="fas fa-comment text-blue-400 text-lg flex-shrink-0"></i>
                                    <span class="text-white text-sm truncate dark:text-black"><?php echo htmlspecialchars($title); ?></span>
                                </a>
                                <button class="delete-btn text-red-500 hover:text-red-300 flex-shrink-0" title="Delete Conversation" data-conversation-id="<?php echo htmlspecialchars($conv); ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <!-- Global Script Includes -->
    <script src="scripts/script.js"></script> <?php // For sidebar toggling etc. ?>

    <!-- Inline JavaScript for Chat Page Specifics -->
    <script>
        const chatContent = document.getElementById('chat-content');
        const chatInput = document.getElementById('chat-input');
        const hiddenInput = document.getElementById('hidden-message');
        const quickStartCards = document.getElementById('quick-start-cards');
        const scrollAnchor = document.getElementById('scroll-anchor');


        // Function to toggle chat sidebar on mobile
        function toggleChatSidebar() {
            const sidebar = document.getElementById('chatSidebar');
            // Simple toggle for mobile view - adjust classes as needed for your layout
             if (sidebar) {
                sidebar.classList.toggle('hidden'); // Assuming 'hidden' hides it on small screens
             }
        }

        // Function to copy text from the hidden input and prepare form submission
        function prepareSubmit() {
            if (chatInput) {
                hiddenInput.value = chatInput.value.trim(); // Use .value for textarea
            }
            // Hide quick start, show chat (in case it was the first message)
            if (quickStartCards && chatContent && quickStartCards.offsetParent !== null) { // Check if visible
                 quickStartCards.classList.add('hidden');
                 chatContent.classList.remove('hidden');
            }
             // Disable button briefly? (Optional)
            // document.getElementById('send-button').disabled = true;
            // setTimeout(() => { document.getElementById('send-button').disabled = false; }, 2000);
            return true; // Allow form submission
        }

         // Function to handle form submission via JS (alternative to onclick)
         const chatForm = hiddenInput.closest('form');
         if (chatForm) {
             chatForm.addEventListener('submit', (e) => {
                 if (!prepareSubmit()) {
                     e.preventDefault(); // Prevent submission if preparation fails (e.g., empty message)
                 }
                 if (hiddenInput.value === '') {
                     e.preventDefault(); // Don't submit empty messages
                 }
             });
         }


        // Function to start a chat from a quick-start card/button
        function startChat(message) {
            if (chatInput && hiddenInput && chatForm) {
                chatInput.value = message; // Set textarea value
                hiddenInput.value = message;
                autoGrow(chatInput); // Adjust height
                prepareSubmit(); // Ensure quick-start is hidden etc.
                chatForm.submit(); // Submit the form
            }
        }

         // Auto-grow textarea
         function autoGrow(element) {
             element.style.height = "5px"; // Temporarily shrink to get correct scrollHeight
             element.style.height = (element.scrollHeight)+"px";
         }

        // Handle Enter key for submission (Shift+Enter for newline)
        function handleKeyDown(event) {
             if (event.key === "Enter" && !event.shiftKey) {
                 event.preventDefault(); // Prevent default newline
                 if (chatInput.value.trim() !== '' && chatForm) {
                     prepareSubmit();
                     chatForm.submit();
                 }
             }
             // Trigger autoGrow on keydown as well for smoother experience
             // setTimeout(() => autoGrow(event.target), 0); // Use timeout to allow char insertion
        }
         // Initial grow
         if (chatInput) autoGrow(chatInput);


        // Ensure delete redirects gracefully
        function deleteConversation(convId) {
            if (confirm('Are you sure you want to delete this conversation?')) {
                const currentConvId = '<?php echo urlencode($conversationId ?? ''); // Handle case where ID might be null briefly ?>';
                window.location.href = `delete_convo.php?conversation_id=${encodeURIComponent(convId)}¤t_id=${currentConvId}`;
            }
        }

        // Scroll to bottom function
         function scrollToBottom() {
             if (scrollAnchor) {
                 scrollAnchor.scrollIntoView({ behavior: "smooth", block: "end" });
             } else if (chatContent) {
                 chatContent.scrollTop = chatContent.scrollHeight;
             }
         }

        // --- Event Listeners ---
        document.addEventListener('DOMContentLoaded', function() {
             // Initial scroll if chat history is visible
             if (chatContent && !chatContent.classList.contains('hidden')) {
                  // Use timeout to ensure rendering is complete before scrolling
                  setTimeout(scrollToBottom, 100);
             }

             // Add event listeners to delete buttons
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const convId = this.getAttribute('data-conversation-id');
                    deleteConversation(convId);
                });
            });

            // Filter conversations with search
            const searchInput = document.getElementById('search-conversation');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    document.querySelectorAll('#chatSidebar .conversation-item').forEach(conv => {
                        const textElement = conv.querySelector('span');
                        const text = textElement ? textElement.textContent.toLowerCase() : '';
                        if (text.includes(searchTerm)) {
                            conv.style.display = 'flex';
                        } else {
                            conv.style.display = 'none';
                        }
                    });
                });
            }

             // Add quick start button listeners dynamically if needed,
             // or rely on onclick as currently implemented.
             // Example:
             // document.querySelectorAll('.quick-start-button').forEach(button => {
             //    button.addEventListener('click', () => startChat(button.textContent.trim().replace(/^"|"$/g, '')));
             // });
        });

        // --- Optional: Use MutationObserver to auto-scroll when new messages are added dynamically (if you implement AJAX later) ---
        // const observer = new MutationObserver(scrollToBottom);
        // if (chatContent) {
        //     observer.observe(chatContent, { childList: true, subtree: true });
        // }
        // Make sure to disconnect the observer when the page unloads:
        // window.addEventListener('beforeunload', () => observer.disconnect());

    </script>

    <?php // Add specific styles if needed, e.g., for scrollbar or quick start buttons ?>
    <style>
        /* Example style for quick start buttons */
        .quick-start-button {
            display: block;
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.5rem;
            color: #e5e7eb; /* Light gray text */
            text-align: left;
            font-size: 0.875rem;
            line-height: 1.25rem;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        .quick-start-button:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .dark .quick-start-button {
            background-color: rgba(0, 0, 0, 0.05);
            border-color: rgba(0, 0, 0, 0.1);
            color: #4b5563; /* Darker gray text */
        }
         .dark .quick-start-button:hover {
             background-color: rgba(0, 0, 0, 0.1);
         }

        /* Ensure chat input takes precedence over quick start cards when both might overlap */
         main > .sticky {
             z-index: 10;
         }

        /* Custom scrollbar styles */
        .scrollbar-thin {
             scrollbar-width: thin;
             scrollbar-color: rgba(59, 130, 246, 0.5) rgba(31, 41, 55, 0.5); /* thumb track */
         }
         .scrollbar-thin::-webkit-scrollbar { width: 8px; }
         .scrollbar-thin::-webkit-scrollbar-track { background: rgba(31, 41, 55, 0.5); border-radius: 4px;}
         .scrollbar-thin::-webkit-scrollbar-thumb { background-color: rgba(59, 130, 246, 0.5); border-radius: 4px; border: 2px solid rgba(31, 41, 55, 0.5);}
         .scrollbar-thin::-webkit-scrollbar-thumb:hover { background-color: rgba(59, 130, 246, 0.8); }

         .dark .scrollbar-thin { scrollbar-color: rgba(100, 116, 139, 0.5) rgba(226, 232, 240, 0.5); }
         .dark .scrollbar-thin::-webkit-scrollbar-track { background: rgba(226, 232, 240, 0.5); }
         .dark .scrollbar-thin::-webkit-scrollbar-thumb { background-color: rgba(100, 116, 139, 0.5); border: 2px solid rgba(226, 232, 240, 0.5); }
         .dark .scrollbar-thin::-webkit-scrollbar-thumb:hover { background-color: rgba(100, 116, 139, 0.8); }

    </style>

</body>
</html>
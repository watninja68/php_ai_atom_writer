<?php
// Start session management
include 'db_init.php';
require_once 'vendor/autoload.php';
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$yourApiKey = $_ENV['QWEN_API'];

if (!isset($_SESSION['google_loggedin'])) {
    header('Location: login.php');
    exit;
}

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Set up the OpenAI client
$client = OpenAI::factory()
    ->withApiKey($yourApiKey)
    ->withBaseUri('https://dashscope-intl.aliyuncs.com/compatible-mode/v1')
    ->make();

// Handle conversation ID
if (isset($_GET['conversation_id'])) {
    $conversationId = $_GET['conversation_id'];
    $_SESSION['conversation_id'] = $conversationId;
} else {
    if (isset($_SESSION['conversation_id'])) {
        $conversationId = $_SESSION['conversation_id'];
    } else {
        $conversationId = 'conv_' . uniqid('', true);
        $_SESSION['conversation_id'] = $conversationId;
        header("Location: " . $_SERVER['PHP_SELF'] . "?conversation_id=" . urlencode($conversationId));
        exit;
    }
}

// Get user ID (replace with your authentication system)
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'guest_user';

// Database functions
function getConversationHistory(PDO $pdo, $sessionId, $conversationId, $userId) {
    $stmt = $pdo->prepare("SELECT role, content, created_at FROM chat_messages 
                           WHERE session_id = :session_id AND conversation_id = :conversation_id AND user_id = :user_id
                           ORDER BY created_at ASC");
    $stmt->execute([
        ':session_id'      => $sessionId,
        ':conversation_id' => $conversationId,
        ':user_id'         => $userId
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addChatMessage(PDO $pdo, $sessionId, $conversationId, $role, $content, $userId) {
    $stmt = $pdo->prepare("INSERT INTO chat_messages (session_id, conversation_id, role, content, user_id, created_at) 
                           VALUES (:session_id, :conversation_id, :role, :content, :user_id, NOW())");
    $stmt->execute([
        ':session_id'      => $sessionId,
        ':conversation_id' => $conversationId,
        ':role'            => $role,
        ':content'         => $content,
        ':user_id'         => $userId
    ]);
}

function chatWithQwen($client, PDO $pdo, $conversationId, $userInput, $userId) {
    addChatMessage($pdo, session_id(), $conversationId, 'user', $userInput, $userId);

    $conversationHistory = getConversationHistory($pdo, session_id(), $conversationId, $userId);
    $messages = [];
    $messages[] = [
        'role'    => 'system',
        'content' => 'You are a helpful keyword finder who helps people discover related keywords for their content and SEO strategy'
    ];
    foreach ($conversationHistory as $message) {
        $messages[] = [
            'role'    => $message['role'],
            'content' => $message['content']
        ];
    }

    try {
        $result = $client->chat()->create([
            'model'    => 'qwen-plus',
            'messages' => $messages
        ]);

        $assistantResponse = $result->choices[0]->message->content;
        addChatMessage($pdo, session_id(), $conversationId, 'assistant', $assistantResponse, $userId);
        return $assistantResponse;
    } catch (Exception $e) {
        $errorMsg = "Error: " . $e->getMessage();
        addChatMessage($pdo, session_id(), $conversationId, 'assistant', $errorMsg, $userId);
        return $errorMsg;
    }
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $userInput = trim($_POST['message']);
    if ($userInput !== '') {
        // Store the message in a session variable
        $_SESSION['pending_message'] = $userInput;
        // Redirect to the same page with the conversation ID
        header("Location: " . $_SERVER['PHP_SELF'] . "?conversation_id=" . urlencode($conversationId));
        exit;
    }
}

// Process pending message if it exists
if (isset($_SESSION['pending_message'])) {
    $userInput = $_SESSION['pending_message'];
    chatWithQwen($client, $pdo, $conversationId, $userInput, $userId);
    // Clear the pending message
    unset($_SESSION['pending_message']);
}

// Get chat history
$chatHistory = getConversationHistory($pdo, session_id(), $conversationId, $userId);

// Check if this is a new conversation without messages
$isNewConversation = empty($chatHistory);

// Get all conversations for this user
$stmt = $pdo->prepare("SELECT DISTINCT conversation_id FROM chat_messages WHERE user_id = :user_id ORDER BY MAX(created_at) DESC");
$stmt->execute([':user_id' => $userId]);
$conversations = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<?php $pageTitle = "AI Related Keyword"; ?>
<?php require_once 'layout/header.php'; ?>
   <!-- Sidebar -->
        <?php require_once 'layout/sidebar.php'; ?>

    <div id="mainContent" class="main-content h-screen md:p-4 overflow-hidden md:ml-64">
         <!-- Header -->
         <?php require_once 'layout/main-header.php'; ?> 


        <div class="flex flex-col glass-card pl-3 flex-1 h-screen">

            <!-- Header -->
            <div class="flex justify-between p-2 items-center border-b dark:border-none border-gray-700/50">
                <!-- Toggle Button for Mobile -->
                <button id="sidebar-toggle" onclick="toggleChatSidebar()"
                    class="md:hidden bg-cyan-500/80 px-2 py-1 rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow">
                    <i class="fas fa-bars"></i> <!-- Hamburger icon -->
                </button>
                <h1
                    class="text-2xl font-semibold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                    Related Keyword Finder </h1>
                <a href="?new=true"
                    class="bg-cyan-500/80 px-4 py-2 dark:text-white rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow">New
                    Search</a>
            </div>

            <div class="flex flex-1 gap-2">

                <!-- Main Chat Section (60% width) -->
                <main
                    class="flex-1 bg-gray-800 dark:bg-white flex flex-col overflow-hidden rounded border-gray-700 dark:border-gray-700 p-3 h-[80%] relative mb-10">

                    <!-- Content Area -->
                    <div id="chat-content" class="flex-1 overflow-y-auto scrollbar-thin py-4 space-y-4 <?php echo $isNewConversation ? 'hidden' : ''; ?>"
                        style="max-height: calc(100vh - 250px);">
                        <!-- Chat messages -->
                        <?php if (!empty($chatHistory)): ?>
                            <?php foreach ($chatHistory as $message): ?>
                                <?php if ($message['role'] === 'user'): ?>
                                <div class="flex justify-start items-start space-x-3 mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-user-circle text-2xl text-blue-400"></i>
                                    </div>
                                    <div class="message-user">
                                        <p><?php echo nl2br(htmlspecialchars($message['content'])); ?></p>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="flex justify-end items-start space-x-3 mb-4">
                                    <div class="message-assistant">
                                        <p><?php echo nl2br(htmlspecialchars($message['content'])); ?></p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-robot text-2xl text-cyan-400"></i>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Quick Start Cards (Visible by Default) -->
                    <div id="quick-start-cards" class="flex-1 overflow-y-auto mt-2 pb-2 md:pb-0 scrollbar-thin <?php echo !$isNewConversation ? 'hidden' : ''; ?>"
                        style="max-height: calc(100vh - 250px);">
                        <div class="grid grid-cols-1 gap-6 px-2">
                            <div class="flex flex-col">
                                <h2
                                    class="flex gap-x-2 self-start items-center text-lg font-semibold text-white dark:text-gray-800 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        class="h-6 w-6">
                                        <circle cx="12" cy="12" r="5"></circle>
                                        <path
                                            d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42">
                                        </path>
                                    </svg> Examples
                                </h2>

                                <div class="md:flex space-y-4 md:space-y-0 md:gap-x-4">
                                    <div class="p-3 glass-card dark:border-black dark:bg-white rounded-lg hover:shadow-xl transition-all duration-300 cursor-pointer"
                                        onclick="startChat('Find related keywords for digital marketing')">
                                        <p class="text-gray-400 text-sm dark:text-gray-800">Find related keywords for digital marketing</p>
                                    </div>
                                    <div class="p-3 glass-card dark:border-black dark:bg-white rounded-lg hover:shadow-xl transition-all duration-300 cursor-pointer"
                                        onclick="startChat('Suggest SEO keywords for a coffee shop website')">
                                        <p class="text-gray-400 text-sm dark:text-gray-800">
                                            Suggest SEO keywords for a coffee shop website</p>
                                    </div>
                                    <div class="p-3 glass-card dark:border-black dark:bg-white rounded-lg hover:shadow-xl transition-all duration-300 cursor-pointer"
                                        onclick="startChat('Generate long-tail keywords for fitness blog')">
                                        <p class="text-gray-400 text-sm dark:text-gray-800">Generate long-tail keywords for fitness blog</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <h2
                                    class="flex gap-x-2 self-start items-center text-lg font-semibold text-white dark:text-gray-800 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                        stroke-width="1.5" aria-hidden="true" class="h-6 w-6 mb-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5z"></path>
                                    </svg>
                                    Capabilities
                                </h2>
                                <div class="md:flex space-y-4 md:space-y-0 md:gap-x-4">
                                    <div class="p-3 glass-card dark:border-black dark:bg-white rounded-lg shadow-md">
                                        <p class="text-gray-400 text-sm dark:text-gray-800">Discover trending keywords in any niche</p>
                                    </div>
                                    <div class="p-3 glass-card dark:border-black dark:bg-white rounded-lg shadow-md">
                                        <p class="text-gray-400 text-sm dark:text-gray-800">Generate keyword clusters for content planning</p>
                                    </div>
                                    <div class="p-3 glass-card dark:border-black dark:bg-white rounded-lg shadow-md">
                                        <p class="text-gray-400 text-sm dark:text-gray-800">Analyze search intent for keyword optimization</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sticky bottom-0 flex items-center gap-x-2">
                        <form method="POST" class="w-full flex items-center gap-x-2">
                            <!-- Custom Expanding Input -->
                            <div id="chat-input" contenteditable="true" role="textbox" name="message-editable"
                                class="md:w-[93%] w-[82%] min-h-[4rem] dark:text-black min-w-[15ch] p-3 rounded-xl bg-transparent text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300 placeholder:text-gray-400"
                                data-placeholder="Enter a topic or keyword..."></div>
                            
                            <!-- Hidden input to hold the actual value -->
                            <input type="hidden" id="hidden-message" name="message" value="">

                            <!-- Send Button with Icon -->
                            <button type="submit" id="send-button" onclick="prepareSubmit()"
                                class="relative flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-cyan-400 to-blue-600 hover:from-cyan-300 hover:to-blue-500 hover:shadow-cyan-400/60 hover:scale-110 transition-all duration-300">
                                <i class="fas fa-paper-plane text-white text-xl"></i> <!-- Send Icon -->
                            </button>
                        </form>
                    </div>


                </main>

                <!-- Sidebar (40% width) -->
                <aside id="chatSidebar"
                    class="chatSidebar md:w-1/3 bg-gray-800 dark:bg-white md:relative border-r hidden rounded border-gray-700 backdrop-blur-md p-4 md:flex h-[80%] flex-col">
                    <!-- Fixed Search Bar -->
                    <div class="sticky top-0 bg-gray-800/70 dark:bg-white backdrop-blur-md z-10">
                        <input type="text" id="search-conversation" placeholder="Search..."
                            class="w-full p-2 rounded-lg bg-gray-700/50 dark:text-black dark:bg-white dark:border-black text-white border border-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500  dark:focus:ring-black transition-all duration-300">
                    </div>

                    <!-- Conversations List -->
                    <div class="mt-4 overflow-y-auto scrollbar-thin" style="max-height: calc(100vh - 280px);">
                        <?php foreach ($conversations as $conv):
                            $isActive = ($conv === $conversationId);
                        ?>
                        <div class="p-2 rounded-lg cursor-pointer hover:bg-gray-700/40 transition-all duration-300 flex items-center justify-between space-x-3 <?php echo $isActive ? 'bg-gray-700/30' : ''; ?>">
                            <a href="?conversation_id=<?php echo urlencode($conv); ?>" class="flex items-center space-x-3 flex-grow">
                                <i class="fas fa-search text-blue-400 text-lg"></i>
                                <span class="text-white text-sm truncate dark:text-black">Search #<?php echo substr($conv, 0, 8); ?></span>
                            </a>
                            <a href="?delete=<?php echo urlencode($conv); ?>" class="text-red-500 hover:text-red-300" onclick="return confirm('Are you sure you want to delete this conversation?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <script>
        // Function to toggle chat sidebar on mobile
        function toggleChatSidebar() {
            const sidebar = document.getElementById('chatSidebar');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('absolute', 'top-0', 'left-0', 'w-3/4', 'h-full', 'z-50');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('absolute', 'top-0', 'left-0', 'w-3/4', 'h-full', 'z-50');
            }
        }

        // Function to prepare form submission
        function prepareSubmit() {
            const chatInput = document.getElementById('chat-input');
            const hiddenInput = document.getElementById('hidden-message');
            hiddenInput.value = chatInput.innerText.trim();
            
            // Hide quick start cards and show chat content
            document.getElementById('quick-start-cards').classList.add('hidden');
            document.getElementById('chat-content').classList.remove('hidden');
        }
        
        // Function to start a chat from a quick-start card
        function startChat(message) {
            const chatInput = document.getElementById('chat-input');
            const hiddenInput = document.getElementById('hidden-message');
            
            chatInput.innerText = message;
            hiddenInput.value = message;
            
            // Submit the form
            prepareSubmit();
            document.getElementById('send-button').closest('form').submit();
        }
        
        // Event listener for pressing Enter in the input field
        document.getElementById('chat-input').addEventListener('keypress', (event) => {
            if (event.key === "Enter" && !event.shiftKey) {
                event.preventDefault();
                prepareSubmit();
                document.getElementById('send-button').closest('form').submit();
            }
        });
        
        // Auto-scroll chat to bottom
        document.addEventListener('DOMContentLoaded', function() {
            const chatContent = document.getElementById('chat-content');
            if (chatContent) {
                chatContent.scrollTop = chatContent.scrollHeight;
            }
            
            // Filter conversations with search
            document.getElementById('search-conversation').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                document.querySelectorAll('#chatSidebar .rounded-lg').forEach(conv => {
                    const text = conv.querySelector('span').textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        conv.style.display = 'flex';
                    } else {
                        conv.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>
<?php //require_once 'layout/footer.php'; ?>
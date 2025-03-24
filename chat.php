<?php
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

$userId = $_SESSION['google_email'];

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

function getConversationTitle(PDO $pdo, $conversationId, $userId) {
    // Get first user message as the conversation title, truncate if needed
    $stmt = $pdo->prepare("SELECT content FROM chat_messages 
                          WHERE conversation_id = :conversation_id AND user_id = :user_id AND role = 'user'
                          ORDER BY created_at ASC LIMIT 1");
    $stmt->execute([
        ':conversation_id' => $conversationId,
        ':user_id'         => $userId
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $title = $result['content'];
        return (strlen($title) > 30) ? substr($title, 0, 27) . '...' : $title;
    }
    
    return 'New Conversation';
}

function addChatMessage(PDO $pdo, $sessionId, $conversationId, $role, $content, $userId) {
    $stmt = $pdo->prepare("INSERT INTO chat_messages (session_id, conversation_id, role, content, user_id) 
                           VALUES (:session_id, :conversation_id, :role, :content, :user_id)");
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
        'content' => 'You are a helpful Blog writer who helps people create engaging content'
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

// Modified POST handling with PRG pattern
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

// Retrieve conversation history and conversations list
$chatHistory = getConversationHistory($pdo, session_id(), $conversationId, $userId);
$stmt = $pdo->prepare("SELECT DISTINCT conversation_id FROM chat_messages WHERE user_id = :user_id ORDER BY MAX(created_at) DESC");
$stmt->bindValue(':user_id', $userId);
$stmt->execute();
$conversations = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Check if this is a new conversation without messages
$isNewConversation = empty($chatHistory);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coreho Chat AI</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="styles/custom.css">
    <style>
        #chat-input:empty:before {
            content: attr(data-placeholder);
            color: #9ca3af;
            pointer-events: none;
            display: block;
        }
        
        /* Custom scrollbar styles */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(31, 41, 55, 0.5);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.8);
        }
        
        /* Glass card effect */
        .glass-card {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Glow effect */
        .glow {
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.3);
        }
        
        /* Dark mode adjustments */
        .dark .glass-card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        body {
            background-color: #111827;
            background-image: 
                radial-gradient(at 0% 0%, rgba(29, 78, 216, 0.15) 0, transparent 50%),
                radial-gradient(at 100% 0%, rgba(124, 58, 237, 0.15) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.15) 0, transparent 50%),
                radial-gradient(at 0% 100%, rgba(239, 68, 68, 0.15) 0, transparent 50%);
            background-attachment: fixed;
        }

        /* Message styling */
        .message-user {
            border-radius: 1rem;
            padding: 0.75rem 1rem;
            max-width: 80%;
            margin-left: auto;
            background: linear-gradient(to right, #3b82f6, #2563eb);
            color: white;
        }
        
        .message-assistant {
            border-radius: 1rem;
            padding: 0.75rem 1rem;
            max-width: 80%;
            margin-right: auto;
            background: rgba(31, 41, 55, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e5e7eb;
        }
    </style>
</head>

<body class="text-white">
    <!-- Sidebar -->
    <?php require_once 'layout/sidebar.php'; ?>
    <div id="mainContent" class="main-content h-screen md:p-4 overflow-hidden md:ml-0">
         <!-- Header -->
         <?php require_once 'layout/main-header.php'; ?> 

        <div class="flex flex-col glass-card pl-3 flex-1 h-screen">
            <!-- Header -->
            <div class="flex justify-between p-2 items-center border-b dark:border-none border-gray-700/50">
                <!-- Toggle Button for Mobile -->
                <button id="sidebar-toggle" onclick="toggleChatSidebar()"
                    class="md:hidden bg-cyan-500/80 px-2 py-1 rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow">
                    <i class="fas fa-bars"></i>
                </button>
                <h1
                    class="text-2xl font-semibold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                    Coreho Chat AI </h1>
                <a href="new_chat.php"
                    class="bg-cyan-500/80 px-4 py-2 dark:text-white rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow">New
                    Chat</a>
            </div>

            <div class="flex flex-1">
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
                                        <img src="assets/images/user.png" alt="User" class="w-8 h-8 rounded-full">
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
                                    <div class="flex-shrink-0 rounded-full border">
                                        <img src="assets/images/ai.svg" alt="AI" class="w-8 h-8 rounded-full">
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Quick Start Cards (Visible by Default for new conversations) -->
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
                                        onclick="startChat('Write a blog post about digital marketing trends in 2025')">
                                        <p class="text-gray-400 text-sm dark:text-gray-800">Write a blog post about digital marketing trends in 2025</p>
                                    </div>
                                    <div class="p-3 glass-card dark:border-black dark:bg-white rounded-lg hover:shadow-xl transition-all duration-300 cursor-pointer"
                                        onclick="startChat('Create a social media strategy for a new coffee shop')">
                                        <p class="text-gray-400 text-sm dark:text-gray-800">
                                            Create a social media strategy for a new coffee shop</p>
                                    </div>
                                    <div class="p-3 glass-card dark:border-black dark:bg-white rounded-lg hover:shadow-xl transition-all duration-300 cursor-pointer"
                                        onclick="startChat('Help me create an email newsletter template for my business')">
                                        <p class="text-gray-400 text-sm dark:text-gray-800">Help me create an email newsletter template for my business</p>
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
                                        <p class="text-gray-400 text-sm dark:text-gray-800">Create engaging blog content for any niche</p>
                                    </div>
                                    <div class="p-3 glass-card dark:border-black dark:bg-white rounded-lg shadow-md">
                                        <p class="text-gray-400 text-sm dark:text-gray-800">Help develop content strategies and calendars</p>
                                    </div>
                                    <div class="p-3 glass-card dark:border-black dark:bg-white rounded-lg shadow-md">
                                        <p class="text-gray-400 text-sm dark:text-gray-800">Generate SEO-friendly article ideas</p>
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
                                data-placeholder="Ask me anything..."></div>
                            
                            <!-- Hidden input to hold the actual value -->
                            <input type="hidden" id="hidden-message" name="message" value="">

                            <!-- Send Button with Icon -->
                            <button type="submit" id="send-button" onclick="prepareSubmit()"
                                class="relative flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-cyan-400 to-blue-600 hover:from-cyan-300 hover:to-blue-500 hover:shadow-cyan-400/60 hover:scale-110 transition-all duration-300">
                                <i class="fas fa-paper-plane text-white text-xl"></i>
                            </button>
                        </form>
                    </div>
                </main>

                <!-- Sidebar (40% width) -->
                <aside id="chatSidebar"
                    class="chatSidebar md:w-1/3 bg-gray-800 dark:bg-white md:relative border-r hidden rounded border-gray-700 backdrop-blur-md p-4 md:flex h-[80%] flex-col">
                    <!-- Fixed Search Bar -->
                    <div class="sticky top-0 bg-gray-800/70 dark:bg-white backdrop-blur-md z-10">
                        <input type="text" id="search-conversation" placeholder="Search conversations..."
                            class="w-full p-2 rounded-lg bg-gray-700/50 dark:text-black dark:bg-white dark:border-black text-white border border-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-black transition-all duration-300">
                    </div>

                    <!-- Scrollable Chat Titles -->
                    <div class="mt-4 overflow-x-hidden overflow-y-auto scrollbar-thin"
                        style="max-height: calc(100vh - 280px);">
                        <?php foreach ($conversations as $conv): 
                            $title = getConversationTitle($pdo, $conv, $userId);
                            $isActive = ($conv === $conversationId);
                        ?>
                        <div class="p-2 rounded-lg cursor-pointer hover:bg-gray-700/40 transition-all duration-300 flex items-center justify-between space-x-3 <?php echo $isActive ? 'bg-gray-700/30' : ''; ?>">
                            <a href="?conversation_id=<?php echo urlencode($conv); ?>" class="flex items-center space-x-3 flex-grow">
                                <i class="fas fa-comment text-blue-400 text-lg"></i>
                                <span class="text-white text-sm truncate dark:text-black"><?php echo htmlspecialchars($title); ?></span>
                            </a>
                            <button class="delete-btn text-red-500 hover:text-red-300" data-conversation-id="<?php echo htmlspecialchars($conv); ?>">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <script>
        // Function to toggle sidebar on mobile
        function toggleChatSidebar() {
    const sidebar = document.getElementById('chatSidebar');
    if (sidebar.classList.contains('w-0')) {
        sidebar.classList.remove('w-0');
        sidebar.classList.add('w-3/4');
    } else {
        sidebar.classList.remove('w-3/4');
        sidebar.classList.add('w-0');
    }
}
        
        // Function to prepare form submission
        function prepareSubmit() {
            const chatInput = document.getElementById('chat-input');
            const hiddenInput = document.getElementById('hidden-message');
            hiddenInput.value = chatInput.innerText.trim();
        }
        
        // Function to start a chat from a quick-start card
        function startChat(message) {
            const chatInput = document.getElementById('chat-input');
            const hiddenInput = document.getElementById('hidden-message');
            
            chatInput.innerText = message;
            hiddenInput.value = message;
            
            // Submit the form
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
            
            // Add event listeners to delete buttons
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const convId = this.getAttribute('data-conversation-id');
                    deleteConversation(convId);
                });
            });
            
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
        
        // Function to delete a conversation
        function deleteConversation(convId) {
            if (confirm('Are you sure you want to delete this conversation?')) {
                window.location.href = 'delete_conversation.php?conversation_id=' + encodeURIComponent(convId);
            }
        }
    </script>
</body>

</html>
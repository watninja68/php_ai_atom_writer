<?php
// Start session and include dependencies
session_start();
include 'db_init.php';
require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$yourApiKey = $_ENV['QWEN_API'];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

/**
 * Store a chat message in the database including conversation_id.
 */
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

/**
 * Call the Qwen API with the user query and store the messages.
 * Since you don't need a conversation history, we'll use a fixed conversation ID.
 */
function chatWithQwen($client, PDO $pdo, $conversationId, $userInput, $userId) {
    // Save the user's query
    addChatMessage($pdo, session_id(), $conversationId, 'user', $userInput, $userId);
    
    // Prepare a minimal messages array (no conversation history)
    $messages = [
        ['role' => 'system', 'content' => 'You are a helpful AI assistant that provides trending topic insights.'],
        ['role' => 'user',   'content' => $userInput]
    ];
    
    try {
        $result = $client->chat()->create([
            'model'    => 'qwen-plus',
            'messages' => $messages
        ]);
        $assistantResponse = $result->choices[0]->message->content;
        // Save the assistant's reply
        addChatMessage($pdo, session_id(), $conversationId, 'assistant', $assistantResponse, $userId);
        return $assistantResponse;
    } catch (Exception $e) {
        $errorMsg = "Error: " . $e->getMessage();
        addChatMessage($pdo, session_id(), $conversationId, 'assistant', $errorMsg, $userId);
        return $errorMsg;
    }
}

// Use a fixed conversation id (since conversation history isn't needed)
$conversationId = 'default';

$aiResponse = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $userInput = trim($_POST['query']);
    if ($userInput !== "") {
        $client = OpenAI::factory()
            ->withApiKey($yourApiKey)
            ->withBaseUri('https://dashscope-intl.aliyuncs.com/compatible-mode/v1')
            ->make();
        $aiResponse = chatWithQwen($client, $pdo, $conversationId, $userInput, $_SESSION['google_email']);
    }
}
?>
<?php $pageTitle = "One Click Article"; ?>
<?php require_once 'layout/header.php'; ?>
   <!-- Sidebar -->
        <?php require_once 'layout/sidebar.php'; ?>

    <div id="mainContent" class="main-content h-screen md:p-4 overflow-hidden md:ml-64">
         <!-- Header -->
         <?php require_once 'layout/main-header.php'; ?> 
        <div class="p-2">
            <div class="mb-4">
                <h1 class="text-2xl font-bold mb-2">One Click Article Wizard</h1>
                <p class="text-gray-400 dark:text-black">Your step-by-step guide to crafting great content</p>
            </div>

            <div class="flex flex-col md:flex-row flex-1 gap-2">

                <!-- Sidebar (40% width) -->
                <aside class="md:w-1/3 bg-gray-800 dark:bg-white relative rounded border-gray-700 py-4 px-1 flex md:h-[80%] min-h-72 flex-col">
                
                    <div class="sticky bottom-0 flex items-center gap-x-2">
                        <form method="POST" action="" class="w-full flex gap-x-2">
                            <input type="text" id="topic-input" name="query" placeholder="Enter keyword..."
                                class="md:w-[80%] w-[82%] min-h-[3rem] dark:text-gray-600 p-3 rounded-xl bg-transparent text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300 placeholder:text-gray-400"/>
                            <button type="submit" id="send-button"
                                class="relative flex items-center cursor-pointer justify-center w-12 h-12 rounded-full bg-gradient-to-r from-cyan-400 to-blue-600 hover:from-cyan-300 hover:to-blue-500 hover:shadow-cyan-400/60 hover:scale-110 transition-all duration-300">
                                <i class="fas fa-search text-white text-xl"></i>
                            </button>
                        </form>
                    </div>
                    <div id="chat-content" class="flex-1 overflow-y-auto scrollbar-thin py-4 space-y-4" style="max-height: calc(100vh - 250px);">
                        <?php
                        // Fetch chat messages from the database
                        $stmt = $pdo->prepare("SELECT * FROM chat_messages WHERE session_id = :session_id AND conversation_id = :conversation_id ORDER BY created_at ASC");
                        $stmt->execute([
                            ':session_id' => session_id(),
                            ':conversation_id' => $conversationId
                        ]);
                        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($messages as $message) {
                            $role = $message['role'];
                            $content = $message['content'];
                            $bgColor = $role === 'user' ? 'bg-gray-700/50' : 'bg-cyan-500/50';
                            $textColor = $role === 'user' ? 'text-white' : 'text-white';
                            $align = $role === 'user' ? 'self-start' : 'self-end';
                            echo "<div class='p-2 $bgColor $textColor backdrop-blur-md rounded-lg shadow-lg $align break-words'>
                                    <p>$content</p>
                                </div>";
                        }
                        ?>
                    </div>
                </aside>



                <main class="flex-1 bg-gray-800 dark:bg-white flex flex-col rounded overflow-hidden border-gray-700 p-3 h-[80%] relative mb-10">
                     <!-- Article Topic Form with chat functionality -->
            <form method="POST">
                <div id="step-content" class="space-y-6 md:w-full">
                    <div class="bg-white/10 dark:from-gray-400/10 dark:to-transparent p-6 rounded-xl shadow-md">
                        <h3 class="text-lg dark:text-black font-bold">Article Topic</h3>
                        <p class="text-gray-400 dark:text-black">Let's get started.</p>
                        <textarea name="message" class="w-full p-3 rounded-md bg-gray-700 border-gray-600 text-white mt-3" rows="4"
                            placeholder="A Small Description about the article..."></textarea>

                        <button id="next-btn" type="submit"
                            class="px-6 py-3 bg-cyan-600 my-3 hover:bg-cyan-500 text-white font-semibold rounded-lg shadow-lg">Create →</button>
                    </div>
                </div>
            </form>

            <!-- Display the conversation history (chat messages) below the form -->
            <?php if (!empty($chatHistory)): ?>
            <div id="chat-content" class="mt-8 space-y-4">
                <?php foreach ($chatHistory as $message): ?>
                    <?php if ($message['role'] === 'user'): ?>
                        <div class="message-user">
                            <p><?php echo nl2br(htmlspecialchars($message['content'])); ?></p>
                        </div>
                    <?php else: ?>
                        <div class="message-assistant">
                            <p><?php echo nl2br(htmlspecialchars($message['content'])); ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
                </main>
            </div>

        </div>
    </div>
    <?php require_once 'layout/footer.php'; ?>
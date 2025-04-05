<?php
// Start session and include dependencies
require_once __DIR__ . '/auth0_handler.php';

// Use the function from the handler to check authentication
if (!isAuthenticated()) {
    // Store the intended destination BEFORE redirecting to login
    $_SESSION['redirect_url_pending'] = $_SERVER['REQUEST_URI']; // Use a temporary key
    header('Location: login.php'); // Redirect to login page
    exit;
}

// If authenticated, the script continues...
// Use the centrally stored session variables
$userName = $_SESSION['user_name'] ?? 'User'; // Use session var set in callback
$userEmail = $_SESSION['user_email'] ?? ''; // Use session var set in callback
$userId = $_SESSION['user_id']; 

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
        $aiResponse = chatWithQwen($client, $pdo, $conversationId, $userInput, $_SESSION['user_id']);
    }
}
?>
<?php $pageTitle = "chat Trending Topic"; ?>
<?php require_once 'layout/header.php'; ?>

<!-- Sidebar -->
<?php require_once 'layout/sidebar.php'; ?>

<div id="mainContent" class="main-content h-screen md:p-4 overflow-hidden md:ml-64">
    <!-- Header -->
    <?php require_once 'layout/main-header.php'; ?> 

    <div class="flex flex-col glass-card pl-3 flex-1 h-screen">

        <!-- Header -->
        <div class="flex justify-between p-2 items-center border-b dark:border-none border-gray-700/50">
            <button id="sidebar-toggle" onclick="toggleChatSidebar()"
                class="md:hidden bg-cyan-500/80 px-2 py-1 rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="text-2xl font-semibold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                Trending Topic Finder </h1>
            <button onclick="fetchTrendingTopics()"
                class="bg-cyan-500/80 px-4 py-2 dark:text-white rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow">New
                Search</button>
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
                    $stmt = $pdo->prepare("SELECT * FROM 30ContentChat WHERE session_id = :session_id AND conversation_id = :conversation_id ORDER BY created_at ASC");
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

            <!-- Main Section (60% width) -->
            <main class="flex-1 bg-gray-800 dark:bg-white flex flex-col rounded overflow-hidden border-gray-700 p-3 h-[80%] relative mb-10">
                <div id="quick-start-cards" class="flex-1 overflow-y-auto mt-2 pb-2 md:pb-0 scrollbar-thin" style="max-height: calc(100vh - 250px);">
                    <div id="trending-topics" class="grid grid-cols-1 gap-6 px-2">
                        <?php
                        // Display the AI's response in the main section
                        if (!empty($aiResponse)) {
                            echo "<div class='p-3 bg-gray-700/50 dark:bg-gray-800/50 text-white rounded-lg shadow-md'>
                                    <h3 class='font-semibold'>AI Response</h3>
                                    <p>$aiResponse</p>
                                  </div>";
                        } else {
                            echo "<div class='p-3 bg-gray-700/50 dark:bg-gray-800/50 text-white rounded-lg shadow-md'>
                                    <h3 class='font-semibold'>No Response Yet</h3>
                                    <p>Enter a query to get started.</p>
                                  </div>";
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
<script>
    function handleKeyPress(event) {
    if (event.key === "Enter") {
        event.preventDefault(); // Prevents form submission (if inside a form)
        generateTopics();
    }
}
    async function fetchTrendingTopics() {
        document.getElementById("trending-topics").innerHTML = "Loading trending topics...";
        try {
            let response = await fetch('fetch_trending_topics.php'); // PHP script to fetch topics
            let data = await response.json();
            displayTrendingTopics(data);
        } catch (error) {
            console.error("Error fetching topics:", error);
        }
    }
    
    function generateTopics() {
        let keyword = document.getElementById("topic-input").value;
        if (!keyword.trim()) return;
        fetchTrendingTopics();
    }

    function displayTrendingTopics(topics) {
        let container = document.getElementById("trending-topics");
        container.innerHTML = "";
        topics.forEach(topic => {
            let div = document.createElement("div");
            div.className = "p-3 bg-gray-700/50 dark:bg-gray-800/50 text-white rounded-lg shadow-md";
            div.innerHTML = `<h3 class='font-semibold'>${topic.title}</h3><p>${topic.description}</p>`;
            container.appendChild(div);
        });
    }
</script>
<script src="scripts/script.js"></script>
</body>
</html>
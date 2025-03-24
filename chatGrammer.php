<?php
session_start();
include 'db_init.php';
require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$yourApiKey = $_ENV['QWEN_API'];

// Check if the user is logged in
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

/**
 * Save a chat message in the database including conversation_id.
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
 * Call the AI API to improve grammar.
 * We use a fixed conversation ID since no conversation history is needed.
 */
function grammarImprove($client, PDO $pdo, $conversationId, $userInput, $userId) {
    // Store the user's sentence
    addChatMessage($pdo, session_id(), $conversationId, 'user', $userInput, $userId);
    
    // Prepare the messages with a system prompt tailored for grammar improvement.
    $messages = [
        [
            'role'    => 'system',
            'content' => 'You are a grammar improvement assistant. Please improve the grammar of the following sentence.'
        ],
        [
            'role'    => 'user',
            'content' => $userInput
        ]
    ];
    
    try {
        $result = $client->chat()->create([
            'model'    => 'qwen-plus',
            'messages' => $messages
        ]);
        $assistantResponse = $result->choices[0]->message->content;
        // Store the improved sentence
        addChatMessage($pdo, session_id(), $conversationId, 'assistant', $assistantResponse, $userId);
        return $assistantResponse;
    } catch (Exception $e) {
        $errorMsg = "Error: " . $e->getMessage();
        addChatMessage($pdo, session_id(), $conversationId, 'assistant', $errorMsg, $userId);
        return $errorMsg;
    }
}

$conversationId = 'grammar_default';
$grammarResponse = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sentence'])) {
    $userInput = trim($_POST['sentence']);
    if ($userInput !== "") {
        $client = OpenAI::factory()
            ->withApiKey($yourApiKey)
            ->withBaseUri('https://dashscope-intl.aliyuncs.com/compatible-mode/v1')
            ->make();
        $grammarResponse = grammarImprove($client, $pdo, $conversationId, $userInput, $_SESSION['google_email']);
    }
}
?>
<?php $pageTitle = "AI Grammar Improvement"; ?>
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
          <i class="fas fa-bars"></i>
        </button>
        <h1 class="text-2xl font-semibold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
          Grammar Improvement
        </h1>
        <button class="bg-cyan-500/80 px-4 py-2 dark:text-white rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow">
          New Check
        </button>
      </div>
      <div class="flex flex-1 gap-2">
        <!-- Main Chat Section (60% width) -->
        <main class="flex-1 bg-gray-800 dark:bg-white flex flex-col rounded border-gray-700 dark:border-gray-700 p-3 h-[80%] relative mb-10">
          <!-- Content Area (Optional, if you wish to display messages dynamically) -->
          <div id="chat-content" class="flex-1 overflow-y-auto scrollbar-thin py-4 space-y-4 hidden"
            style="max-height: calc(100vh - 250px);">
            <!-- Chat messages can be appended here if desired -->
          </div>
          <!-- Quick Start Cards (Visible by Default) -->
          <div id="quick-start-cards" class="flex-1 overflow-y-auto mt-2 pb-2 md:pb-0 scrollbar-thin"
            style="max-height: calc(100vh - 250px);">
            <!-- Quick start content or instructions can be added here -->
          </div>
          <!-- Input Area -->
          <div class="sticky bottom-0 flex items-center gap-x-2">
            <!-- Form wrapping the contenteditable input -->
            <form method="POST" id="grammar-form" class="w-full flex items-center gap-x-2">
              <!-- Custom Expanding Input -->
              <div id="chat-input" contenteditable="true" role="textbox"
                class="md:w-[93%] w-[82%] min-h-[4rem] dark:text-black min-w-[15ch] p-3 rounded-xl bg-transparent text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300 placeholder:text-gray-400"
                data-placeholder="Enter a sentence to improve..."></div>
              <!-- Hidden input to store the actual sentence -->
              <input type="hidden" id="hidden-sentence" name="sentence" value="">
              <!-- Send Button with Icon -->
              <button type="submit" id="send-button"
                class="relative flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-cyan-400 to-blue-600 hover:from-cyan-300 hover:to-blue-500 hover:shadow-cyan-400/60 hover:scale-110 transition-all duration-300">
                <i class="fas fa-paper-plane text-white text-xl"></i>
              </button>
            </form>
          </div>
          <!-- Display AI Response -->
          <?php if (!empty($grammarResponse)): ?>
            <div class="mt-4 p-4 bg-gray-700/50 rounded-lg">
              <p class="text-white"><?php echo htmlspecialchars($grammarResponse); ?></p>
            </div>
          <?php endif; ?>
        </main>
        <!-- Sidebar (40% width) -->
        <aside id="chatSidebar" class="chatSidebar flex-1 bg-gray-800 dark:bg-white md:relative border-r  hidden rounded border-gray-700 backdrop-blur-md p-4 md:flex h-[80%] flex-col">
          <!-- Fixed Search Bar -->
          <div class="sticky top-0 bg-gray-800/70 dark:bg-white backdrop-blur-md z-10">
            <input type="text" placeholder="Search..."
              class="w-full p-2 rounded-lg bg-gray-700/50 dark:text-black dark:bg-white dark:border-black text-white border border-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-black transition-all duration-300">
          </div>
        </aside>
      </div>
    </div>
  </div>
  <script src="scripts/script.js"></script>
  <script>
    // Function to toggle sidebar on mobile devices.
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

    // Function to prepare and submit the form.
    document.getElementById('grammar-form').addEventListener('submit', function(e) {
      const chatInput = document.getElementById('chat-input');
      const hiddenInput = document.getElementById('hidden-sentence');
      hiddenInput.value = chatInput.innerText.trim();
    });
  </script>
</body>
</html>
<?php //require_once 'layout/footer.php'; ?>
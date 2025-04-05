<?php
// Start session and include dependencies
require_once __DIR__ . '/auth0_handler.php'; // Handles Auth0 authentication and session start
require_once __DIR__ . '/db_init.php';      // Defines $dsn, $dbUser, $dbPass
require_once __DIR__ . '/vendor/autoload.php'; // Composer autoload

use Dotenv\Dotenv;
use OpenAI\Client; // Alias for OpenAI client

// --- Authentication Check ---
// Uncomment this block to enforce login
 if (!isAuthenticated()) {
     $_SESSION['redirect_url_pending'] = $_SERVER['REQUEST_URI'];
     header('Location: login.php');
     exit;
 }

// --- Get Authenticated User Info ---
$userName = $_SESSION['user_name'] ?? 'User';
$userEmail = $_SESSION['user_email'] ?? '';
$userId = $_SESSION['user_id'] ?? null; // Your internal DB user ID (should be set if authenticated)

// --- Load Environment Variables ---
try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $dotenv->required(['QWEN_API']); // Ensure API key is in .env
} catch (Exception $e) {
    error_log("Error loading .env file in oneClickArticle.php: " . $e->getMessage());
    die('Required environment variables are missing. Check logs.');
}
$yourApiKey = $_ENV['QWEN_API'];

// --- Database Connection (Optional - Only if saving results) ---
$pdo = null;
try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection failed in oneClickArticle.php (non-critical?): " . $e->getMessage());
    // Decide if the page can function without DB. For generation/display, it might.
    // die("Database service unavailable.");
}

// --- OpenAI Client Setup ---
$client = null;
try {
    $client = OpenAI::factory()
        ->withApiKey($yourApiKey)
        ->withBaseUri('https://dashscope-intl.aliyuncs.com/compatible-mode/v1') // Use the correct API endpoint
        ->make();
} catch(Exception $e) {
     error_log("Failed to create OpenAI client in oneClickArticle.php: " . $e->getMessage());
     die("AI Service configuration error. Please check logs.");
}

// --- Initialize AI Response and Error Variables ---
$aiResponse = null; // Use null to indicate no response generated yet
$errorMsg = null;   // To hold user-facing errors

// --- Handle POST Request for Article Generation ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['topic_description'], $_POST['keywords'])) {
    // Renamed 'message' to 'topic_description' for clarity
    $topic = trim($_POST['topic_description']);
    $keywords = trim($_POST['keywords']);

    if (!empty($topic) && $client) {
        // Construct a prompt specifically for article generation
        $prompt = "Write a comprehensive and engaging blog post about the topic: '{$topic}'. Please incorporate the following keywords naturally throughout the article: {$keywords}. The article should be well-structured with clear headings (e.g., using H2 or H3 markdown), paragraphs, and provide valuable information to the reader.";

        $messages = [
            [
                'role' => 'system',
                'content' => 'You are Coreho AI, an expert blog writer assistant designed by Coreho Solutions LLP. Your task is to generate high-quality, well-structured blog articles based on the provided topic and keywords.'
            ],
            [
                'role' => 'user',
                'content' => $prompt
            ]
        ];

        try {
            $result = $client->chat()->create([
                'model' => 'qwen-plus', // Confirm this is the correct model for long-form content
                'messages' => $messages,
                'temperature' => 0.7, // Adjust creativity vs. factuality
                // 'max_tokens' => 2000, // Limit response length if needed
            ]);

            $aiResponse = $result->choices[0]->message->content ?? 'Sorry, the AI could not generate a response at this time.';

            // --- Optional: Save the generated article ---
            /*
            if ($pdo && $aiResponse && $userId) {
                try {
                    // Make sure 'generated_articles' table exists with these columns
                    $stmt = $pdo->prepare("INSERT INTO generated_articles (user_id, topic, keywords, content, created_at) VALUES (:user_id, :topic, :keywords, :content, NOW())");
                    $stmt->execute([
                        ':user_id' => $userId,
                        ':topic' => $topic, // Use the topic variable
                        ':keywords' => $keywords,
                        ':content' => $aiResponse
                    ]);
                } catch (PDOException $e) {
                    error_log("Failed to save one-click article to DB: " . $e->getMessage());
                }
            }
            */
            // --- End Optional Save ---

        } catch (Exception $e) { // Catch potential API or network errors
            error_log("Error calling Qwen API in oneClickArticle.php: " . $e->getMessage());
            $errorMsg = "An error occurred while generating the article. Please check the application logs or try again later.";
            $aiResponse = ''; // Prevent displaying partial/old results on error
        }
    } elseif (empty($topic)) {
        $errorMsg = "Please provide a topic description for the article.";
        $aiResponse = '';
    } elseif (!$client) {
         $errorMsg = "AI service is not configured correctly.";
         $aiResponse = '';
    }
}
?>

<?php $pageTitle = "One Click Article"; ?>
<?php require_once 'layout/header.php'; ?>

<!-- Sidebar -->
<?php require_once 'layout/sidebar.php'; ?>

<div id="mainContent" class="main-content flex-1 h-screen md:p-4 overflow-y-auto md:ml-64"> <!-- Changed overflow to auto for scrolling -->
    <!-- Header -->
    <?php require_once 'layout/main-header.php'; ?>

    <div class="p-2 md:p-4 space-y-8"> <!-- Added spacing -->
        <div class="mb-4">
            <h1 class="text-2xl font-bold mb-2 text-white dark:text-gray-800">One Click Article Wizard</h1>
            <p class="text-gray-400 dark:text-gray-600">Generate a full article from just a topic and keywords.</p>
        </div>

        <!-- Main Content Area -->
        <main class="flex-1 space-y-8">

            <!-- Topic and Keyword Input Form -->
            <div class="glass-card p-6 rounded-xl shadow-md border border-gray-700 dark:border-gray-200">
                 <h3 class="text-lg font-semibold mb-4 text-white dark:text-gray-800">Article Details</h3>

                 <?php if ($errorMsg): ?>
                    <div class="bg-red-500/20 border border-red-500 text-red-200 dark:text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline"><?php echo htmlspecialchars($errorMsg); ?></span>
                    </div>
                 <?php endif; ?>

                 <form method="POST" action="oneClickArticle.php">
                     <div class="space-y-4">
                         <div>
                            <label for="topic_description" class="block text-sm font-medium text-gray-300 dark:text-gray-700 mb-1">Article Topic / Description</label>
                            <textarea id="topic_description" name="topic_description" required class="w-full p-3 rounded-md bg-gray-700/50 dark:bg-gray-200 border border-gray-600 dark:border-gray-400 text-white dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all duration-300 placeholder:text-gray-400" rows="4"
                                placeholder="Enter a clear topic or a short description of the article you want..."><?php echo isset($_POST['topic_description']) ? htmlspecialchars($_POST['topic_description']) : ''; ?></textarea>
                         </div>
                         <div>
                            <label for="keywords" class="block text-sm font-medium text-gray-300 dark:text-gray-700 mb-1">Keywords (comma-separated)</label>
                            <input type="text" id="keywords" name="keywords" required
                                   class="w-full p-3 rounded-md bg-gray-700/50 dark:bg-gray-200 text-white dark:text-black border border-gray-600 dark:border-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all duration-300 placeholder:text-gray-400"
                                   placeholder="e.g., AI writing, content creation, blog automation"
                                   value="<?php echo isset($_POST['keywords']) ? htmlspecialchars($_POST['keywords']) : ''; ?>">
                         </div>
                         <div class="text-center pt-2">
                             <button type="submit"
                                class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-cyan-400/40 transition-all duration-300 transform hover:scale-105 glow">
                                <i class="fas fa-magic mr-2"></i> Generate Article
                             </button>
                         </div>
                     </div>
                 </form>
            </div>

            <!-- Generated Article Display Area -->
            <div id="response-section" class="glass-card p-6 rounded-xl shadow-md border border-gray-700 dark:border-gray-200 <?php echo ($aiResponse === null && !$errorMsg) ? 'hidden' : ''; ?>">
                 <h2 class="text-xl font-semibold mb-4 text-white dark:text-gray-800">Generated Article</h2>
                 <div id="ai-response" class="prose prose-invert dark:prose-dark max-w-none text-gray-300 dark:text-gray-700 space-y-4">
                    <?php
                    if ($aiResponse !== null && $aiResponse !== '') {
                        // Apply Markdown-like formatting
                        $formattedResponse = htmlspecialchars($aiResponse);
                        $formattedResponse = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $formattedResponse); // Bold
                        $formattedResponse = preg_replace('/__(.*?)__/s', '<strong>$1</strong>', $formattedResponse); // Bold (alt)
                        $formattedResponse = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $formattedResponse);       // Italic
                        $formattedResponse = preg_replace('/_(.*?)_/s', '<em>$1</em>', $formattedResponse);         // Italic (alt)
                        $formattedResponse = preg_replace('/`(.*?)`/s', '<code class="bg-gray-600 dark:bg-gray-300 px-1 rounded text-sm">$1</code>', $formattedResponse); // Inline code

                        // Handle headings more robustly (match start of line)
                        $formattedResponse = preg_replace('/^### (.*?)$/m', '<h4>$1</h4>', $formattedResponse);
                        $formattedResponse = preg_replace('/^## (.*?)$/m', '<h3>$1</h3>', $formattedResponse);
                        $formattedResponse = preg_replace('/^# (.*?)$/m', '<h2>$1</h2>', $formattedResponse);

                        // Convert line breaks into paragraphs, handling lists better
                        $lines = explode("\n", $formattedResponse);
                        $finalOutput = '';
                        $inList = false;
                        foreach ($lines as $line) {
                            $trimmedLine = trim($line);
                            if (empty($trimmedLine)) {
                                if ($inList) {
                                    $finalOutput .= "</ul>\n"; // Close list on empty line
                                    $inList = false;
                                }
                                continue; // Skip empty lines for paragraph logic
                            }

                            // Basic list detection (lines starting with * or -)
                            if (preg_match('/^[\*\-] (.*)/', $trimmedLine, $matches)) {
                                if (!$inList) {
                                    $finalOutput .= "<ul>\n";
                                    $inList = true;
                                }
                                $finalOutput .= "<li>" . trim($matches[1]) . "</li>\n";
                            } else {
                                if ($inList) {
                                    $finalOutput .= "</ul>\n"; // Close list if line is not a list item
                                    $inList = false;
                                }
                                // Wrap non-heading, non-list lines in <p> tags
                                if (!preg_match('/^<h[2-4]>/', $trimmedLine) && !preg_match('/^<code/', $trimmedLine)) {
                                     $finalOutput .= '<p>' . $trimmedLine . '</p>' . "\n"; // Use trimmed line
                                } else {
                                    $finalOutput .= $trimmedLine . "\n"; // Output heading/code as is
                                }
                            }
                        }
                        if ($inList) {
                            $finalOutput .= "</ul>\n"; // Close list if it's the last element
                        }

                        echo $finalOutput;

                    } elseif ($aiResponse === '') { // Explicitly check for empty string response
                         echo "<p class='text-gray-500'>The AI generated an empty response. Try refining your topic or keywords.</p>";
                    } elseif (!$errorMsg) { // Only show placeholder if no error and no response yet
                        echo "<p class='text-gray-500'>Your generated article will appear here...</p>";
                    }
                    ?>
                </div>
            </div>
        </main> <!-- End Main Content Area -->
    </div> <!-- End Padding Div -->
</div> <!-- End Flex Container -->

<?php require_once 'layout/footer.php'; ?>
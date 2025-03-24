<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="styles/custom.css">
    <style>
        @keyframes draw {
            from {
                stroke-dashoffset: 100;
            }

            to {
                stroke-dashoffset: 40;
            }
        }

        .animate-draw {
            animation: draw 2s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-in forwards;
        }
    </style>
</head>

<body class="text-white">
    <div class="flex flex-col md:flex-row">

        <!-- Sidebar Placeholder -->
        <div id="sidebar-placeholder"></div>

        <!-- Main Content -->
        <main id="mainContent" class="main-content h-screen overflow-hidden flex-1 md:ml-64 ">

            <!-- Main Page -->
            <div class="md:flex overflow-y-auto h-[calc(100vh-110px)]">

                <!-- Main Content -->
                <main class="flex-1 p-2 flex flex-col ">
                    <nav class="flex">
                        <ul class="flex items-center justify-center gap-3">
                            <li><button onclick="switchTab('editorTab')"
                                    class="block w-full text-left text-sm p-2 rounded bg-gray-700 dark:text-white hover:bg-gray-600">Editor</button>
                            </li>
                            <li><button onclick="switchTab('metaTab')"
                                    class="block w-full text-left p-2 text-sm rounded dark:hover:bg-gray-300 dark:text-black hover:bg-gray-700">Meta</button>
                            </li>
                            <li><button onclick="switchTab('settingsTab')"
                                    class="block w-full text-left p-2 text-sm rounded dark:hover:bg-gray-300 dark:text-black hover:bg-gray-700">Settings</button>
                            </li>
                        </ul>
                    </nav>
                    <div class="flex justify-between items-center border-b border-gray-700 pb-3">
                        <input type="text" id="docTitle"
                            class="bg-transparent text-xl font-semibold outline-none w-full">
                        <div class="flex space-x-2">
                            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Save</button>
                            <button class="px-3 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-6.52 6.52a2.25 2.25 0 01-3.182 0l-1.47-1.47a2.25 2.25 0 010-3.182l6.52-6.52m4.243-4.243a4.5 4.5 0 016.364 0 4.5 4.5 0 010 6.364l-1.5 1.5">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Editor Tab -->
                    <div id="editorTab"
                        class="tab-content mt-6 bg-gray-800 p-2 rounded-lg flex-1 border border-gray-700 relative">
                        <!-- Toolbar -->
                        <div class="flex space-x-2 mb-3 p-2 bg-gray-700 rounded-lg overflow-x-auto">
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">B</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">I</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">U</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">🔗</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">🖼️</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">📎</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">📝</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">🔤</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">🔍</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">⚙️</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">🖋️</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">📑</button>
                            <button
                                class="p-2 bg-gray-600 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-600 dark:text-black rounded">📌</button>
                        </div>

                        <div class="h-96 w-full dark:bg-white dark:text-blue-700 bg-gray-900 overflow-hidden overflow-y-auto p-4 rounded-lg text-gray-300"
                            contenteditable="true">
                            <p class="italic">Start writing here...</p>
                        </div>
                    </div>

                    <!-- Meta Tab -->
                    <div id="metaTab"
                        class="tab-content mt-6 dark:bg-white dark:text-blue-700 bg-gray-900 p-4 rounded-lg flex-1 border border-gray-700 hidden">
                        <h3 class="text-lg font-semibold">Meta Information</h3>
                        <p class="text-gray-300 mt-2">Here you can add meta descriptions, tags, and other document
                            metadata.</p>
                    </div>

                    <!-- Settings Tab -->
                    <div id="settingsTab"
                        class="tab-content mt-6 dark:bg-white dark:text-blue-700 bg-gray-900 p-4 rounded-lg flex-1 border border-gray-700 hidden">
                        <h3 class="text-lg font-semibold">Settings</h3>
                        <p class="text-gray-300 mt-2">Adjust editor settings, themes, and preferences here.</p>
                    </div>
                </main>

                <!-- SEO Section -->
                <aside
                    class="md:w-1/3 m-3 mb-6 md:mb-4 md:m-1 rounded-lg p-5 border border-gray-700 shadow-lg relative overflow-hidden transform transition-all">
                    <!-- Floating Animated Glow -->
                    <div
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-cyan-400 rounded-full blur-2xl opacity-20 animate-pulse">
                    </div>

                    <div class="flex border-b text-xs justify-between border-gray-600 mb-4">
                        <button
                            class="tab-button px-4 py-2 dark:text-black text-white font-semibold focus:outline-none focus:border-cyan-400 border-b-2 border-transparent hover:border-cyan-400 dark:hover:border-black flex items-center gap-2"
                            data-tab="seo">
                            <i class="fa fa-tags"></i> SEO/NLP
                        </button>
                        <button
                            class="tab-button px-4 py-2 dark:text-black text-white font-semibold focus:outline-none border-b-2 border-transparent hover:border-cyan-400 dark:hover:border-black flex items-center gap-2"
                            data-tab="ai">
                            <i class="fa fa-robot"></i> AI History
                        </button>
                        <button
                            class="tab-button px-4 py-2 dark:text-black text-white font-semibold focus:outline-none border-b-2 border-transparent hover:border-cyan-400 dark:hover:border-black transition-all flex items-center gap-2"
                            data-tab="chat">
                            <i class="fa fa-comments"></i> Chat
                        </button>
                    </div>

                    <div id="seo" class="tab-content-sidebar h-screen">

                        <input type="text" placeholder="Focus Keyword"
                            class="w-full p-3 bg-gray-700 rounded-lg border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 transition duration-300">

                        <div class="mt-6 text-center">
                            <h4 class="text-base font-medium dark:text-black text-gray-300">Content Score</h4>
                            <div class="relative w-24 h-24 mx-auto">
                                <svg class="absolute transform -rotate-90" width="100%" height="100%"
                                    viewBox="0 0 36 36">
                                    <path class="text-gray-600 dark:text-black" stroke-width="3" fill="none"
                                        d="M18 2 A16 16 0 1 1 18 34 A16 16 0 1 1 18 2" />
                                    <path class="text-gradient animate-draw" stroke-width="3" fill="none"
                                        stroke-linecap="round" style="stroke: url(#gradient);"
                                        d="M18 2 A16 16 0 1 1 18 34 A16 16 0 1 1 18 2" stroke-dasharray="10 100"
                                        stroke-dashoffset="100" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-sm font-normal text-cyan-400 animate-fade-in">
                                        <span class="text-xl font-bold">40</span>/100
                                    </span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-black mt-2">Suggested: 80+</p>
                        </div>
                        <svg width="0" height="0">
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color: #FF3D00; stop-opacity: 1" />
                                    <stop offset="100%" style="stop-color: #00BFFF; stop-opacity: 1" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <!--  Scrollable SEO Checklist -->
                        <div class="mt-6 md:max-h-[35%] overflow-y-auto p-2">
                            <h4 class="text-sm font-semibold text-gray-400 dark:text-black mb-2">SEO Issues</h4>
                            <ul class="text-xs flex flex-col gap-5">
                                <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                                    <span class="dark:text-black">Key terms & Keyword Density</span>
                                    <span class="font-bold text-red-400">
                                        <i class="fa fa-exclamation-circle mr-2"></i> 2 Critical
                                    </span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                                    <span class="dark:text-black">Content Depth</span>
                                    <span class="font-bold text-yellow-400">
                                        <i class="fa fa-exclamation-triangle mr-2"></i> 7 Minor
                                    </span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                                    <span class="dark:text-black">H1 Heading</span>
                                    <span class="font-bold text-red-400">
                                        <i class="fa fa-exclamation-circle mr-2"></i> 3 Critical
                                    </span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                                    <span class="dark:text-black">H2-H6 Headings</span>
                                    <span class="font-bold text-red-400">
                                        <i class="fa fa-exclamation-circle mr-2"></i> 2 Critical
                                    </span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                                    <span class="dark:text-black">Meta Tags</span>
                                    <span class="font-bold text-red-400">
                                        <i class="fa fa-exclamation-circle mr-2"></i> 4 Critical
                                    </span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                                    <span class="dark:text-black">Featured Snippet</span>
                                    <span class="font-bold text-red-400">
                                        <i class="fa fa-exclamation-circle mr-2"></i> 1 Critical
                                    </span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                                    <span class="dark:text-black">Links</span>
                                    <span class="font-bold text-yellow-400">
                                        <i class="fa fa-exclamation-triangle mr-2"></i> 1 Minor
                                    </span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                                    <span class="dark:text-black">URL</span>
                                    <span class="font-bold text-red-400">
                                        <i class="fa fa-exclamation-circle mr-2"></i> 1 Critical
                                    </span>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <!--  AI History Content -->
                    <div class="tab-content-sidebar h-screen hidden" id="ai">
                        <h3 class="text-lg font-bold dark:text-black text-white mb-4">AI History</h3>
                        <p class="text-gray-300 dark:text-black text-sm">AI has evolved rapidly, from rule-based systems
                            to deep
                            learning...</p>
                    </div>

                    <!-- Chat Content -->
                    <div class="tab-content-sidebar h-screen hidden" id="chat">
                        <h3 class="text-lg font-bold dark:text-black text-white mb-4">Chat</h3>

                        <div class="sticky bottom-0 flex items-center gap-x-2">

                            <!-- Custom Expanding Input -->
                            <div id="chat-input" contenteditable="true" role="textbox"
                                class="md:w-[80%] w-[80%] min-h-[4rem] min-w-[15ch] p-3 rounded-xl bg-transparent text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300 placeholder:text-gray-400"
                                data-placeholder="Ask me anything..."></div>

                            <!-- Send Button with Icon -->
                            <button id="send-button" onclick="sendMessage()"
                                class="relative flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-cyan-400 to-blue-600 hover:from-cyan-300 hover:to-blue-500 hover:shadow-cyan-400/60 hover:scale-110 transition-all duration-300">
                                <i class="fas fa-paper-plane text-white text-xl"></i> <!-- Send Icon -->
                                <span class="absolute inset-0 bg-cyan-500 blur-lg opacity-50 rounded-full"></span>
                            </button>

                        </div>


                        <div class="mt-6 max-h-[45%] overflow-y-auto p-2">
                            <h4 class="text-sm font-semibold dark:text-black text-gray-400 mb-2">No chat History Yet
                            </h4>

                        </div>
                    </div>
                </aside>


            </div>


        </main>
    </div>

    <script src="scripts/script.js"></script>
    <script>
        function updateTime() {
            const date = new Date();
            document.getElementById("docTitle").value = `Cole's Document ${date.toLocaleString()}`;
        }
        setInterval(updateTime, 1000);

        function updateScore() {
            let score = 10;
            setInterval(() => {
                if (score < 80) {
                    score += 5;
                    document.getElementById("score-bar").style.width = score + "%";
                    document.getElementById("score-text").innerText = score + "%";
                }
            }, 2000);
        }
        window.onload = updateScore;

        function switchTab(tabName) {
            document.querySelectorAll(".tab-content").forEach(el => el.classList.add("hidden"));
            document.getElementById(tabName).classList.remove("hidden");
        }


        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll(".tab-button");
            const contents = document.querySelectorAll(".tab-content-sidebar");

            tabs.forEach(tab => {
                tab.addEventListener("click", function () {
                    // Remove active state from all tabs
                    tabs.forEach(t => t.classList.remove("border-cyan-400"));
                    this.classList.add("border-cyan-400");

                    // Hide all content sections
                    contents.forEach(content => content.classList.add("hidden"));

                    // Show the selected tab content
                    const selectedTab = this.getAttribute("data-tab");
                    document.getElementById(selectedTab).classList.remove("hidden");
                });
            });

            // Set default active tab
            tabs[0].classList.add("border-cyan-400");
        });
    </script>
</body>

</html>
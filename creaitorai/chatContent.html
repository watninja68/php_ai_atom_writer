<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="styles/custom.css">
    <script>

    </script>
    <style>
        #chat-input:empty:before {
            content: attr(data-placeholder);
            color: #9ca3af;
            /* Light gray */
            pointer-events: none;
            display: block;
        }
                /* Typewriter effect */
                @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: white; }
        }
        .typewriter {
            
            border-right: 0.15em solid white; /* Cursor effect */
            animation: typing 3s steps(40, end), blink-caret 0.75s step-end infinite;
        }
    </style>
</head>

<body class="text-white">


    <!-- Sidebar Placeholder -->
    <div id="sidebar-placeholder"></div>


    <div id="mainContent" class="main-content h-screen md:p-4 overflow-hidden md:ml-64">

        <div class="flex flex-col glass-card px-3 flex-1 md:h-screen">

            <!-- Header -->
            <div class="flex justify-between p-2 items-center border-b dark:border-none border-gray-700/50">

                <h1
                    class="md:text-2xl font-semibold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                    30 Days Content Calendar Maker </h1>
            </div>

            <div class="flex flex-col md:flex-row flex-1 gap-2">


                <!-- Sidebar (40% width) -->
                <aside id="chatSidebar"
                    class="md:w-1/3 bg-gray-800 dark:bg-white relative rounded border-gray-700 backdrop-blur-md py-4 px-1 flex md:h-[80%] min-h-72 flex-col">

                    <!-- Content Area -->
                    <div id="chat-content" class="flex-1 overflow-y-auto scrollbar-thin py-4 space-y-4"
                        style="max-height: calc(100vh - 250px);">

                        <!-- Chat messages will be dynamically added here -->
                        <!-- Default Prompt -->
                            <div class="p-2 bg-gray-700/50 dark:bg-gray-800/50 text-sm backdrop-blur-md rounded-lg shadow-lg self-start break-words">
                                <p class="dark:text-white"><span id="default-prompt" class="typewriter"></span></p>
                            </div>
                     
                    </div>

                  

                    <div class="sticky bottom-0 flex items-center gap-x-2">

                        <!-- Custom Expanding Input -->
                        <div id="chat-input" contenteditable="true" role="textbox" onpaste="handlePaste(event)"
                            class="md:w-[80%] w-[82%] min-h-[5rem] max-h-56 overflow-x-hidden overflow-y-auto dark:text-black min-w-[15ch] p-3 rounded-xl bg-transparent text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300 placeholder:text-gray-400"
                            data-placeholder="Describe your content needs..."></div>

                        <!-- Send Button with Icon -->
                        <button id="send-button" onclick="sendMessage()"
                            class="relative flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-cyan-400 to-blue-600 hover:from-cyan-300 hover:to-blue-500 hover:shadow-cyan-400/60 hover:scale-110 transition-all duration-300">
                            <i class="fas fa-paper-plane text-white text-xl"></i> <!-- Send Icon -->

                        </button>

                    </div>
                </aside>

                <!-- Main Chat Section (60% width) -->
                <main
                    class="flex-1 bg-gray-800 dark:bg-white flex flex-col rounded overflow-hidden rounded border-gray-700 dark:border-gray-700 p-3 h-[80%] relative mb-10">

                    <!-- Quick Start Cards (Visible by Default) -->
                    <div id="quick-start-cards" class="flex-1 overflow-y-auto mt-2 pb-2 md:pb-0 scrollbar-thin"
                        style="max-height: calc(100vh - 250px);">
                        <div class="grid grid-cols-1 gap-6 px-2">

                        </div>
                    </div>


                </main>


            </div>
        </div>
    </div>

    <script src="scripts/script.js"></script>
    <script>


        // Function to simulate typewriter effect
        function typeWriter(element, text, speed = 40) {
            let i = 0;
            element.innerHTML = ""; // Clear the element
            const interval = setInterval(() => {
                if (i < text.length) {
                    // Replace \n with <br> for line breaks
                    if (text.charAt(i) === '\n') {
                        element.innerHTML += '<br>';
                    } else {
                        element.innerHTML += text.charAt(i);
                    }
                    i++;
                } else {
                    clearInterval(interval);
                }
            }, speed);
        }

        // Default prompt with typewriter effect
        const defaultPrompt = `Hi! I'm here to help you plan your content calendar. Here are some things you can ask me:\n\n1. Suggest content ideas for Day 1.\n2. What should I post on Instagram this week?\n3. Generate a 30-day content plan for my fitness blog.\n4. Help me schedule posts for my YouTube channel.\n\nFeel free to ask me anything!`;
        const promptElement = document.getElementById('default-prompt');
        typeWriter(promptElement, defaultPrompt);


        // Function to add a message to the chat content area
        function addMessage(sender, message) {
            const chatContent = document.getElementById('chat-content');
            const messageElement = document.createElement('div');

            // User message
            if (sender === 'You') {
                messageElement.className = 'flex justify-end space-x-3';
                messageElement.innerHTML = `
                   
                    <div class="p-2 bg-blue-600/80 text-sm backdrop-blur-md rounded-lg shadow-lg self-end max-w-[80%] break-words">
                        <p class="text-white dark:text-black">${message}</p>
                    </div>
                `;
            }
            // AI message
            else {
                messageElement.className = '';
                messageElement.innerHTML = `
                    <div class="p-2 bg-gray-700/50 dark:bg-gray-800/50 text-sm backdrop-blur-md rounded-lg shadow-lg self-start break-words">
                        <p class="text-white" class="typewriter"> ${message}</p>
                    </div>
                `;
            }

            chatContent.appendChild(messageElement);
            // Scroll to the bottom of the chat content
            chatContent.scrollTop = chatContent.scrollHeight;
        }


        // Function to handle sending a message
        function sendMessage() {
            const chatInput = document.getElementById('chat-input');
            const message = chatInput.innerText.trim();
            document.getElementById('quick-start-cards').classList.add('hidden');
            document.getElementById('chat-content').classList.remove('hidden');

            if (message) {
                // Add user's message to the chat
                addMessage('You', message);

                // Simulate AI response (replace with actual API call in a real app)
                setTimeout(() => {
                    addMessage('AI', `Here’s your 30-day content calendar for: "${message}"`);
                }, 1000);

                // Clear the input field
                chatInput.innerText = ""; // Clear input
                chatInput.style.height = "auto"; // Reset height
            }
        }


        // Event listener for the send button
        document.getElementById('send-button').addEventListener('click', sendMessage);

        // Event listener for pressing Enter in the input field
        document.getElementById('chat-input').addEventListener('keypress', (event) => {
            if (event.key === "Enter" && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        });


        function handlePaste(event) {
            event.preventDefault(); // Prevent default paste behavior

            // Get the pasted content as plain text
            let pasteData = (event.clipboardData || window.clipboardData).getData("text");

            // Insert plain text at cursor position
            document.execCommand("insertText", false, pasteData);
        }
    </script>
</body>

</html>
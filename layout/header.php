<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'My Website'; ?></title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="styles/output.css">
    <!-- <link rel="stylesheet" href="styles/custom.css"> -->
    <script>
    // Check dark mode preference before the page renders
    // Function to apply dark mode on page load (if previously enabled)
    function applyDarkModePreference() {
    const htmlElement = document.documentElement;
    const body = document.body;

    // Check localStorage for saved preference
    const darkModePreference = localStorage.getItem("darkMode");
    if (darkModePreference === "enabled") {
        htmlElement.classList.add("dark");
        body.classList.add("dark-mode");
        document.querySelector(".profile-dropdown").classList.add("dark-mode");
        document.getElementById("toggle").checked = true;
    }
    
    }

    // Run applyDarkModePreference() when the page loads
    document.addEventListener("DOMContentLoaded", applyDarkModePreference);
  </script>
    <style>
        #chat-input:empty:before {
            content: attr(data-placeholder);
            color: #9ca3af;
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
            border-right: 0.15em solid white;
            animation: typing 3s steps(40, end), blink-caret 0.75s step-end infinite;
        }
        


        

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
<body  class="text-white">
<!-- class="bg-gradient-to-br from-[#0f172a] to-[#1e293b] text-white font-[Nunito] dark:from-gray-900 dark:to-gray-800 dark:text-gray-200" -->
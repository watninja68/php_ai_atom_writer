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

input,
button,
select,
textarea {
   font: inherit;
}

img {
   display: block;
   max-width: 100%;
}

.editor {
   padding-top: 3rem;
   padding-bottom: 5rem;
   padding-left: 5vw;
   padding-right: 5vw;
   height: 100%;
   overflow-y: auto;
   background-color: #efefef;
   &::-webkit-scrollbar {
      width: 15px;
      background-color: #efefef;
   }

   &::-webkit-scrollbar-thumb {
      width: 5px;
      border-radius: 99em;
      background-color: #cdcdcd;
      border: 5px solid #efefef;
   }
}


.editor-textarea {
   margin-top: -1px;
   border: 1px solid #ddd;
   padding: 0.75em;
}

.editor-toolbar {
   background-color: #fff;
   border: 1px solid #ddd;
   padding: 0.5rem;
   display: flex;
   flex-wrap: wrap;
   top: calc(-3rem - 1px);
   position: sticky;
   z-index: 200;
   align-items: center;
}

.editor-toolbar-item {
   background-color: transparent;
   border: 0;
   display: inline-flex;
   align-items: center;
   justify-content: center;

   border-radius: 6px;
   transition: 0.15s ease;

   &.icon {
      width: 2rem;
      height: 2rem;
      color: black;
   }

   &.dropdown {
      min-width: 150px;
      justify-content: space-between;
      color:black;
      height: 2rem;
   }

   svg {
      width: 1.25rem;
      height: 1.25rem;
   }
   &:hover {
      background-color: #ededed;
   }
}

.separator {
   height: 1rem;
   width: 2px;
   background-color: #DDD;
   display: block;
   margin-left: .625rem;
   margin-right: .625rem;
}

.editor-textarea {
   background-color: #fff;
   min-height: 50vh;
   max-width: 100%;
   padding: 0;
   overflow: hidden;
}

.editor-textarea-editable {
   padding: 3em 0;
   padding-left: 5vw;
   padding-right: 5vw;
   line-height: 1.65;
   & > * + * {
      margin-top: 1em;
   }

   h1 {
      font-size: 2rem;
      font-weight: 500;
      line-height: 1.25;
   }

   h2 {
      font-weight: 500;
      line-height: 1.375;
      font-size: 1.5rem;
   }

   ul {
      list-style: square;
      margin-left: 40px;
      li {
         & + li {
            margin-top: .5em;
         }
      }
   }

   em {
      font-style: italic;
   }

   strong {
      font-weight: 600;
   }

   img {
      max-width: 50%;
      float: left;
      margin-right: 1em;
      margin-top: 1em;
      margin-bottom: 1em;
      transition: 0.15s ease;
      cursor: pointer;
      &:hover {
         box-shadow: 0 0 0 4px #3f5efb;
      }
   }

   a {
      color: #3f5efb;
      text-decoration: none;
      box-shadow: 0 2px 0 0 currentcolor;
      font-weight: 600;
   }

   .leading {
      font-size: 1.25rem;
      font-weight: 500;
      color: #565656;
   }
}



.button {
   display: inline-flex;
   align-items: center;
   border: 0;
   padding: 0.375em 0.75em;
   border-radius: 4px;
   background-color: transparent;
   cursor: pointer;
   border-bottom: 1px solid;
   margin-right: 0.5rem;
   transition: .25s ease;
   font-weight: 500;
   svg {
      margin-right: 0.375em;
      width: 1.25em;
      height: 1.25em;
   }

   &--save {
      background-color: #e0e4fa;
      color: #2f47be;
      &:hover {
         color: #e0e4fa;
         background-color: #2f47be;
      }
   }

   &--schedule {
      background-color: #ece0fa;
      color: #722fbe;
      &:hover {
         color: #ece0fa;
         background-color: #722fbe;
      }
   }

   &--publish {
      background-color: #8ae2b6;
      color: #22744b;
      &:hover {
         color: #8ae2b6;
         background-color: #22744b;
      }
   }

   &--delete {
      background-color: #fdc8bf;
      color: #bd1717;
      &:hover {
         color: #fdc8bf;
         background-color: #bd1717;
      }
   }
}

.input-url {
   color: #3f5efb;
   font-size: 0.875rem;
}

.input-image {
   padding: 0;
   border: 1px solid #ddd;
   background-color: #fff;
   border-radius: 0 0 4px 4px;
   border-bottom-width: 2px;
   cursor: pointer;
   transition: 0.15s ease;
   &:hover {
      border-color: #3f5efb;
   }
}

.input-image-wrapper {
   width: calc(100% + 2px);
   margin-top: -1px;
   margin-left: -1px;
   overflow: hidden;
		display: block;
}

.input-checkbox {
   display: flex;
   align-items: center;
   cursor: pointer;
   & + * {
      margin-top: 0.75rem;
   }
}

.input-checkbox-box {
   clip: rect(0 0 0 0);
   clip-path: inset(100%);
   height: 1px;
   overflow: hidden;
   position: absolute;
   white-space: nowrap;
   width: 1px;

   &:checked + .input-checkbox-toggle {
      background-color: #3f5efb;
      border-color: #3f5efb;
      &:after {
         background-color: #fff;
         transform: translateX(100%);
      }
   }
}

.input-checkbox-toggle {
   position: relative;
   display: inline-block;
   width: 32px;
   height: 20px;
   border-radius: 99em;
   border: 1px solid #999;
   margin-right: 0.375rem;
   &:after {
      content: "";
      position: absolute;
      top: 3px;
      left: 3px;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background-color: #999;
   }
}

:focus {
   outline: 0;
}
 </style>
</head>

<body class="text-white">
  <div class="flex flex-col md:flex-row">

    <!-- Sidebar Placeholder -->
    <div id="sidebar-placeholder"></div>

    <!-- Main Content -->
    <main id="mainContent" class="main-content flex-1 md:ml-64 md:p-6">

      <!-- Breadcrumb -->
      <nav class="flex pb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
          <li>
            <div class="flex items-center">
              <!-- <i class="fas fa-chevron-right text-gray-400"></i> -->
              <a href="#" class="ml-2 text-sm font-medium dark:text-black text-gray-300 hover:text-white">
                Editor</a>
            </div>
          </li>
        </ol>
      </nav>

      <!-- Main Page -->
     
          <div class="grid grid-cols-[1fr] h-[calc(100vh-205px)]">
            <form class="editor">
              <div class="editor-toolbar">
                <button class="editor-toolbar-item icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 9.5C8.5 9.5 11.5 9.5 15 9.5C15.1615 9.5 19 9.5 19 13.5C19 18 15.2976 18 15 18C12 18 10 18 7 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8.5 13C7.13317 11.6332 6.36683 10.8668 5 9.5C6.36683 8.13317 7.13317 7.36683 8.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
      
                </button>
                <button class="editor-toolbar-item icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 9.5C15.5 9.5 12.5 9.5 9 9.5C8.83847 9.5 5 9.5 5 13.5C5 18 8.70237 18 9 18C12 18 14 18 17 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M15.5 13C16.8668 11.6332 17.6332 10.8668 19 9.5C17.6332 8.13317 16.8668 7.36683 15.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </button>
                <span class="separator"></span>
                <button class="editor-toolbar-item dropdown">
                  <span>Paragraph</span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <polyline points="208 96 128 176 48 96" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline>
                  </svg>
                </button>
                <span class="separator"></span>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <path d="M64,120h88a40,40,0,0,1,0,80l-88.00586-.00488v-152L140,48a36,36,0,0,1,0,72" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                  </svg>
                </button>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <line x1="151.99414" y1="55.99512" x2="103.99414" y2="199.99512" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="63.99414" y1="199.99512" x2="143.99414" y2="199.99512" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="111.99414" y1="55.99512" x2="191.99414" y2="55.99512" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                  </svg>
      
                </button>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <line x1="40" y1="128" x2="216" y2="128" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <g>
                      <path d="M76.334,96.00294A25.48209,25.48209,0,0,1,75.11111,88c0-22.09139,21.96094-40,52.88889-40,23.77865,0,42.25677,10.58606,49.529,25.52014" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                      <path d="M72,168c0,22.09139,25.07205,40,56,40s56-17.90861,56-40c0-23.76634-21.62275-32.97043-45.59723-40.00076" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                    </g>
                  </svg>
      
                </button>
                <span class="separator"></span>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <rect x="40" y="40" width="176" height="176" rx="8" stroke-width="16" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" fill="none"></rect>
                    <path d="M215.99982,159.99982l-42.343-42.343a8,8,0,0,0-11.3137,0l-44.6863,44.6863a8,8,0,0,1-11.3137,0l-20.6863-20.6863a8,8,0,0,0-11.3137,0L40,176" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                    <circle cx="100" cy="92" r="12"></circle>
                  </svg>
                </button>
      
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <line x1="94.05511" y1="161.93204" x2="161.93736" y2="94.04979" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <path d="M144.96473,178.9102l-28.28427,28.28427a48,48,0,0,1-67.88225-67.88225L77.08248,111.028" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                    <path d="M178.91069,144.96424,207.195,116.68a48,48,0,0,0-67.88225-67.88225L111.02844,77.082" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                  </svg>
                </button>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <path d="M200,224.00005H55.99219a8,8,0,0,1-8-8V40a8,8,0,0,1,8-8L152,32l56,56v128A8,8,0,0,1,200,224.00005Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                    <polyline points="152 32 152 88 208.008 88" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline>
                    <line x1="96" y1="136" x2="160" y2="136" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="96" y1="168" x2="160" y2="168" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                  </svg>
                </button>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <rect x="44" y="44" width="168" height="168" rx="8" stroke-width="16" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" fill="none"></rect>
                    <line x1="128" y1="44" x2="128" y2="212" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="212" y1="128" x2="44" y2="128" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                  </svg>
                </button>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <path d="M24,60H152a32,32,0,0,1,32,32v96a8,8,0,0,1-8,8H48a32,32,0,0,1-32-32V68A8,8,0,0,1,24,60Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                    <polyline points="184 112 240 80 240 176 184 144" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline>
                  </svg>
                </button>
                <span class="separator"></span>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <polyline points="64 88 16 128 64 168" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline>
                    <polyline points="192 88 240 128 192 168" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline>
                    <line x1="160" y1="40" x2="96" y2="216" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                  </svg>
                </button>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <path d="M108,144H40a8,8,0,0,1-8-8V72a8,8,0,0,1,8-8h60a8,8,0,0,1,8,8v88a40,40,0,0,1-40,40" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                    <path d="M224,144H156a8,8,0,0,1-8-8V72a8,8,0,0,1,8-8h60a8,8,0,0,1,8,8v88a40,40,0,0,1-40,40" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                  </svg>
                </button>
                <span class="separator"></span>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <line x1="88" y1="64" x2="216" y2="64" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="88.00614" y1="128" x2="216" y2="128" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="88.00614" y1="192" x2="216" y2="192" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <circle cx="44" cy="64" r="12"></circle>
                    <circle cx="44" cy="128" r="12"></circle>
                    <circle cx="44" cy="192" r="12"></circle>
                  </svg>
                </button>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <line x1="104" y1="128" x2="215.99902" y2="128" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="104" y1="64" x2="215.99902" y2="64" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="103.99902" y1="192" x2="215.99902" y2="192" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <polyline points="40 60 56 52 56 107.994" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline>
                    <path d="M41.10018,152.55059A14.00226,14.00226,0,1,1,65.609,165.82752L40,200H68" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                  </svg>
                </button>
                <span class="separator"></span>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <line x1="40" y1="68" x2="216" y2="68" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="40" y1="108" x2="168" y2="108" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="40.00614" y1="148" x2="216" y2="148" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="40.00614" y1="188" x2="168" y2="188" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                  </svg>
                </button>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <line x1="40" y1="68" x2="216" y2="68" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="64" y1="108" x2="192" y2="108" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="40.00307" y1="148" x2="215.99693" y2="148" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="64.00307" y1="188" x2="191.99693" y2="188" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                  </svg>
                </button>
                <button class="editor-toolbar-item icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#000000" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"></rect>
                    <line x1="40" y1="68" x2="216" y2="68" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="88" y1="108" x2="216" y2="108" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="40.00614" y1="148" x2="216" y2="148" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="88.00614" y1="188" x2="216" y2="188" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                  </svg>
                </button>
              </div>
              <div class="editor-textarea">
                <div class="editor-textarea-editable" contenteditable spellcheck="false">
                  <h1>What web designers can learn from artists - from Van Gogh to Lloyd Wright</h1>
                  <p class="leading">Art in it's classic form, like painting and sculpting, is not
                    that different to the creations of web and UI designers. Even though their
                    purpose is different - as the goal of great web design is to enhance user
                    experiences - there's still a lot to learn from the former.</p>
                  <p>By now you may have been intruiged to read this article, but I'm sorry to inform
                    you that this is not some 'Medium-like-inspirational-design-take-kind-of-story'.
                    This is just an article full of gibberish, written in a way that makes it look
                    <img src="https://assets.codepen.io/285131/painting.jpg" />like a real article, but it's not. It's sole
                    purpose is to look good in this
                    CodePen demo, this CMS design concept. The image has also nothing to do with the
                    accompanied text, it's just a filler like everything else. You see, I feel it's
                    sometimes better to use 'real' text rather than 'Lorem Ipsum'. However, this
                    text is not <em>real</em>. Well, of course it's <strong>real</strong>, since
                    someone has written it (me), but it's not a real blog post.
                  </p>
                  <p>For designers it's important, or even necessary to, use real data instead of
                    'Lorem ipsum'. Sure, the latin excerpt is popular, but the problem is that you
                    don't understand what it says there. This is not just a problem for articles,
                    but for UI in general. How do you think the site structure on the left would
                    look like if I replaced 'Product' and 'Pricing' with 'Lorem Ipsum' and 'Dolor
                    Sit'? Doesn't give you the right impression, does it? And I know what you're
                    thinking: 'Product' and 'Pricing' isn't real data either, it's just made up
                    names of pages. That's true - but it's still better than the alternative. Also,
                    after all, this is just a pen, and this design is just a concept. But it looks
                    legit, right?</p>
                  <h2>Why 'Form Follows Function' is a valid rule to live by in web design</h2>
                  <p>Use text that your client provides. Give your UI good labels, labels that are actually going to be used in production. There's several reasons as to why it's better to use real data instead of 'Lorem Ipsum':
                  </p>
      
                  <ul>
                    <li>It's more readable (obviously)</li>
                    <li>You stress test your designs, meaning that you'll become more aware of errors caused by line-breaks and text overflow.</li>
                    <li>It's more fun and rewarding, since you've designed something that looks <em>real</em></li>
                  </ul>
                  <p>
                    Don't read to much into this, though. This article was never meant to convince you to stop using 'Lorem Ipsum', this is in fact just an article full of gibberish.</p>
      
                  <h2>More filler content</h2>
                  <p>I could've easily written about how you make potato salad without potatoes, or written a fairytale about potato salad princes and potato salad princesses, instead.
                  </p>
                </div>
              </div>
            </form>
          </div>
        </main>

   
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
</script>
</body>

</html>
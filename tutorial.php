<?php $pageTitle = "Tutorial"; ?>
<?php require_once 'layout/header.php'; ?>
  
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <?php require_once 'layout/sidebar.php'; ?>
        <!-- Main Content -->
        <main id="mainContent" class="main-content flex-1 md:p-6">
            <!-- Header -->
        <?php require_once 'layout/main-header.php'; ?> 
        
            <!-- Breadcrumb -->
            <?php include 'breadcrumb.php'; ?>

            <div class="container mx-auto">
                <!-- Video Preview Section -->
                <div
                    class="bg-gradient-to-br from-gray-900 to-gray-800 p-4 rounded-2xl shadow-2xl mb-8 hover:shadow-3xl">
                    <h2
                        class="text-xl font-bold mb-4 flex items-center gap-2 text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">
                        <span class="text-blue-500 text-lg">▶️</span> Now Playing
                    </h2>

                    <div
                        class="relative w-full aspect-video overflow-hidden rounded-2xl border-2 border-gray-700 hover:border-cyan-500 transition-all">
                        <iframe id="videoPlayer"
                            class="w-full h-full rounded-2xl transform scale-100 transition-transform"
                            src="https://www.youtube.com/embed/OEV8gMkCHXQ" allowfullscreen loading="lazy">
                        </iframe>
                    </div>
                </div>

                <!-- Tutorials Sections -->
                <div class="space-y-8">
                    <!-- Section: Getting Started Guide -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4">🚀 Getting Started Guide</h2>
                        <div class="flex overflow-x-auto gap-4 pb-4 scrollbar-hide">
                            <!-- Video 1 -->
                            <div class="video-card flex-shrink-0 cursor-pointer bg-gray-800 p-3 rounded-lg shadow-md hover:bg-gray-700 transition-all"
                                data-video="https://www.youtube.com/embed/qz0aGYrrlhU">
                                <img src="https://img.youtube.com/vi/qz0aGYrrlhU/0.jpg" alt="Thumbnail"
                                    class="rounded-lg w-48 h-28 md:w-64 md:h-36 object-cover">
                                <p class="mt-2 text-sm text-gray-300">Introduction to Web Development</p>
                            </div>
                            <!-- Video 2 -->
                            <div class="video-card flex-shrink-0 cursor-pointer bg-gray-800 p-3 rounded-lg shadow-md hover:bg-gray-700 transition-all"
                                data-video="https://www.youtube.com/embed/OEV8gMkCHXQ">
                                <img src="https://img.youtube.com/vi/OEV8gMkCHXQ/0.jpg" alt="Thumbnail"
                                    class="rounded-lg w-48 h-28 md:w-64 md:h-36 object-cover">
                                <p class="mt-2 text-sm text-gray-300">Introduction to Web Development</p>
                            </div>
                            <!-- Video 3 -->
                            <div class="video-card flex-shrink-0 cursor-pointer bg-gray-800 p-3 rounded-lg shadow-md hover:bg-gray-700 transition-all"
                                data-video="https://www.youtube.com/embed/qz0aGYrrlhU">
                                <img src="https://img.youtube.com/vi/qz0aGYrrlhU/0.jpg" alt="Thumbnail"
                                    class="rounded-lg w-48 h-28 md:w-64 md:h-36 object-cover">
                                <p class="mt-2 text-sm text-gray-300">Introduction to Web Development</p>
                            </div>

                        </div>
                    </div>


                <!-- Tutorials Sections -->
                <div class="space-y-8">
                    <!-- Section: Getting Started Guide -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4">🔥 Advanced Concepts</h2>
                        <div class="flex overflow-x-auto gap-4 pb-4 scrollbar-hide">
                            <!-- Video 1 -->
                            <div class="video-card flex-shrink-0 cursor-pointer bg-gray-800 p-3 rounded-lg shadow-md hover:bg-gray-700 transition-all"
                                data-video="https://www.youtube.com/embed/8aGhZQkoFbQ">
                                <img src="https://img.youtube.com/vi/8aGhZQkoFbQ/0.jpg" alt="Thumbnail"
                                    class="rounded-lg w-48 h-28 md:w-64 md:h-36 object-cover">
                                <p class="mt-2 text-sm text-gray-300">Introduction to Web Development</p>
                            </div>
                            <!-- Video 2 -->
                            <div class="video-card flex-shrink-0 cursor-pointer bg-gray-800 p-3 rounded-lg shadow-md hover:bg-gray-700 transition-all"
                                data-video="https://www.youtube.com/embed/9emXNzqCKyg">
                                <img src="https://img.youtube.com/vi/9emXNzqCKyg/0.jpg" alt="Thumbnail"
                                    class="rounded-lg w-48 h-28 md:w-64 md:h-36 object-cover">
                                <p class="mt-2 text-sm text-gray-300">Introduction to Web Development</p>
                            </div>
                            <!-- Video 3 -->
                            <div class="video-card flex-shrink-0 cursor-pointer bg-gray-800 p-3 rounded-lg shadow-md hover:bg-gray-700 transition-all"
                                data-video="https://www.youtube.com/embed/OEV8gMkCHXQ">
                                <img src="https://img.youtube.com/vi/OEV8gMkCHXQ/0.jpg" alt="Thumbnail"
                                    class="rounded-lg w-48 h-28 md:w-64 md:h-36 object-cover">
                                <p class="mt-2 text-sm text-gray-300">Introduction to Web Development</p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>





        </main>
    </div>
    <?php require_once 'layout/footer.php'; ?>
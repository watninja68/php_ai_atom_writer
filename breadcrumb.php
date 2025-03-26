<?php
// Define breadcrumbs for different pages based on your sidebar navigation
$breadcrumbs = [
    'dashboard.php' => [
        ['title' => 'Dashboard', 'link' => 'dashboard.php', 'icon' => 'fas fa-tachometer-alt']
    ],
    'guidedArticle.php' => [
        ['title' => 'Blog Wizard', 'link' => '#', 'icon' => 'fas fa-magic'],
        ['title' => 'Guided Content Creation', 'link' => 'guidedArticle.php']
    ],
    'oneClickArticle.php' => [
        ['title' => 'Blog Wizard', 'link' => '#', 'icon' => 'fas fa-magic'],
        ['title' => 'One Click Content Creation', 'link' => 'oneClickArticle.php']
    ],
    'aiassistance.php' => [
        ['title' => 'AI Assistance', 'link' => 'aiassistance.php', 'icon' => 'fas fa-robot']
    ],
    'aichat.php' => [
        ['title' => 'AI Chat', 'link' => 'aichat.php', 'icon' => 'fas fa-comments']
    ],
    'chatContent.php' => [
        ['title' => 'Productivity', 'link' => '#', 'icon' => 'fas fa-tasks'],
        ['title' => '30 days Content Maker', 'link' => 'chatContent.php']
    ],
    'chatRelatedKeyword.php' => [
        ['title' => 'Productivity', 'link' => '#', 'icon' => 'fas fa-tasks'],
        ['title' => 'Related Keywords Finder', 'link' => 'chatRelatedKeyword.php']
    ],
    'chatGrammer.php' => [
        ['title' => 'Productivity', 'link' => '#', 'icon' => 'fas fa-tasks'],
        ['title' => 'Grammar Improvement', 'link' => 'chatGrammer.php']
    ],
    'chatGenerator.php' => [
        ['title' => 'Productivity', 'link' => '#', 'icon' => 'fas fa-tasks'],
        ['title' => 'AI Prompt Generator', 'link' => 'chatGenerator.php']
    ],
    'chatTrending.php' => [
        ['title' => 'Productivity', 'link' => '#', 'icon' => 'fas fa-tasks'],
        ['title' => 'Trending Topic Finder', 'link' => 'chatTrending.php']
    ],
    'gift.php' => [
        ['title' => 'Gift and Offer', 'link' => 'gift.php', 'icon' => 'fas fa-gift']
    ],
    'tutorial.php' => [
        ['title' => 'Tutorial', 'link' => 'tutorial.php', 'icon' => 'fas fa-graduation-cap']
    ],
    'editor.php' => [
        ['title' => 'Editor', 'link' => 'editor.php', 'icon' => 'fas fa-edit']
    ],
    'output.php' => [
        ['title' => 'Output', 'link' => 'output.php', 'icon' => 'fas fa-file-export']
    ],
    'affiliate.php' => [
        ['title' => 'Earn as an Affiliate', 'link' => 'affiliate.php', 'icon' => 'fas fa-hand-holding-usd']
    ],
    'support.php' => [
        ['title' => 'Support Ticket', 'link' => 'support.php', 'icon' => 'fas fa-ticket-alt']
    ],
    'contactus.php' => [
        ['title' => 'Contact Us', 'link' => 'contactus.php', 'icon' => 'fas fa-envelope']
    ]
];

// Get the current page name
$currentPage = basename($_SERVER['PHP_SELF']);

// Find the breadcrumb path for the current page
$currentBreadcrumbs = $breadcrumbs[$currentPage] ?? [['title' => 'Dashboard', 'link' => 'dashboard.php', 'icon' => 'fas fa-tachometer-alt']];
?>

<!-- Breadcrumb -->
<nav class="flex pb-6 justify-between" aria-label="Breadcrumb">
    <ol class="inline-flex self-start items-center space-x-1 md:space-x-2">
        <?php foreach ($currentBreadcrumbs as $index => $crumb): ?>
            <li class="inline-flex items-center">
                <?php if ($index > 0): ?>
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <?php endif; ?>
                <a href="<?= htmlspecialchars($crumb['link']) ?>" class="inline-flex dark:text-gray-700 dark:hover:text-cyan-500 items-center text-sm font-medium text-gray-300 hover:text-white">
                    <?php if (!empty($crumb['icon'])): ?>
                        <i class="<?= $crumb['icon'] ?> mr-2"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($crumb['title']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>
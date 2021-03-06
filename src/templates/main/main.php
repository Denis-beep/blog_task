<?php
/** @var array $articles */
include __DIR__ . '/../additional/header.php'; ?>
<main class="main">
    <h1 class="main title">Главная страница</h1>
    <div class="articles">
        <h2 class="articles title--md">Все записи</h2>
        <div class="articles__list">

        <?php foreach($articles as $article): ?>
                <?php echo $article['name']; ?>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php include __DIR__ . '/../additional/footer.php';
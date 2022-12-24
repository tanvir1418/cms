<?php

require '../includes/init.php';

Auth::requireLogin();

$conn = require '../includes/db.php';

if (isset($_GET['id'])) {
    $article = Article::getByID($conn, $_GET['id']);
} else {
    $article = null;
}
?>

<?php require '../includes/header.php' ?>

<?php if ($article) : ?>
    <article>
        <h2><?= htmlspecialchars($article->title); ?></h2>

        <?php if ($article->image_file) : ?>
            <img src="/cms/uploads/<?= $article->image_file ?>">
        <?php endif; ?>

        <p><?= htmlspecialchars($article->content); ?></p>
    </article>

    <a href="edit-article.php?id=<?= $article->id; ?>">Edit</a>
    <a href="delete-article.php?id=<?= $article->id; ?>">Delete</a>
    <a href="edit-article-image.php?id=<?= $article->id; ?>">Edit Image</a>
<?php else : ?>
    <p>Article not found.</p>

<?php endif ?>

<?php require '../includes/footer.php' ?>
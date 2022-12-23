<?php

require 'includes/init.php';

$conn = require 'includes/db.php';

if (isset($_GET['id'])) {
    $article = Article::getByID($conn, $_GET['id']);

    if (!$article) {
        die('Article not found.');
    }
} else {
    die('Id not supplied, article not found.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $article->title = $_POST['title'];
    $article->content = $_POST['content'];
    $article->published_at = $_POST['published_at'];

    if ($article->update($conn)) {
        Url::redirect("/cms/article.php?id={$article->id}");
    }
}

?>

<?php require 'includes/header.php'; ?>

<h2>Edit Article</h2>

<?php require 'includes/article-form.php'; ?>

<?php require 'includes/footer.php'; ?>
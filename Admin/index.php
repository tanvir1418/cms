<?php

require '../includes/init.php';

Auth::requireLogin();

$conn = require '../includes/db.php';

// if (isset($_GET['page'])) {
//     $paginator = new Paginator($_GET['page'], 4);
// } else {
//     $paginator = new Paginator(1, 4);
// }

// $paginator = new Paginator(isset($_GET['page']) ? $_GET['page'] : 1, 4);

// Null coalescing operator (when using Ternary Operator) 
$paginator = new Paginator($_GET['page'] ?? 1, 6, Article::getTotal($conn));

$articles = Article::getPage($conn, $paginator->limit, $paginator->offset);

?>

<?php require '../includes/header.php' ?>

<h2>Administration</h2>

<p><a href="new-article.php">New article</a></p>

<?php if (empty($articles)) : ?>
    <p>No articles found.</p>
<?php else : ?>
    <table class="table">
        <thead>
            <th>Title</th>
            <th>Published</th>
        </thead>
        <tbody>
            <?php foreach ($articles as $article) : ?>
                <tr>
                    <td>
                        <a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a>
                    </td>
                    <td>
                        <?php if($article['published_at']): ?>
                            <time><?= $article['published_at']; ?></time>
                        <?php else: ?>
                            Unpublished
                            <button class="publish btn" data-id="<?= $article['id']; ?>">Publish</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php require '../includes/pagination.php'; ?>

<?php endif ?>

<?php require '../includes/footer.php' ?>
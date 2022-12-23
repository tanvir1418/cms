<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My blog</title>
</head>

<body>
    <header>
        <h1>My blog</h1>
    </header>

    <nav>
        <ul>
            <li><a href="/cms/">Home</a></li>
            <?php if (Auth::isLoggedIn()) : ?>
                <li><a href="/cms/admin/">Admin</a></li>
                <li><a href="/cms/logout.php">Logout</a></li>
            <?php else : ?>
                <li><a href="/cms/login.php">Log in</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <main>
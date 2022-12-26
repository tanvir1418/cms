<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/cms/css/styles.css">
    <title>PHP Blog</title>
</head>

<body>

    <div class="container">
        <header>
            <h1>PHP Blog</h1>
        </header>

        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="/cms/">Home</a></li>
                <?php if (Auth::isLoggedIn()) : ?>
                    <li class="nav-item"><a class="nav-link" href="/cms/admin/">Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="/cms/logout.php">Logout</a></li>
                <?php else : ?>
                    <li class="nav-item"><a class="nav-link" href="/cms/login.php">Log in</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <main>
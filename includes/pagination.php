<?php $base = strtok($_SERVER["REQUEST_URI"], '?'); ?>

<nav>
    <ul>
        <li>
            <?php if ($paginator->previous) : ?>
                <a href="<?= $base; ?>?page=<?= $paginator->previous; ?>">Previous</a>
            <?php else : ?>
                Previous
            <?php endif ?>
        </li>

        <li>
            <?php if ($paginator->next) : ?>
                <a href="<?= $base; ?>?page=<?= $paginator->next; ?>">Next</a>
            <?php else : ?>
                Next
            <?php endif ?>
        </li>
    </ul>
</nav>
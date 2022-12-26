<?php if (!empty($article->errors)) : ?>
    <ul>
        <?php foreach ($article->errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" id="formArticle">

    <div>
        <label for="title">Title</label>
        <input name="title" id="title" placeholder="Article title" value="<?= htmlspecialchars($article->title); ?>">
    </div>

    <div>
        <label for="content">Content</label>
        <textarea name="content" rows="4" cols="40" id="content" placeholder="Article content"><?= htmlspecialchars($article->content); ?></textarea>
    </div>

    <div>
        <label for="published_at">Publication date and time</label>
        <input type="datetime-local" name="published_at" id="published_at" value="<?= htmlspecialchars($article->published_at); ?>">

        <!-- step="1" is used to take second also as input -->
        <!-- <input type="datetime-local" name="published_at" id="published_at" step="1" value="<?php // echo htmlspecialchars($published_at); 
                                                                                                ?>"> -->

    </div>

    <fieldset>
        <legend>Categories</legend>
        <?php foreach ($categories as $category) : ?>
            <div>
                <input type="checkbox" name="category[]" value="<?= $category['id'] ?>" id="category<?= $category['id'] ?>" <?php if (in_array($category['id'], $category_ids)) : ?>checked <?php endif; ?>>
                <label for="category<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></label>
            </div>
        <?php endforeach; ?>
    </fieldset>

    <button>Save</button>

</form>
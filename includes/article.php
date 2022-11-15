<?php

/**
 * Get the article record based on the ID
 *
 * @param object $conn Connection to the database
 * @param integer $id the article ID
 * @param string $columns Optional list of columns for the select, default to *
 * 
 * @return mixed An associative array containing the article with that ID, or null if not found
 */
function getArticle($conn, $id, $columns = '*')
{
    $sql = "SELECT $columns FROM article WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
    }
}


/**
 * Validate the article properties
 *
 * @param string $title Title, required
 * @param string $content Content, required
 * @param string $published_at Publish date and time, yyyy-mm-dd hh:mm:ss if not blank
 * 
 * @return array An array of validation error message
 */
function validateArticle($title, $content, $published_at)
{
    $errors = [];

    if ($title == '') {
        $errors[] = 'Title is required.';
    }

    if ($content == '') {
        $errors[] = 'Content is required.';
    }

    if ($published_at != '') {

        if (strlen($published_at) === 16) {
            // "Y-m-d\TH:i:s" when (new-article.php);
            $date_time = date_create_from_format('Y-m-d\TH:i', $published_at);
        } else {
            // "Y-m-d\TH:i:s" when (edit-article.php);
            $date_time = date_create_from_format('Y-m-d\TH:i:s', $published_at);
        }

        if ($date_time === false) {
            $errors[] = 'Invalid date and time';
        } else {
            $date_errors = date_get_last_errors();

            if ($date_errors['warning_count'] > 0) {
                $errors[] = 'Invalid date and time';
            }
        }
    }

    return $errors;
}

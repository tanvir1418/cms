<?php

class Article {

    public $id;
    public $title;
    public $content;
    public $published_at;
    public $image_file;
    public $errors = [];

    public static function getAll($conn) {
        $sql = "SELECT * FROM article ORDER BY published_at;";
        $results = $conn->query($sql);

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPage($conn, $limit, $offset) {
        $sql = "SELECT * FROM article ORDER BY published_at LIMIT :limit OFFSET :offset";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByID($conn, $id, $columns = '*') {
        $sql = "SELECT $columns FROM article WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');

        if ($stmt->execute()) {
            return $stmt->fetch();
        }
    }

    public function update($conn) {

        if ($this->validate()) {
            $sql = "UPDATE article SET title = :title, content = :content, published_at = :published_at WHERE id = :id";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);

            if ($this->published_at == '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }

            return $stmt->execute();
        } else {
            return false;
        }
    }

    protected function validate() {

        if ($this->title == '') {
            $this->errors[] = 'Title is required.';
        }

        if ($this->content == '') {
            $this->errors[] = 'Content is required.';
        }

        if ($this->published_at != '') {

            if (strlen($this->published_at) === 16) {
                // "Y-m-d\TH:i:s" when (new-article.php);
                $date_time = date_create_from_format('Y-m-d\TH:i', $this->published_at);
            } else {
                // "Y-m-d\TH:i:s" when (edit-article.php);
                $date_time = date_create_from_format('Y-m-d\TH:i:s', $this->published_at);
            }

            if ($date_time === false) {
                $this->errors[] = 'Invalid date and time';
            } else {
                $date_errors = date_get_last_errors();

                if ($date_errors['warning_count'] > 0) {
                    $this->errors[] = 'Invalid date and time';
                }
            }
        }

        return empty($this->errors);
    }

    public function delete($conn) {
        $sql = "DELETE FROM article WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function create($conn) {

        if ($this->validate()) {

            $sql = "INSERT INTO article (title, content, published_at) VALUES (:title, :content, :published_at)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);

            if ($this->published_at == '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            return false;
        }
    }

    public static function getTotal($conn) {
        return $conn->query('SELECT COUNT(*) FROM article')->fetchColumn();
    }

    public function setImageFile($conn, $filename) {
        $sql = "UPDATE article SET image_file = :image_file WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindValue(":image_file", $filename, $filename == null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        return $stmt->execute();
    }
}

<?php

class Movie
{
    const SHOW_BY_DEFAULT = 50;
    const FORMATS = [
        'VHS',
        'DVD',
        'Blu-Ray',
    ];

    public static function getAllMovies(int $count = self::SHOW_BY_DEFAULT): array
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM movie ORDER BY title LIMIT :count';
        $result = $db->prepare($sql);
        $result->bindParam(':count', $count, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetchAll();
    }

    public static function getMovieById(int $id): array
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM movie WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

    public static function createMovie(array $data): int
    {
        $db = Db::getConnection();

        $sql = "INSERT INTO movie (" . implode(', ', array_keys($data)) . ")
                VALUES (:" . implode(', :', array_keys($data)) . ")";
        $result = $db->prepare($sql);

        foreach (array_keys($data) as $key) {
            $result->bindParam(":{$key}", $data[$key], in_array($key, ['id', 'year']) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $result->execute();

        return $db->lastInsertId();
    }

    public static function createMoviesFromArray(array $data): void
    {
        $db = Db::getConnection();

        $sql = "INSERT INTO movie (title, year, format, actors)
            VALUES (?, ?, ?, ?)";
        $result = $db->prepare($sql);

        foreach ($data as $row) {
            $result->execute($row);
        }
    }

    public static function updateMovie(array $data): void
    {
        $db = Db::getConnection();

        $sqlFields = [];
        foreach(array_keys($data) as $key) {
            if ($key === 'id') {
                continue;
            }
            $sqlFields[] = "{$key} = :{$key}";
        }

        $sql = 'UPDATE movie
                SET '. implode(', ', $sqlFields) .'
                WHERE id = :id';
        $result = $db->prepare($sql);

        foreach (array_keys($data) as $key) {
            $result->bindParam(":{$key}", $data[$key], in_array($key, ['id', 'year']) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $result->execute();
    }

    public static function deleteMovieById(int $id): void
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM movie WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
    }

    public static function getMoviesByKeyword(string $keyword, int $count = self::SHOW_BY_DEFAULT): array
    {
        $db = Db::getConnection();
        $sql = "SELECT *
                FROM movie
                WHERE title LIKE '%{$keyword}%' OR actors LIKE '%{$keyword}%'
                ORDER BY title LIMIT :count";
        $result = $db->prepare($sql);
        $result->bindParam(':count', $count, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetchAll();
    }

    public static function validate(array $data): array
    {
        $errors = [];
        if (empty($data['title'])) {
            $errors[] = 'Title should not be blank';
        } elseif (strlen($data['title']) >= 255) {
            $errors[] = 'Title must contain maximum 255 characters';
        }

        if (empty($data['description'])) {
            $errors[] = 'Description should not be blank';
        }

        if (empty($data['format'])) {
            $errors[] = 'Format should not be blank';
        }

        if (empty($data['actors'])) {
            $errors[] = 'Actors should not be blank';
        } elseif (strlen($data['actors']) >= 255) {
            $errors[] = 'Actors must contain maximum 255 characters';
        }

        if (empty($data['year'])) {
            $errors[] = 'Year should not be blank';
        }

        return $errors;
    }
}

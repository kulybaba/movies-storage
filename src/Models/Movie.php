<?php

class Movie
{
    const SHOW_BY_DEFAULT = 5;

    public static function getAllMovies(): array
    {
        $db = Db::getConnection();
        $sql = 'SELECT *
                FROM movie
                ORDER BY title';
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetchAll();
    }

    public static function getMovieById(int $id): array
    {
        $db = Db::getConnection();
        $sql = 'SELECT *
                FROM movie
                WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }
}

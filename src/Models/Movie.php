<?php

class Movie
{
    const SHOW_BY_DEFAULT = 5;

    public static function getAllMovies()
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
}

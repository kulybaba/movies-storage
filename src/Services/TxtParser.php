<?php

class TxtParser
{
    const FORMAT_TXT = 'text/plain';

    public function parse(string $path): array
    {
        $movie = [];
        $movies = [];
        $file = fopen($path,'r');
        while ($line = fgets($file)) {
            $segments = explode(':', $line);
            $segments = array_map('trim', $segments);
            $field = array_shift($segments);
            $value = implode(': ', $segments);

            if (empty($field) || empty($value) || !in_array(mb_strtolower($field), ['title', 'release year', 'format', 'stars'])) {
                continue;
            }

            $movie[] = $value;
            if (count($movie) === 4) {
                $movie[1] = (int)$movie[1];
                $movies[] = $movie;
                $movie = [];
            }
        }
        fclose($file);

        return $movies;
    }
}

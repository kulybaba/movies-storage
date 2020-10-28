<?php

use PhpOffice\PhpWord\IOFactory;

class DocParser
{
    const FORMAT_DOCX = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    const FORMAT_DOC = 'application/msword';


    public function parse(string $path, string $type): array
    {
        $data = IOFactory::load($path, $type === self::FORMAT_DOC ? 'MsDoc' : 'Word2007');

        $movies = [];
        foreach($data->getSections() as $section) {
            $movie = [];
            foreach($section->getElements() as $elements) {
                if (get_class($elements) === 'PhpOffice\PhpWord\Element\TextRun') {
                    foreach ($elements->getElements() as $element) {
                        $text = $this->getElementText($element);
                        if ($text === false) {
                            continue;
                        }

                        $movie[] = $text;
                        if (count($movie) === 4) {
                            $movie[1] = (int)$movie[1];
                            $movies[] = $movie;
                            $movie = [];
                        }
                    }
                } elseif (get_class($elements) === 'PhpOffice\PhpWord\Element\Text') {
                    $text = $this->getElementText($elements);
                    if ($text === false) {
                        continue;
                    }

                    $movie[] = $text;
                    if (count($movie) === 4) {
                        $movie[1] = (int)$movie[1];
                        $movies[] = $movie;
                        $movie = [];
                    }
                }
            }
        }

        return $movies;
    }

    private function getElementText($element): ?string
    {
        $text = $element->getText();
        $segments = explode(':', $text);
        $segments = array_map('trim', $segments);
        $field = array_shift($segments);
        $value = implode(': ', $segments);

        if (empty($field) || empty($value) || !in_array(mb_strtolower($field), ['title', 'release year', 'format', 'stars'])) {
            return false;
        }

        return $value;
    }
}

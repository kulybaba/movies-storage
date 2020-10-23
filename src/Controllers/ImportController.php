<?php

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class ImportController extends AbstractController
{
    public function importAction()
    {
        $this->render('import/import.html.twig');
    }

    public function processAction()
    {
        if (!empty($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
            $reader = IOFactory::createReader();
            /** @var PhpWord $data */
            $data = $reader->load($_FILES['file']['tmp_name']);

            $movies = [];
            foreach($data->getSections() as $section) {
                $elements = $section->getElements();
                $movie = [];
                foreach($elements as $element) {
                    if (get_class($element) === 'PhpOffice\PhpWord\Element\TextRun') {
                        $words = [];
                        foreach ($element->getElements() as $text) {
                            $text = $text->getText();
                            if (in_array($text, ['Title', 'Release', 'Year', 'Format', 'Stars', ': ', ' '])) {
                                continue;
                            }
                            $words[] = trim($text, ": \t\n\r\0\x0B");
                        }
                        $movie[] = implode(' ', $words);

                        if (count($movie) === 4) {
                            $movies[] = $movie;
                            $movie = [];
                        }
                    }
                }
            }

            Movie::createMoviesFromArray($movies);
            header('Location: /');
        }

        $this->render('import/import.html.twig', [
            'errors' => ['File should not be blank'],
        ]);
    }
}

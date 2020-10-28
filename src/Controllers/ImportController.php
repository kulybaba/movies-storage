<?php

class ImportController extends AbstractController
{
    public function importAction()
    {
        $this->render('import/import.html.twig');
    }

    public function processAction()
    {
        $errors = [];
        $type = $_FILES['file']['type'];
        $path = $_FILES['file']['tmp_name'];
        if (empty($path) || !is_uploaded_file($path)) {
            $errors[] = 'File should not be blank';
        }

        if (!in_array($type, [DocParser::FORMAT_DOC, DocParser::FORMAT_DOCX, TxtParser::FORMAT_TXT])) {
            $errors[] = 'File extension must be: doc, docx, txt';
        }

        if (empty($errors)) {
            if (in_array($type, [DocParser::FORMAT_DOC, DocParser::FORMAT_DOCX])) {
                $movies = (new DocParser())->parse($path, $type);
            } else {
                $movies = (new TxtParser())->parse($path);
            }

            Movie::createMoviesFromArray($movies);
            header('Location: /');
        }

        $this->render('import/import.html.twig', [
            'errors' => $errors,
        ]);
    }
}

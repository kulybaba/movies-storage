<?php

class MovieController extends AbstractController
{
    public function viewAction(int $id)
    {
        $this->render('movie/view.html.twig', [
            'movie' => Movie::getMovieById($id),
        ]);
    }

    public function editAction(int $id)
    {
        $this->render('movie/edit.html.twig', [
            'movie' => Movie::getMovieById($id),
            'formats' => Movie::FORMATS,
        ]);
    }

    public function updateAction(int $id)
    {
        if (empty($errors = Movie::validate($_POST))) {
            Movie::updateMovie($_POST);
            header("Location: /movies/view/{$id}");
        } else {
            $this->render('movie/edit.html.twig', [
                'movie' => $_POST,
                'formats' => Movie::FORMATS,
                'errors' => $errors,
            ]);
        }
    }
}

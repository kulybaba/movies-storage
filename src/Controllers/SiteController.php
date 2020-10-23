<?php

class SiteController extends AbstractController
{
    public function indexAction()
    {
        $this->render('index.html.twig', [
            'movies' => !empty($_POST['search']) ? Movie::getMoviesByKeyword($_POST['search']) : Movie::getAllMovies(),
            'search' => !empty($_POST['search']) ? $_POST['search'] : '',
        ]);
    }
}

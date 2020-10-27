<?php

class SiteController extends AbstractController
{
    public function indexAction()
    {
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * Movie::MOVIES_LIMIT;
        $lastPage = ceil(Movie::getCountMovies() / Movie::MOVIES_LIMIT);

        $this->render('index.html.twig', [
            'page' => $page,
            'movies' => Movie::getAllMovies($offset),
            'lastPage' => $lastPage,
        ]);
    }
}

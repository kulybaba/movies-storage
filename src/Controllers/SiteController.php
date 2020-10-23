<?php

class SiteController extends AbstractController
{
    public function indexAction()
    {
        $this->render('index.html.twig', [
            'movies' => Movie::getAllMovies(),
        ]);
    }
}

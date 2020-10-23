<?php

class MovieController extends AbstractController
{
    public function viewAction($id)
    {
        $this->render('movie/view.html.twig', [
            'movie' => Movie::getMovieById($id),
        ]);
    }
}

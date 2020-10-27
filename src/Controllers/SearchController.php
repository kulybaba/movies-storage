<?php

class SearchController extends AbstractController
{
    public function searchAction()
    {
        $keyword = $_GET['keyword'];
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * Movie::MOVIES_LIMIT;
        $lastPage = ceil(Movie::getCountMoviesByKeyword($keyword) / Movie::MOVIES_LIMIT);
        $movies = Movie::getMoviesByKeyword($keyword, $offset);

        $this->render('search/search.html.twig', [
            'page' => $page,
            'movies' => $movies,
            'lastPage' => $lastPage,
            'search' => $keyword,
        ]);
    }
}

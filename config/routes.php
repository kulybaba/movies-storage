<?php

return [
    'movies/import/process' => 'import/process', //ImportController::processAction()
    'movies/import' => 'import/import', //ImportController::importAction()

    'movies/delete/([0-9]+)' => 'movie/delete/$1', // MovieController::deleteAction()
    'movies/update/([0-9]+)' => 'movie/update/$1', // MovieController::updateAction()
    'movies/edit/([0-9]+)' => 'movie/edit/$1', // MovieController::editAction()
    'movies/view/([0-9]+)' => 'movie/view/$1', // MovieController::viewAction()
    'movie/create' => 'movie/create', // MovieController::createAction()
    'movie/add' => 'movie/add', // MovieController::addAction()

    'search(.+)' => 'search/search/$1', // SearchController::searchIndex()

    'index.php(.+)' => 'site/index', // SiteController::actionIndex()
    'index.php' => 'site/index', // SiteController::actionIndex()
    '' => 'site/index', // SiteController::actionIndex()
];

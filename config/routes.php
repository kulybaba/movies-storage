<?php

return [
    'movies/update/([0-9]+)' => 'movie/update/$1', // MovieController::updateAction()
    'movies/edit/([0-9]+)' => 'movie/edit/$1', // MovieController::editAction()
    'movies/view/([0-9]+)' => 'movie/view/$1', // MovieController::viewAction()

    '' => 'site/index', // SiteController::actionIndex()
];

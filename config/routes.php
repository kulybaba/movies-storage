<?php

return [
    'movies/view/([0-9]+)' => 'movie/view/$1', // MovieController::viewAction()

    '' => 'site/index', // SiteController::actionIndex()
];

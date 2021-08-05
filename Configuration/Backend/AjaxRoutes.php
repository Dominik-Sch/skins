<?php

use Rubb1\Skins\Controller\BackendController;

return [
    'save_settings' => [
        'path' => '/skins/save',
        'target' => BackendController::class . '::saveAction',
    ],
    'load_settings' => [
        'path' => '/skins/load',
        'target' => BackendController::class . '::loadAction',
    ],
];
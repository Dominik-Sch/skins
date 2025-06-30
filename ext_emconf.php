<?php

/** @var string $_EXTKEY */

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Skins',
    'description' => 'This extension adds a dark skin (dark theme) to the TYPO3 backend. The colors are customizable and can be changed to your favorite colors.',
    'category' => 'be',
    'version' => '11.4.1',
    'state' => 'stable',
    'uploadfolder' => false,
    'clearcacheonload' => true,
    'author' => 'Dominik Schüßler',
    'author_email' => 'dominikschuessler1337@gmail.com',
    'author_company' => '',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '13.4.0-13.99.99',
                ],
            'conflicts' =>
                [],
            'suggests' =>
                [],
        ],
];


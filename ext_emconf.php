<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'TYPO3 Skins',
    'description' => 'This extension adds a dark skin (dark theme) to the TYPO3 backend. The colors are customizable and can be changed to your favorite colors.',
    'category' => 'be',
    'author' => 'Dominik Schüßler',
    'author_company' => '',
    'author_email' => 'dominikschuessler1337@gmail.com',
    'dependencies' => '',
    'state' => 'stable',
    'clearCacheOnLoad' => '1',
    'version' => '10.5.0',
    'constraints' => array(
        'depends' => array(
            'typo3' => '10.4.0-11.5.99',
        )
    )
);
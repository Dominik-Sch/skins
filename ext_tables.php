<?php

defined('TYPO3_MODE') || die();

/**
 * backend
 */
if (TYPO3_MODE == 'BE') {

    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_skins_darkmode'] = [
        'label' => 'Darkmode',
        'type' => 'check',
    ];
    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_skins_custom_color_1'] = [
        'label' => 'Custom Color 1',
        'type' => 'text',
        'default' => 'rgb(21, 21,21)',
    ];
    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_skins_custom_color_2'] = [
        'label' => 'Custom Color 2',
        'type' => 'text',
        'default' => 'rgb(41, 41, 41)',
    ];
    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_skins_custom_color_4'] = [
        'label' => 'Custom Color 4',
        'type' => 'text',
        'default' => 'rgb(60, 63, 65)',
    ];
    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_skins_custom_color_5'] = [
        'label' => 'Custom Color 5',
        'type' => 'text',
        'default' => 'rgb(245, 245, 245)',
    ];
    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_skins_custom_color_6'] = [
        'label' => 'Custom Color 6',
        'type' => 'text',
        'default' => 'rgba(245, 245, 245, 0.3)',
    ];
    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_skins_custom_color_7'] = [
        'label' => 'Custom Color 7',
        'type' => 'text',
        'default' => 'rgb(31, 31, 31)',
    ];
    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_skins_custom_color_8'] = [
        'label' => 'Custom Color 8',
        'type' => 'text',
        'default' => 'rgb(253, 195, 0)',
    ];
    $GLOBALS['TYPO3_USER_SETTINGS']['showitem'] .= ',
    --div--;Skins,
        tx_skins_darkmode,
        tx_skins_custom_color_1, 
        tx_skins_custom_color_2, 
        tx_skins_custom_color_4, 
        tx_skins_custom_color_5, 
        tx_skins_custom_color_6, 
        tx_skins_custom_color_7, 
        tx_skins_custom_color_8, 
    ';

    // add backend css
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = \Rubb1\Skins\Hooks\PageRenderer::class . '->darkmode';

    // bring back save and close function
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Backend\\Controller\\EditDocumentController'] = [
        'className' => 'Rubb1\\Skins\\Xclass\\OverrideEditDocumentController'
    ];
}
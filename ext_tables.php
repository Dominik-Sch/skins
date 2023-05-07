<?php

defined('TYPO3') or die();

/**
 * backend
 */
if (TYPO3 == 'BE') {

    $GLOBALS['TBE_STYLES']['skins']['skins']['stylesheetDirectories'][] = 'EXT:skins/Resources/Public/Backend/ToolbarMenu';

    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_skins_active'] = [
        'label' => 'Dark mode',
        'type' => 'check',
    ];
    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_skins_dark_mode_settings'] = [
        'label' => 'Settings JSON',
        'type' => 'text',
        'default' => '',
    ];
    $GLOBALS['TYPO3_USER_SETTINGS']['showitem'] .= ',
    --div--;Skins Settings,
        tx_skins_active,
        tx_skins_dark_mode_settings,
    ';

    // add backend css
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = \Rubb1\Skins\Hooks\PageRenderer::class . '->darkmode';
}
<?php

defined('TYPO3_MODE') || die();

/**
 * Configure Backend optics
 */
if (TYPO3_MODE == 'BE') {

    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_skins_darkmode'] = array(
        'label' => 'Darkmode',
        'type' => 'check',
    );
    $GLOBALS['TYPO3_USER_SETTINGS']['showitem'] .= ',
    --div--;Skins,
        tx_skins_darkmode,
        ';

    // add backend css
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = \Rubb1\Skins\Hooks\PageRenderer::class . '->darkmode';
}
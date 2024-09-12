<?php

use Rubb1\Skins\Hooks\PageRenderer;

defined('TYPO3') or die();

/**
 * backend
 */
if (TYPO3 == 'BE') {

    $GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets']['skins'] = 'EXT:skins/Resources/Public/Backend/ToolbarMenuScss';

    // add backend css
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = PageRenderer::class . '->darkmode';
}

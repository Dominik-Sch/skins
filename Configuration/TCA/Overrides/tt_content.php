<?php

use Rubb1\Skins\Backend\TextmediaPreviewRenderer;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$extConf = [];
try {
    $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('skins');
} catch (Exception $e) {
    // config failed to load
}

if (isset($extConf['enableCustomPreviewRenderer']) && $extConf['enableCustomPreviewRenderer'] == '1') {
    $GLOBALS['TCA']['tt_content']['types']['textmedia']['previewRenderer']
        = TextmediaPreviewRenderer::class;
    $GLOBALS['TCA']['tt_content']['types']['textpic']['previewRenderer']
        = TextmediaPreviewRenderer::class;
}

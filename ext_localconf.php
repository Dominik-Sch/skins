<?php

declare(strict_types = 1);

use Rubb1\Skins\Toolbar\Darkmode;
use Rubb1\Skins\Hooks\DataHandlerSaveAndCloseHook;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') || die();

$extConf = [];
try {
    $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('skins');
} catch (Exception $e) {
    // config failed to load
}

if (isset($extConf['saveAndCloseEnabled']) && $extConf['saveAndCloseEnabled'] == '1') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][DataHandlerSaveAndCloseHook::class] = DataHandlerSaveAndCloseHook::class;
}

$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][] = Darkmode::class;

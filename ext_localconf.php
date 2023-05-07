<?php

declare(strict_types = 1);

use Rubb1\Skins\Toolbar\Darkmode;
use Rubb1\Skins\Hooks\DataHandlerSaveAndCloseHook;

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][] = Darkmode::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][DataHandlerSaveAndCloseHook::class] = DataHandlerSaveAndCloseHook::class;

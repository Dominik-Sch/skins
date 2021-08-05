<?php

call_user_func(function($extKey) {
    $GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][] = \Rubb1\Skins\Toolbar\Darkmode::class;
}, 'skins');
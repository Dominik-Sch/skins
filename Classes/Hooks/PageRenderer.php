<?php

namespace Rubb1\Skins\Hooks;

use TYPO3\CMS\Core\SingletonInterface;

class PageRenderer implements SingletonInterface {

    /**
     * @param $params
     * @param $pageRenderer
     */
    public function darkmode($params, &$pageRenderer)
    {
        if ($GLOBALS['BE_USER']->uc['tx_skins_darkmode'] === 1) {
            $pageRenderer->addCssFile('EXT:skins/Resources/Public/Backend/Style/Skin/Dark/style.css');
        }
    }
}
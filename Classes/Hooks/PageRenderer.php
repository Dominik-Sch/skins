<?php

namespace Rubb1\Skins\Hooks;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class PageRenderer implements SingletonInterface
{

    /**
     * @param $params
     * @param $pageRenderer
     */
    public function darkmode($params, &$pageRenderer): void
    {

        /**
         * add jquery color picker files to pageRenderer
         */
        $pageRenderer->addCssFile('EXT:skins/Resources/Public/Libs/Color-Picker/jquery.minicolors.css');
        $pageRenderer->addRequireJsConfiguration([
            'paths' => [
                'colorpicker-lib' => '/typo3conf/ext/skins/Resources/Public/Libs/Color-Picker/jquery.minicolors.min.js',
            ],
            'shim' => [
                'colorpicker-lib' => ['jquery'],
            ],
        ]);

        // Verify access to the user configuration
        if (
            $GLOBALS['BE_USER']->uc != null &&
            isset($GLOBALS['BE_USER']->uc['tx_skins_active']) &&
            (int)$GLOBALS['BE_USER']->uc['tx_skins_active'] === 1
        ) {
            /**
             * add skin file to pageRenderer
             */
            $pageRenderer->addCssFile('EXT:skins/Resources/Public/Backend/Style/Skin/Dark/style.css');

            $settingsArray = json_decode($GLOBALS['BE_USER']->uc['tx_skins_dark_mode_settings']);
            $cssString = "";

            foreach($settingsArray as $key => $value) {
                $cssString .= '--'.$key.': '.$value.'; ';
            }
            /**
             * generate css block with be user css variables
             */
            $customCssBlock = "
            :root {
            ".$cssString."
            }
            ";

            /**
             * add css block to pageRenderer
             */
            $pageRenderer->addCssInlineBlock('tx_skins_custom_color_block', $customCssBlock, false, false);
        }
    }
}
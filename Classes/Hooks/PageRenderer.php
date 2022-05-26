<?php

namespace Rubb1\Skins\Hooks;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class PageRenderer implements SingletonInterface {

    /**
     * @param $params
     * @param $pageRenderer
     */
    public function darkmode($params, &$pageRenderer)
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
        if ($GLOBALS['BE_USER']->uc != null && $GLOBALS['BE_USER']->uc['tx_skins_darkmode'] === 1) {

            /**
             * add skin file to pageRenderer
             */
            $pageRenderer->addCssFile('EXT:skins/Resources/Public/Backend/Style/Skin/Dark/style.min.css');

            /**
             * generate css block with be user css variables
             */
            $customCssBlock = "
            :root {
             --color-1: {$GLOBALS['BE_USER']->uc['tx_skins_custom_color_1']};
             --color-2: {$GLOBALS['BE_USER']->uc['tx_skins_custom_color_2']};
             --color-4: {$GLOBALS['BE_USER']->uc['tx_skins_custom_color_4']};
             --color-5: {$GLOBALS['BE_USER']->uc['tx_skins_custom_color_5']};
             --color-6: {$GLOBALS['BE_USER']->uc['tx_skins_custom_color_6']};
             --color-7: {$GLOBALS['BE_USER']->uc['tx_skins_custom_color_7']};
             --color-8: {$GLOBALS['BE_USER']->uc['tx_skins_custom_color_8']};
            }
            ";

            /**
             * add css block to pageRenderer
             */
            $pageRenderer->addCssInlineBlock('tx_skins_custom_color_block',$customCssBlock, false, false);
        }
    }
}
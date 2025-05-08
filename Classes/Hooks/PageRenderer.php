<?php

namespace Rubb1\Skins\Hooks;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PageRenderer implements SingletonInterface
{

    /**
     * @param $params
     * @param $pageRenderer
     */
    public function darkmode($params, &$pageRenderer): void
    {

        $extConf = [];
        try {
            $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('skins');
        } catch (\Exception $e) {
            // config failed to load
        }

        $pageRenderer->addCssFile('EXT:skins/Resources/Public/Backend/ToolbarMenuScss/toolbar.css');

        if (isset($extConf['enableCustomPreviewRenderer']) && $extConf['enableCustomPreviewRenderer'] == '1') {
            $pageRenderer->addCssFile('EXT:skins/Resources/Public/Backend/Style/Skin/ContentElements/elements.css');
        }
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
            $settingsArray = json_decode(json_encode($settingsArray), true);
            $cssString = "";

            foreach ($settingsArray as $key => $value) {
                $cssString .= '--' . $key . ': ' . $value . '; ';
                $cssString .= '--rgb-' . $key . ': ' . $this->convertHexToRgb($value) . '; ';
            }

            /**
             * generate css block with be user css variables
             */
            $customCssBlock = "
            :root {
            " . $cssString . "
            }
            ";

            /**
             * add css block to pageRenderer
             */
            $pageRenderer->addCssInlineBlock('tx_skins_custom_color_block', $customCssBlock, false, false);
        }
    }

    private function convertHexToRgb($hex): string
    {
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        return $r . ',' . $g . ',' . $b;
    }
}

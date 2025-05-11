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
                if (str_contains($key,'color')) {
                    $rgb = $this->convertHexToRgb($value);
                    $hsl = $this->convertRgbToHsl($rgb['r'],$rgb['g'],$rgb['b']);
                    $cssString .= '--r-' . $key . ': ' . $rgb['r'] . '; ';
                    $cssString .= '--g-' . $key . ': ' . $rgb['g'] . '; ';
                    $cssString .= '--b-' . $key . ': ' . $rgb['b'] . '; ';
                    $cssString .= '--h-' . $key . ': ' . $hsl['h'] . '; ';
                    $cssString .= '--s-' . $key . ': ' . $hsl['s'] . '%; ';
                    $cssString .= '--l-' . $key . ': ' . $hsl['l'] . '%; ';
                }
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

    private function convertHexToRgb($hex): array
    {
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        return [
            "r" => $r,
            "g" => $g,
            "b" => $b
        ];
    }

    private function convertRgbToHsl( $r, $g, $b ): array
    {
        $oldR = $r;
        $oldG = $g;
        $oldB = $b;

        $r /= 255;
        $g /= 255;
        $b /= 255;

        $max = max( $r, $g, $b );
        $min = min( $r, $g, $b );

        $h;
        $s;
        $l = ( $max + $min ) / 2;
        $d = $max - $min;

        if( $d == 0 ){
            $h = $s = 0; // achromatic
        } else {
            $s = $d / ( 1 - abs( 2 * $l - 1 ) );

            switch( $max ){
                case $r:
                    $h = 60 * fmod( ( ( $g - $b ) / $d ), 6 );
                    if ($b > $g) {
                        $h += 360;
                    }
                    break;

                case $g:
                    $h = 60 * ( ( $b - $r ) / $d + 2 );
                    break;

                case $b:
                    $h = 60 * ( ( $r - $g ) / $d + 4 );
                    break;
            }
        }

        return [
            "h" => round( $h, 2 ),
            "s" => round( $s, 2 ) * 100,
            "l" => round( $l, 2 ) * 100
        ];
    }
}

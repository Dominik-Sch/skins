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

            $cssString .= "--module-docheader-bg:var(--color-2);";
            $cssString .= "--pagemodule-grid-cell-bg:rgba(var(--rgb-color-2),0.5);";
            $cssString .= "--panel-default-heading-bg:rgba(var(--rgb-color-2),0.5);";
            $cssString .= "--panel-default-border-color:rgba(var(--rgb-color-2),0.5);";
            $cssString .= "--bs-info-bg-subtle:var(--color-2);";

            $cssString .= "--module-docheader-border:var(--color-4);";
            $cssString .= "--module-bg:var(--color-4);";
            $cssString .= "--pagemodule-element-bg:var(--color-4);";
            $cssString .= "--bs-info-border-subtle:var(--color-4);";
            $cssString .= "--bs-body-bg:var(--color-4);";

            //// color 5
            // button
            $cssString .= ".btn-default {";
            $cssString .= "--bs-btn-color:var(--color-5);";
            $cssString .= "--bs-btn-hover-color:var(--color-5);";
            $cssString .= "--bs-btn-active-color:var(--color-5);";
            $cssString .= "--bs-btn-disabled-color:var(--color-5);";
            $cssString .= "}";

            // table
            $cssString .= ".table-primary, table.primary, td.active, td.primary, tr.active, tr.primary {";
            $cssString .= "--bs-table-color:var(--color-5);";
            $cssString .= "--bs-table-striped-color:var(--color-5);";
            $cssString .= "--bs-table-active-color:var(--color-5);";
            $cssString .= "}";

            // text
            $cssString .= "--bs-heading-color:var(--color-5);";
            $cssString .= "--bs-body-color:var(--color-5);";
            $cssString .= "--bs-secondary-color:var(--color-5);";
            $cssString .= "--bs-link-color:var(--color-5);";
            $cssString .= "--bs-link-color-rgb:var(--color-5);";
            $cssString .= "--bs-link-hover-color-rgb:var(--color-5);";
            $cssString .= "--bs-info-text-emphasis:var(--color-5);";
            $cssString .= "--treelist-color:var(--color-5);";
            $cssString .= "--panel-default-heading-color:var(--color-5);";

            $cssString .= ".nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-item.show .nav.nav-tabs > li:not(.nav-item) > a:not(.nav-link), .nav-tabs .nav-link.active, .nav.nav-tabs > li.show:not(.nav-item) .nav-link, .nav.nav-tabs > li.show:not(.nav-item) .nav.nav-tabs > li:not(.nav-item) > a:not(.nav-link), .nav.nav-tabs > li:not(.nav-item) > a.active:not(.nav-link) {";
            $cssString .= "--bs-nav-tabs-link-active-color:var(--color-5);";
            $cssString .= "}";

            $cssString .= ".nav-link, .nav.nav-tabs>li:not(.nav-item)>a:not(.nav-link) {";
            $cssString .= "--bs-nav-link-color:var(--color-5);";
            $cssString .= "}";

            // icon
            $cssString .= "--icon-color-primary:var(--color-5);";
            $cssString .= "--svgtree-node-color:var(--color-5);";

            // code
            $cssString .= "--bs-pagination-hover-color:var(--color-8);";
            $cssString .= "--bs-code-color:var(--color-8);";
            $cssString .= "--bs-alert-link-color:var(--color-8);";
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

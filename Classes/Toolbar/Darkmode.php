<?php
namespace Rubb1\Skins\Toolbar;

use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Darkmode implements ToolbarItemInterface {

    /**
     * Constructs the Clock toolbar item
     */
    public function __construct() {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Skins/Darkmode');
    }

    /**
     * Checks the access rights to the ToolbarItem
     *
     * @return bool
     */
    public function checkAccess(): bool {
        return TRUE;
    }

    /**
     * Get the DOM for the ToolbarItem
     *
     * @return string
     */
    public function getItem(): string {
        return '
        <span class="dark-mode-switch">
            <span class="toolbar-item-icon" title="Custom skin">
                <span class="t3js-icon icon icon-size-small icon-state-default icon-apps-toolbar-menu-shortcut" data-identifier="apps-toolbar-menu-shortcut">
                    <span class="icon-markup">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 1332.3 1332.3" xml:space="preserve">
                            <rect class="darkmode-background" width="1332.3" height="1332.3"/>
                            <g>
                            <path class="darkmode-path" d="M421.1,476.6l-30-30l-30,30l-16.5,16.5l-37.3,37.3c-16.5,16.5-16.5,43.4,0,59.9l128.5,128.5l3.5,3.5
                                c0,0,40,42.5,3.9,83.1S224.4,955,170.6,1008.8c-53.8,53.8-70.8,113.5-16.2,168c0.2,0.2,0.4,0.3,0.6,0.5c0.2,0.2,0.3,0.4,0.5,0.6
                                c54.5,54.5,114.2,37.6,168-16.2c53.8-53.8,162.9-236.6,203.4-272.7c40.5-36.1,83.1,3.9,83.1,3.9l132,132
                                c16.5,16.5,43.4,16.5,59.9,0l37.3-37.3l16.5-16.5l30-30l-30-30L421.1,476.6z M210.2,1122.1c-18.3-18.3-18.3-48,0-66.3
                                c18.3-18.3,48-18.3,66.3,0c18.3,18.3,18.3,48,0,66.3C258.2,1140.4,228.5,1140.4,210.2,1122.1z"/>
                                <path class="darkmode-path" d="M1199,568.1L985.8,354.9C929.3,298.4,880,373.4,854.3,389c17.3-27.1,87.8-77.9,54.2-111.5l-11.8-11.8
                                c-21.6-21.6-60.3-2.4-60.3-2.4s17.7-40.1-3.8-61.7l-68.3-68.3c-16.5-16.5-43.2-16.5-59.7,0l-77,77l-1.2,1.2L404.9,432.8
                                l494.5,494.5l208.1-208.1l0.8-0.8l90.7-90.7C1215.5,611.3,1215.5,584.6,1199,568.1z M899.4,889.1L443.2,432.8L626,250.1
                                c65.1,76.6,78.3,103.5,80.1,107.4c4.2,18.8,16.5,38.4,36.4,58.3c18.9,18.9,44,37.4,70.8,52.2c20,11,35.8,22.1,45.7,32.1
                                c9.6,9.6,10.7,15.1,10.5,16c-3,12.1-13.1,43.3-40.4,70.8c-3.4,2.7-15.5,8.7-22,11.9c-3.7,1.8-7.2,3.6-10.4,5.2
                                c-24.7,12.9-50.5,29.6-55.2,56.1c-2.3,13.2-2.3,27.6,13.6,43.5c14,14,32.8,16.8,44.5,14.8c25.5-4.2,41.7-28.1,54.2-50.9
                                c1.7-3.2,3.6-6.7,5.5-10.5c3.6-7,11.1-21.5,14.5-25c1.6-1.6,2.5-2.5,3.7-3.7l1.7-1.7l1.6-1.6c0,0,0.1-0.1,0.1-0.1
                                c24.4-24.8,50-36.8,68.4-32.3c5.5,1.3,8,3.3,9.6,4.9c3.7,3.7,6.5,9.9,9.8,17.1c4.3,9.4,9.2,20.1,18.1,29.7c1.4,1.5,3.1,3.3,5.2,5.4
                                c15.1,15.1,52,48.7,76.5,70.3L899.4,889.1z"/>
                        </g>
                        </svg>
                    </span>
                </span>
            </span>
            <span class="toolbar-item-title">Bookmarks</span>
        </span>';
    }

    /**
     * Checks if the ToolbarItem has a dropdown
     *
     * @return bool
     */
    public function hasDropDown(): bool {
        return true;
    }

    /**
     * Get the DOM for the dropdown
     *
     * @return string
     */
    public function getDropDown(): string {
        return '
        <div class="dropdown-inner-wrap">
            <div class="header">
                <h3 class="dropdown-headline">Custom skin settings</h3>
                <div class="save-wrap">
                    <span class="save-skin-settings">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                            <path d="M10.7 1H1.5c-.3 0-.5.2-.5.5v13c0 .3.2.5.5.5h13c.3 0 .5-.2.5-.5V5.4c0-.5-.2-1-.6-1.4L12 1.6c-.3-.4-.8-.6-1.3-.6zM7.3 2h1.5c.1 0 .2.1.2.3v2.5c0 .1-.1.2-.2.2H7.3c-.2 0-.3-.1-.3-.2V2.3c0-.2.1-.3.3-.3zM11 14H5v-3.8c0-.1.1-.2.3-.2h5.5c.1 0 .3.1.3.3V14H11zm3 0h-2V9.5c0-.3-.2-.5-.5-.5h-7c-.3 0-.5.2-.5.5V14H2V2h2v3.5c0 .3.2.5.5.5h5c.3 0 .5-.2.5-.5V2h.8c.3 0 .5.1.7.3l1.9 2c.4.4.6.9.6 1.4V14z"></path>
                        </svg>
                    SAVE</span>
                </div>
            </div>
            <hr>
            <div class="row-wrap checkbox checkbox-type-toggle custom-skin-change-trigger">
                <input type="checkbox" class="checkbox-input" value="0" id="custom-skin">
                <label class="checkbox-label" for="custom-skin">
                    <span>toggle custom skin</span>
                </label> 
            </div>
            <hr class="content-width">
            <div class="row-wrap color-picker-wrap color-1">
                <input id="color-1" type="text" class="colorpicker-input" data-color-id="1" />
                <label for="color-1">color 1</label>
            </div>
            <hr class="content-width">
            <div class="row-wrap color-picker-wrap color-2">
                <input id="color-2" type="text" class="colorpicker-input" data-color-id="2" />
                <label for="color-2">color 2</label>
            </div>
            <hr class="content-width">
            <div class="row-wrap color-picker-wrap color-4">
                <input id="color-4" type="text" class="colorpicker-input" data-color-id="4" />
                <label for="color-4">color 4</label>
            </div>
            <hr class="content-width">
            <div class="row-wrap color-picker-wrap color-5">
                <input id="color-5" type="text" class="colorpicker-input" data-color-id="5" />
                <label for="color-5">color 5</label>
            </div>
            <hr class="content-width">
            <div class="row-wrap color-picker-wrap color-6">
                <input id="color-6" type="text" class="colorpicker-input" data-color-id="6" />
                <label for="color-6">color 6</label>
            </div>
            <hr class="content-width">
            <div class="row-wrap color-picker-wrap color-7">
                <input id="color-7" type="text" class="colorpicker-input" data-color-id="7" />
                <label for="color-7">color 7</label>
            </div>
            <hr class="content-width">
            <div class="row-wrap color-picker-wrap color-8">
                <input id="color-8" type="text" class="colorpicker-input" data-color-id="8" />
                <label for="color-8">color 8</label>
            </div>
        </div>
        ';
    }

    /**
     * Get an array with additional attributes for the ToolbarItem container
     *
     * @return array
     */
    public function getAdditionalAttributes(): array {
        return [];
    }

    /**
     * Get the index number of the ToolbarItem, basically the position of the item
     * in the toolbar. Lower means further left, higher further right.
     *
     * @return int
     */
    public function getIndex(): int {
        return 0;
    }
}
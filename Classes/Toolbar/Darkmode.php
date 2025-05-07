<?php

namespace Rubb1\Skins\Toolbar;

use InvalidArgumentException;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Information\Typo3Version;

class Darkmode implements ToolbarItemInterface
{

    /**
     * Constructs the Clock toolbar item
     */
    public function __construct()
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        if ((new Typo3Version())->getMajorVersion() >= 12) {
            $pageRenderer->loadJavaScriptModule('@rubb1/skins/main.js');
        } else {
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Skins/Darkmode');
        }
    }

    /**
     * Checks the access rights to the ToolbarItem
     *
     * @return bool
     */
    public function checkAccess(): bool
    {
        return TRUE;
    }

    /**
     * Get the DOM for the ToolbarItem
     *
     * @return string
     * @throws InvalidExtensionNameException
     */
    public function getItem(): string
    {
        return $this->getFluidTemplateObject('Item.html')->render();
    }

    /**
     * returns a new standalone view, shorthand function
     *
     * @param string $templateFilename
     * @return StandaloneView
     * @throws InvalidExtensionNameException
     * @throws InvalidArgumentException
     * @internal param string $templateFile
     */
    protected function getFluidTemplateObject(string $templateFilename): StandaloneView
    {
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplateRootPaths(['EXT:skins/Resources/Private/Templates/Backend']);
        $view->setTemplate($templateFilename);
        return $view;
    }

    /**
     * Checks if the ToolbarItem has a dropdown
     *
     * @return bool
     */
    public function hasDropDown(): bool
    {
        return true;
    }

    /**
     * Get the DOM for the dropdown
     *
     * @return string
     * @throws InvalidExtensionNameException
     */
    public function getDropDown(): string
    {
        return $this->getFluidTemplateObject('DropDown.html')->render();
    }

    /**
     * Get an array with additional attributes for the ToolbarItem container
     *
     * @return array
     */
    public function getAdditionalAttributes(): array
    {
        return [];
    }

    /**
     * Get the index number of the ToolbarItem, basically the position of the item
     * in the toolbar. Lower means further left, higher further right.
     *
     * @return int
     */
    public function getIndex(): int
    {
        return 0;
    }
}

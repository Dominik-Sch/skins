<?php

namespace Rubb1\Skins\Xclass;

use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Core\Imaging\Icon;

/**
 * Xclass EditDocumentController to change rendering
 */
class OverrideEditDocumentController extends EditDocumentController
{
    /**
     * Register the save button to the button bar
     *
     * @param ButtonBar $buttonBar
     * @param string $position
     * @param int $group
     */
    function registerSaveButtonToButtonBar(ButtonBar $buttonBar, string $position, int $group)
    {
        parent::registerSaveButtonToButtonBar($buttonBar, $position, $group);
        $saveButton2 = $buttonBar->makeInputButton()
            ->setForm('EditDocumentController')
            ->setIcon($this->moduleTemplate->getIconFactory()->getIcon('actions-document-save-close', Icon::SIZE_SMALL))
            ->setName('_saveandclosedok')
            ->setShowLabelText(true)
            ->setTitle('Save and close')
            ->setValue('1');

        $buttonBar->addButton($saveButton2, $position, $group);
    }
}
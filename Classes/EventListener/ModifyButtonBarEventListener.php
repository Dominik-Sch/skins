<?php
declare(strict_types=1);

namespace Rubb1\Skins\EventListener;

use Exception;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\Buttons\ButtonInterface;
use TYPO3\CMS\Backend\Template\Components\Buttons\InputButton;
use TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * re-add save and close button
 */
final class ModifyButtonBarEventListener
{
    public function __construct(private IconFactory $iconFactory)
    {
    }

    public function __invoke(ModifyButtonBarEvent $event): void
    {
        $buttonBar = $event->getButtonBar();
        $buttons = $event->getButtons();

        $shouldAddBtn = false;
        foreach ($buttons[ButtonBar::BUTTON_POSITION_LEFT] ?? [] as $leftButtonGroup) {
            /** @var ButtonInterface $button */
            foreach ($leftButtonGroup as $button) {
                if ($button instanceof InputButton
                    && $button->getName() === '_savedok'
                    && $button->getForm() === 'EditDocumentController') {
                    $shouldAddBtn = true;
                }
            }
        }

        $extConf = [];
        try {
            $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('skins');
        } catch (Exception $e) {
            // config failed to load
        }

        if (isset($extConf['saveAndCloseEnabled']) && $extConf['saveAndCloseEnabled'] == '1') {
            if ($shouldAddBtn) {
                $button = $buttonBar->makeInputButton()
                    ->setForm('EditDocumentController')
                    ->setIcon($this->iconFactory->getIcon('actions-document-save-close', Icon::SIZE_SMALL))
                    ->setName('_skins_saveandclosedok')
                    ->setShowLabelText(true)
                    ->setTitle(
                        LocalizationUtility::translate(
                            'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:rm.saveCloseDoc'
                        )
                    )
                    ->setValue('1');
                /*$button = $buttonBar->makeFullyRenderedButton()
                    ->setHtmlSource('');
                ;*/
                $buttons[ButtonBar::BUTTON_POSITION_LEFT][2][] = $button;
                $event->setButtons($buttons);
            }
        }
    }
}

<?php
declare(strict_types=1);

namespace Rubb1\Skins\Hooks;

use Rubb1\Skins\Utility\FlexFormUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;

/**
 * hook for fixing flexforms for elements with `saveAndClose` set to `1`
 * TODO: maybe make it possible to set multiple flexform fields in Page tsconfig
 */
final class DataHandlerSaveAndCloseHook
{
    protected string $flexFormField = 'pi_flexform';

    public function processDatamap_preProcessFieldArray(
        array       &$incomingFieldArray,
        string      $table,
        ?string     $id,
        DataHandler $dataHandler
    ): void
    {
        $pid = (int)($incomingFieldArray['pid'] ?? '0');
        $cType = $incomingFieldArray['CType'] ?? '';

        // return early, if important values are not set
        if ($pid === 0 || !str_starts_with($id, 'NEW') || empty($cType)) {
            return;
        }

        $isSaveAndClose = $this->elementIsSaveAndClose($pid, $cType);

        if ($isSaveAndClose) {

            // get TCA config to check if the flexform field is used
            $tca = $GLOBALS['TCA']['tt_content']['types'][$cType] ?? [];
            $showItem = $tca['showitem'] ?? '';

            // use !isset instead of empty, because we only want to update the value, if the field is NULL
            if (str_contains($showItem, $this->flexFormField)
                && !isset($incomingFieldArray[$this->flexFormField])) {
                $incomingFieldArray[$this->flexFormField] = FlexFormUtility::populateNewFlexForm(
                    $pid,
                    $cType,
                    $this->flexFormField
                );
            }
        }
    }

    /**
     * finds the passed cType in the page TSConfig and determines if `saveAndClose` is set to `1`
     *
     * @param int $pid page ID where the element is added
     * @param string $cType CType of the element
     *
     * @return bool true, if the element has `saveAndClose` set to `1`
     */
    protected function elementIsSaveAndClose(int $pid, string $cType): bool
    {
        $tsConfig = BackendUtility::getPagesTSconfig($pid);
        $wizardGroups = $tsConfig['mod.']['wizards.']['newContentElement.']['wizardItems.'] ?? [];

        foreach ($wizardGroups as $groupData) {
            foreach ($groupData['elements.'] ?? [] as $element) {
                $elementCType = $element['tt_content_defValues.']['CType'] ?? '';
                if ($elementCType === $cType) {
                    $saveAndClose = $element['saveAndClose'] ?? '0';
                    return $saveAndClose === '1';
                }
            }
        }

        return false;
    }
}

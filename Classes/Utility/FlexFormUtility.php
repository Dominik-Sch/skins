<?php
declare(strict_types = 1);

namespace Rubb1\Skins\Utility;

use TYPO3\CMS\Backend\Form\FormDataCompiler;
use TYPO3\CMS\Backend\Form\FormDataGroup\TcaDatabaseRecord;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Utility for handling and processing flexforms
 */
final class FlexFormUtility {

    /**
     * adds a flexform to a type `flex` field. Works the same as {@see ExtensionManagementUtility::addPiFlexFormValue()}
     * but is more flexible
     *
     * @param string $dsFields one or multiple comma-separated fields to compare when loading flexform
     * @param string $flexFormContent flexform to display (FILE:EXT:....)
     * @param string $flexFormField database field to insert flexform into
     * @param string $table table to insert the flexform into
     */
    public static function addFlexForm(
        string $dsFields,
        string $flexFormContent,
        string $flexFormField = 'pi_flexform',
        string $table = 'tt_content'
    ): void {
        if (is_array($GLOBALS['TCA'][$table]['columns'])
            && is_array($GLOBALS['TCA'][$table]['columns'][$flexFormField]['config']['ds'])) {
            $GLOBALS['TCA'][$table]['columns'][$flexFormField]['config']['ds'][$dsFields] = $flexFormContent;
        }
    }

    /**
     * processes default values for a flexform (useful if working `saveAndClose` elements)
     *
     * @param int $incomingPid pid of the record
     * @param string $incomingCType ctype of the record
     * @param string $flexFormField database field of the flexform
     *
     * @return array processed default flexform
     */
    public static function populateNewFlexForm(
        int $incomingPid,
        string $incomingCType,
        string $flexFormField = 'pi_flexform'
    ): array {
        $formDataGroup = GeneralUtility::makeInstance(TcaDatabaseRecord::class);
        $formDataCompiler = GeneralUtility::makeInstance(FormDataCompiler::class, $formDataGroup);
        $formDataCompilerInput = [
            'command' => 'new',
            'tableName' => 'tt_content',
            'vanillaUid' => $incomingPid,
            'defaultValues' => [
                'tt_content' => [
                    'CType' => $incomingCType,
                ],
            ],
        ];
        $formData = $formDataCompiler->compile($formDataCompilerInput);
        return is_array($formData['databaseRow'][$flexFormField]) ? $formData['databaseRow'][$flexFormField] : [];
    }
}
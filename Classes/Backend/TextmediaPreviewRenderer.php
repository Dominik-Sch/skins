<?php
declare(strict_types=1);

namespace Rubb1\Skins\Backend;

use TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class TextmediaPreviewRenderer extends StandardContentPreviewRenderer
{
    protected string $template = 'EXT:skins/Resources/Private/Templates/PreviewRenderer/Textmedia.html';

    public function renderPageModulePreviewContent(GridColumnItem $item): string
    {
        $media = $this->getMedia($item);
        $standaloneView = GeneralUtility::makeInstance(StandaloneView::class);
        $standaloneView->setTemplatePathAndFilename($this->template);
        $standaloneView->assignMultiple([
            'record' => $item->getRecord(),
            'media' => $media,
        ]);
        return $standaloneView->render();
    }

    /**
     * @return FileReference[]
     */
    protected function getMedia($item): array
    {
        $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
        return $fileRepository->findByRelation('tt_content', 'assets', (int)$item->getRecord()['uid']);
    }
}

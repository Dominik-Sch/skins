<?php

declare(strict_types = 1);

namespace Rubb1\Skins\EventListener;

use TYPO3\CMS\Backend\Controller\Event\AfterFormEnginePageInitializedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Page\PageRenderer;

#[AsEventListener('rubb1/skins/insert-form-engine-javascript')]
final readonly class InsertFormEngineJavaScript {
    public function __construct(private PageRenderer $pageRenderer) {}

    public function __invoke(AfterFormEnginePageInitializedEvent $event): void {
        $this->pageRenderer->loadJavaScriptModule('@rubb1/skins/backend/form-engine/save-and-close.js');
    }
}

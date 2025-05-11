<?php

namespace Rubb1\Skins\Controller;

use Doctrine\DBAL\Exception;
use InvalidArgumentException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\ResponseFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BackendController
{
    protected array $defaultSettings = [
        "color-main-menue-background"=> "#0d0d0d",
        "color-main-menue-color"=> "#ffffff",
        "color-main-menue-border"=> "#383838",
        "color-pagetree-background"=> "#1a1a1a",
        "color-pagetree-color"=> "#ffffff",
        "color-pagetree-border"=> "#363636",
        "color-module-background"=> "#1c1c1c",
        "color-module-color"=> "#ffffff",
        "color-module-border"=> "#2e2e2e",
        "color-element-background"=> "#1a1a1a",
        "color-element-color"=> "#ffffff",
        "color-element-border"=> "#383838",
        "color-topbar-background"=> "#0f0f0f",
        "color-topbar-color"=> "#ffffff",
        "color-topbar-border"=> "#2b2b2b",
        "color-button-background"=> "#424242",
        "color-button-color"=> "#ffffff",
        "color-button-border"=> "#bababa",
        "color-highlight"=> "#ecf000",
        "color-scrollbar-color"=> "#8a8500",
        "width-scrollbar"=> "thin",
        "color-icon" => "#ffffff"
    ];

    /**
     * @throws Exception
     */
    public function saveAction(ServerRequestInterface $request): MessageInterface|ResponseInterface
    {
        $input = $request->getQueryParams()['input'] ?? null;
        if ($input === null) {
            throw new InvalidArgumentException('Please provide a number', 1580585107);
        }
        $beUserUcData = '';
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_users');
        $statement = $queryBuilder
            ->select('*')
            ->from('be_users')
            ->where(
                $queryBuilder->expr()->eq('uid', $GLOBALS['BE_USER']->user['uid'])
            )
            ->executeQuery();

        while ($row = $statement->fetchAssociative()) {
            // Do something with that single row
            $beUserUcData = unserialize($row['uc']);
        }
        if ($beUserUcData != '') {
            $beUserUcData['tx_skins_active'] = $input['tx_skins_active'];
            $beUserUcData['tx_skins_dark_mode_settings'] = $input['tx_skins_dark_mode_settings'];

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_users');
            $queryBuilder
                ->update('be_users')
                ->where(
                    $queryBuilder->expr()->eq('uid', $GLOBALS['BE_USER']->user['uid'])
                )
                ->set('uc', serialize($beUserUcData))
                ->executeStatement();

            $data = ['result' => 'true'];
        } else {
            $data = ['result' => 'false'];
        }
        $responseFactory = new ResponseFactory();
        $response = $responseFactory
            ->createResponse()
            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        $response->getBody()->write(json_encode($data));

        return $response;
    }

    public function loadAction(ServerRequestInterface $request): MessageInterface|ResponseInterface
    {
        // reset settings - just for development
        #unset($GLOBALS['BE_USER']->uc['tx_skins_active']);
        #unset($GLOBALS['BE_USER']->uc['tx_skins_dark_mode_settings']);

        $skinsDataArray = [];
        if (
            isset($GLOBALS['BE_USER']->uc['tx_skins_active']) &&
            isset($GLOBALS['BE_USER']->uc['tx_skins_dark_mode_settings'])
        ) {
            $skinsDataArray['tx_skins_active'] = $GLOBALS['BE_USER']->uc['tx_skins_active'];
            $skinsDataArray['tx_skins_dark_mode_settings'] = $GLOBALS['BE_USER']->uc['tx_skins_dark_mode_settings'];
        } else {
            $skinsDataArray['tx_skins_active'] = 0;
            $skinsDataArray['tx_skins_dark_mode_settings'] = json_encode($this->defaultSettings);
        }

        $data = ['result' => $skinsDataArray];

        $responseFactory = new ResponseFactory();
        $response = $responseFactory
            ->createResponse()
            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        $response->getBody()->write(json_encode($data));
        return $response;
    }
}

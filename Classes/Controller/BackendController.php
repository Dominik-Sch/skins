<?php

namespace Rubb1\Skins\Controller;

use Doctrine\DBAL\Exception;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Http\ResponseFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BackendController
{
    /**
     * @throws Exception
     */
    public function saveAction(ServerRequestInterface $request): \Psr\Http\Message\MessageInterface|\Psr\Http\Message\ResponseInterface
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

    public function loadAction(ServerRequestInterface $request): Response
    {
        $skinsDataArray = [];
        if (
            isset($GLOBALS['BE_USER']->uc['tx_skins_active']) &&
            isset($GLOBALS['BE_USER']->uc['tx_skins_dark_mode_settings'])) {
            $skinsDataArray['tx_skins_active'] = $GLOBALS['BE_USER']->uc['tx_skins_active'];
            $skinsDataArray['tx_skins_dark_mode_settings'] = $GLOBALS['BE_USER']->uc['tx_skins_dark_mode_settings'];
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

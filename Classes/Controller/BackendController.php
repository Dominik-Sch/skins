<?php

namespace Rubb1\Skins\Controller;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Http\ResponseFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BackendController
{
    public function saveAction(ServerRequestInterface $request): Response
    {
        $input = $request->getQueryParams()['input'] ?? null;
        if ($input === null) {
            throw new \InvalidArgumentException('Please provide a number', 1580585107);
        }
        $beUserUcData = '';
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_users');
        $statement = $queryBuilder
            ->select('*')
            ->from('be_users')
            ->where(
                $queryBuilder->expr()->eq('uid', $GLOBALS['BE_USER']->user['uid'])
            )
            ->execute();
        while ($row = $statement->fetch()) {
            // Do something with that single row
            $beUserUcData = unserialize($row['uc']);
        }
        if ($beUserUcData != '') {
            $beUserUcData['tx_skins_darkmode'] = intval($input['custom-skin']);
            $beUserUcData['tx_skins_custom_color_1'] = $input['color-1'];
            $beUserUcData['tx_skins_custom_color_2'] = $input['color-2'];
            $beUserUcData['tx_skins_custom_color_4'] = $input['color-4'];
            $beUserUcData['tx_skins_custom_color_5'] = $input['color-5'];
            $beUserUcData['tx_skins_custom_color_6'] = $input['color-6'];
            $beUserUcData['tx_skins_custom_color_7'] = $input['color-7'];
            $beUserUcData['tx_skins_custom_color_8'] = $input['color-8'];

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_users');
            $queryBuilder
                ->update('be_users')
                ->where(
                    $queryBuilder->expr()->eq('uid', $GLOBALS['BE_USER']->user['uid'])
                )
                ->set('uc', serialize($beUserUcData))
                ->execute();

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
        $skinsDataArray['tx_skins_darkmode'] = $GLOBALS['BE_USER']->uc['tx_skins_darkmode'];
        $skinsDataArray['tx_skins_custom_color_1'] = $GLOBALS['BE_USER']->uc['tx_skins_custom_color_1'] != null ? $GLOBALS['BE_USER']->uc['tx_skins_custom_color_1'] : "rgba(21, 21, 21, 1)";
        $skinsDataArray['tx_skins_custom_color_2'] = $GLOBALS['BE_USER']->uc['tx_skins_custom_color_2'] != null ? $GLOBALS['BE_USER']->uc['tx_skins_custom_color_2'] : "rgba(41, 41, 41, 1)";
        $skinsDataArray['tx_skins_custom_color_4'] = $GLOBALS['BE_USER']->uc['tx_skins_custom_color_4'] != null ? $GLOBALS['BE_USER']->uc['tx_skins_custom_color_4'] : "rgba(60, 63, 65, 1)";
        $skinsDataArray['tx_skins_custom_color_5'] = $GLOBALS['BE_USER']->uc['tx_skins_custom_color_5'] != null ? $GLOBALS['BE_USER']->uc['tx_skins_custom_color_5'] : "rgba(245, 245, 245, 1)";
        $skinsDataArray['tx_skins_custom_color_6'] = $GLOBALS['BE_USER']->uc['tx_skins_custom_color_6'] != null ? $GLOBALS['BE_USER']->uc['tx_skins_custom_color_6'] : "rgba(245, 245, 245, 0.3)";
        $skinsDataArray['tx_skins_custom_color_7'] = $GLOBALS['BE_USER']->uc['tx_skins_custom_color_7'] != null ? $GLOBALS['BE_USER']->uc['tx_skins_custom_color_7'] : "rgba(31, 31, 31, 1)";
        $skinsDataArray['tx_skins_custom_color_8'] = $GLOBALS['BE_USER']->uc['tx_skins_custom_color_8'] != null ? $GLOBALS['BE_USER']->uc['tx_skins_custom_color_8'] : "rgba(253, 195, 0, 1)";

        $data = ['result' => $skinsDataArray];

        $responseFactory = new ResponseFactory();
        $response = $responseFactory
            ->createResponse()
            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        $response->getBody()->write(json_encode($data));
        return $response;
    }
}
<?php

namespace WapplerSystems\Pretix\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\DebugUtility;
use WapplerSystems\Pretix\Service\ApiService;


/**
 */
class EventsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{


    public function __construct(readonly ApiService $apiService)
    {
    }



    public function listAction(): ResponseInterface
    {
        $events = $this->apiService->getEvents();

        DebugUtility::debug($events);

        $this->view->assignMultiple([
            'events' => $events,
            'settings' => $this->settings,
        ]);

        return $this->htmlResponse();
    }



}

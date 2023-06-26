<?php

namespace WapplerSystems\Pretix\Controller;

use Psr\Http\Message\ResponseInterface;
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


        $this->view->assignMultiple([
            'events' => $events,
            'settings' => $this->settings,
        ]);

        return $this->htmlResponse();
    }



}

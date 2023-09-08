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

        if (($this->settings['event'] ?? '') !== '') {

            $event = $this->apiService->getEvent($this->settings['event']);
            if ($event !== null) {
                $subEvents = $this->apiService->getSubEvents($event);
                $filteredSubEvents = [];
                foreach ($subEvents as $subEvent) {
                    if (($subEvent['active'] ?? false) && strtotime($subEvent['date_from']) > time()) {
                        $filteredSubEvents[] = $subEvent;
                    }
                }

                $this->view->assignMultiple([
                    'event' => $event,
                    'subEvents' => $filteredSubEvents,
                ]);
            }
        } else {

            $events = $this->apiService->getEvents();
            $this->view->assignMultiple([
                'events' => $events,
            ]);
        }

        $this->view->assignMultiple([
            'settings' => $this->settings,
        ]);

        return $this->htmlResponse();
    }



}

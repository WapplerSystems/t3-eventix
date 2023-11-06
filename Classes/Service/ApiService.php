<?php
declare(strict_types=1);

namespace WapplerSystems\Pretix\Service;


use ItkDev\Pretix\Api\Client;
use ItkDev\Pretix\Api\Collections\EntityCollection;
use ItkDev\Pretix\Api\Entity\Event;
use ItkDev\Pretix\Api\Entity\SubEvent;
use ItkDev\Pretix\Api\Exception\ClientException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ApiService
{

    protected bool $connected = false;

    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {

    }

    /**
     * @throws Exception
     * @throws ExtensionConfigurationPathDoesNotExistException
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     */
    private function connect()
    {
        if ($this->connected) {
            return;
        }

        $token = GeneralUtility::makeInstance(ExtensionConfiguration::class)
            ->get('pretix', 'token');
        $organizer = GeneralUtility::makeInstance(ExtensionConfiguration::class)
            ->get('pretix', 'organizer');
        if (empty($token)) {
            throw new Exception('no pretix token given');
        }

        $options = [];
        $options['api_token'] = $token;
        $options['organizer'] = $organizer;

        $this->client = GeneralUtility::makeInstance(Client::class, $options);
        $this->connected = true;
    }

    public function getEvents(): ?EntityCollection
    {
        $this->connect();
        return $this->client->getEvents();
    }

    public function getEvent(string $event): \ItkDev\Pretix\Api\Entity\AbstractEntity|\ItkDev\Pretix\Api\Entity\Event|null
    {
        $this->connect();
        try {
            return $this->client->getEvent($event);
        } catch (ClientException $e) {
            return null;
        }
    }

    public function getSubEvents(Event $event, array $query = null): ?EntityCollection
    {
        $this->connect();

        if ($event->hasSubevents()) {
            return $this->client->getSubEvents($event, $query);
        }
        return null;
    }

    public function getQuotas(Event $event, SubEvent $subEvent = null) : ?EntityCollection {
        $this->connect();

        $options = [
            'with_availability' => 'true',
        ];
        if ($subEvent !== null) {
            $options['subevent'] = $subEvent->getId();
            $options['subevent_in'] = $subEvent->getId();
        }
        return $this->client->getQuotas($event, $options);
    }


}

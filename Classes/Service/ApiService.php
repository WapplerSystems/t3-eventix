<?php
declare(strict_types=1);

namespace WapplerSystems\Pretix\Service;


use ItkDev\Pretix\Api\Client;
use ItkDev\Pretix\Api\Entity\Event;
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

    public function getEvents(): array
    {
        $this->connect();
        return $this->client->getEvents()->toArray();
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

    public function getSubEvents(Event $event): array
    {
        $this->connect();

        if ($event->hasSubevents()) {
            return $this->client->getSubEvents($event)->toArray();
        }
        return [];
    }


}

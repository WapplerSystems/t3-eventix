<?php
declare(strict_types=1);
namespace WapplerSystems\Pretix\Service;



use ItkDev\Pretix\Api\Client;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ApiService {

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
    private function connect() {
        if ($this->connected) {
            return;
        }

        $token = GeneralUtility::makeInstance(ExtensionConfiguration::class)
            ->get('pretix', 'token');
        if (empty($token)) {
            throw new Exception('no pretix token given');
        }

        $options = [];
        $options['api_token'] = $token;

        $this->client = GeneralUtility::makeInstance(Client::class, $options);
        $this->connected = true;
    }

    public function getEvents() : array {


        $events = $this->client->getEvents();

        return $events;
    }


}

<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use WapplerSystems\Pretix\Controller\EventsController;


if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pretix'] ?? null)) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pretix'] = [
        'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
        'backend' => \TYPO3\CMS\Core\Cache\Backend\FileBackend::class,
        'options' => [
            'defaultLifetime' => 0,
        ]
    ];
}

ExtensionUtility::configurePlugin(
    'pretix',
    'Events',
    [
        EventsController::class => 'list',
    ],
    [
        EventsController::class => 'list',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);


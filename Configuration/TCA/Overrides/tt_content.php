<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

ExtensionUtility::registerPlugin(
    'pretix',
    'Events',
    'LLL:EXT:pretix/Resources/Private/Language/Backend.xlf:tt_content.CType.pretix_events.title',
    'mimetypes-x-content-pretix',
    'Pretix'
);


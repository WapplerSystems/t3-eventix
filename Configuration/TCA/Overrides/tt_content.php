<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;


ExtensionUtility::registerPlugin(
    'pretix',
    'Events',
    'LLL:EXT:pretix/Resources/Private/Language/Backend.xlf:tt_content.CType.pretix_events.title',
    'mimetypes-x-content-pretix',
    'Pretix'
);

ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:pretix/Configuration/FlexForms/Events.xml',
    'pretix_events'
);

// Add the FlexForm to the show item list
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pi_flexform',
    'pretix_events',
    'after:palette:headers'
);

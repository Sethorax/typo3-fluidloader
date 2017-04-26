<?php

defined('TYPO3_MODE') or die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', [
    'tx_fluidloader_layout' => [
        'exclude' => 1,
        'label'   => 'Seitenlayout',
        'config'  => [
            'type'          => 'select',
            'renderType'    => 'selectSingle',
            'itemsProcFunc' => 'Sethorax\Fluidloader\Backend\TemplateFileLayoutSelector->addLayoutOptions',
        ],
    ],
]);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages',
    'tx_fluidloader_layouts',
    'tx_fluidloader_layout'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--div--;Seitenlayout,
    --palette--;Allgemein;tx_fluidloader_layouts'
);

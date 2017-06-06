<?php

defined('TYPO3_MODE') or die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', [
    'tx_fluidloader_layout' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:fluidloader/Resources/Private/Language/locallang.xlf:pages.tx_fluidloader_layout',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'itemsProcFunc' => 'Sethorax\Fluidloader\Backend\TemplateFileLayoutSelector->addLayoutOptions'
        ]
    ],
    'tx_fluidloader_subpage_layout' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:fluidloader/Resources/Private/Language/locallang.xlf:pages.tx_fluidloader_subpage_layout',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'itemsProcFunc' => 'Sethorax\Fluidloader\Backend\TemplateFileLayoutSelector->addLayoutOptions'
        ]
    ]
]);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages',
    'tx_fluidloader_layouts',
    'tx_fluidloader_layout,tx_fluidloader_subpage_layout'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--div--;LLL:EXT:fluidloader/Resources/Private/Language/locallang.xlf:pages.tx_fluidloader_layout,
    --palette--;LLL:EXT:fluidloader/Resources/Private/Language/locallang.xlf:pages.palettes.page_layout;tx_fluidloader_layouts'
);

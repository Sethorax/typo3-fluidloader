<?php

defined('TYPO3_MODE') or die('Access denied.');

// Plugin for frontend rendering
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Sethorax.Fluidloader',
    'Page',
    [
        'Page' => 'render,error',
    ],
    [],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);


// Register Backend Layout Data Provider
if (TYPO3_MODE === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['BackendLayoutDataProvider'][$_EXTKEY] = \Sethorax\Fluidloader\Provider\BackendLayoutDataProvider::class;
}

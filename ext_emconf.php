<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Fluid Template Loader',
    'description' => 'Automatic fluid template loader. This extension automatically loads .html templates in a given directory.',
    'category' => 'fluid',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Sethorax',
    'author_email' => 'info@sethorax.com',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.99',
        ]
    ]
];

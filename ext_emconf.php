<?php
/************************************************************************
 * Extension Manager/Repository config file for ext "svg_sanitizer".
 ************************************************************************/
$EM_CONF[$_EXTKEY] = [
    'title' => 'SVG Sanitizer',
    'description' => 'Sanitize SVG files on upload',
    'category' => 'extension',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.13-10.4.99'
        ],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'T3G\\SvgSanitizer\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Frank Nägler',
    'author_email' => 'frank.naegler@typo3.com',
    'author_company' => 'TYPO3 GmbH',
    'version' => '1.0.3',
];

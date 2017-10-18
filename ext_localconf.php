<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function () {
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class)
        ->connect(
            \TYPO3\CMS\Core\Resource\ResourceStorage::class,
            \TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PreFileAdd,
            \T3G\SvgSanitizer\SignalSlot\ResourceStorage::class,
            \TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PreFileAdd
        );
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class)
        ->connect(
            \TYPO3\CMS\Core\Resource\ResourceStorage::class,
            \TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PreFileReplace,
            \T3G\SvgSanitizer\SignalSlot\ResourceStorage::class,
            \TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PreFileReplace
        );
});

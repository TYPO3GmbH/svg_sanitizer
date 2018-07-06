<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function () {
    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
    $signalSlotDispatcher
        ->connect(
            \TYPO3\CMS\Core\Resource\ResourceStorage::class,
            \TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PreFileAdd,
            \T3G\SvgSanitizer\SignalSlot\ResourceStorage::class,
            \TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PreFileAdd
        );
    $signalSlotDispatcher
        ->connect(
            \TYPO3\CMS\Core\Resource\ResourceStorage::class,
            \TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PreFileReplace,
            \T3G\SvgSanitizer\SignalSlot\ResourceStorage::class,
            \TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PreFileReplace
        );
    $signalSlotDispatcher
        ->connect(
            \TYPO3\CMS\Core\Resource\ResourceStorage::class,
            \TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PostFileSetContents,
            \T3G\SvgSanitizer\SignalSlot\ResourceStorage::class,
            \TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PostFileSetContents
        );

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processUpload']['svg_sanitizer']
        = \T3G\SvgSanitizer\Hooks\DataHandlerHook::class;

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Core\Utility\GeneralUtility']['moveUploadedFile'][]
        = \T3G\SvgSanitizer\Hooks\GeneralUtilityHook::class . '->processMoveUploadedFile';


    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\T3G\SvgSanitizer\Updates\SanitizeExistingSVG::class]
        = \T3G\SvgSanitizer\Updates\SanitizeExistingSVG::class;

});

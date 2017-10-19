<?php

namespace T3G\SvgSanitizer\SignalSlot;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use T3G\SvgSanitizer\Service\SvgSanitizerService;
use TYPO3\CMS\Core\Resource\Driver\DriverInterface;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ResourceStorage {

    /**
     * @param string $targetFileName
     * @param Folder $targetFolder
     * @param string $sourceFilePath
     * @param \TYPO3\CMS\Core\Resource\ResourceStorage $parentObject
     * @param DriverInterface $driver
     *
     * @throws \InvalidArgumentException
     */
    public function preFileAdd(&$targetFileName, $targetFolder, $sourceFilePath, $parentObject, $driver)
    {
        $fileParts = GeneralUtility::trimExplode('.', $targetFileName);
        $fileExtension = strtolower(array_pop($fileParts));
        if ($fileExtension === 'svg') {
            GeneralUtility::makeInstance(SvgSanitizerService::class)
                ->sanitizeSvgFile($sourceFilePath);
        }
    }

    /**
     * @param FileInterface $file
     * @param string $localFilePath
     *
     * @throws \InvalidArgumentException
     */
    public function preFileReplace($file, $localFilePath)
    {
        if (strtolower($file->getExtension()) === 'svg') {
            GeneralUtility::makeInstance(SvgSanitizerService::class)
                ->sanitizeSvgFile($localFilePath);
        }
    }
}

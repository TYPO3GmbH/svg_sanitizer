<?php

/*
 * This file is part of the package t3g/svg-sanitizer.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\SvgSanitizer\EventListener;

/*
 * This file is part of the TYPO3 extension svg_sanitizer.
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
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ResourceStorageListener
{
    /**
     * @param string $targetFileName
     * @param Folder $targetFolder
     * @param string $sourceFilePath
     * @param ResourceStorage $parentObject
     * @param DriverInterface $driver
     *
     * @throws \InvalidArgumentException
     */
    public function preFileAdd(&$targetFileName, $targetFolder, $sourceFilePath, $parentObject, $driver)
    {
        $svgService = GeneralUtility::makeInstance(SvgSanitizerService::class);
        if ($svgService->isSvgFile($sourceFilePath)) {
            $svgService->sanitizeSvgFile($sourceFilePath);
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
        $svgService = GeneralUtility::makeInstance(SvgSanitizerService::class);
        if ($svgService->isSvgFile($localFilePath)) {
            $svgService->sanitizeSvgFile($localFilePath);
        }
    }

    /**
     * @param FileInterface $file
     * @param string $content
     *
     * @throws \InvalidArgumentException
     */
    public function postFileSetContents($file, $content)
    {
        $svgService = GeneralUtility::makeInstance(SvgSanitizerService::class);
        if ($svgService->isSvgFile($file->getForLocalProcessing(false))) {
            $newContent = $svgService->sanitizeAndReturnSvgContent($content);
            // prevent endless loop because this hook is called again and again and again and...
            if ($newContent !== $content) {
                $file->setContents($newContent);
            }
        }
    }
}

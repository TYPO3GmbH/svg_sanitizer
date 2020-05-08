<?php

/*
 * This file is part of the package t3g/svg-sanitizer.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\SvgSanitizer\Hooks;

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
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\DataHandling\DataHandlerProcessUploadHookInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class DataHandlerHook
 */
class DataHandlerHook implements DataHandlerProcessUploadHookInterface
{

    /**
     * Post-process a file upload.
     *
     * @param string $filename The uploaded file
     * @param DataHandler $parentObject
     *
     * @throws \InvalidArgumentException
     */
    public function processUpload_postProcessAction(&$filename, DataHandler $parentObject)
    {
        $svgService = GeneralUtility::makeInstance(SvgSanitizerService::class);
        if ($svgService->isSvgFile($filename)) {
            $svgService->sanitizeSvgFile($filename);
        }
    }
}

<?php

namespace T3G\SvgSanitizer\Service;

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

use enshrined\svgSanitize\Sanitizer;

class SvgSanitizerService {

    /**
     * @param string $fileNameAndPath
     * @param string $outputFileNameAndPath
     */
    public function sanitizeSvgFile($fileNameAndPath, $outputFileNameAndPath = null)
    {
        if ($outputFileNameAndPath === null) {
            $outputFileNameAndPath = $fileNameAndPath;
        }
        $sanitizer = new Sanitizer();
        $sanitizer->removeRemoteReferences(true);
        $dirtySVG = file_get_contents($fileNameAndPath);
        $cleanSVG = $sanitizer->sanitize($dirtySVG);
        file_put_contents($outputFileNameAndPath, $cleanSVG);
    }
}

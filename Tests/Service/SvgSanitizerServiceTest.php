<?php

namespace T3G\SvgSanitizer\Tests\Service;

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
use TYPO3\TestingFramework\Core\BaseTestCase;

/**
 * Class SvgSanitizerService
 */
class SvgSanitizerServiceTest extends BaseTestCase
{
    public function setUp()
    {
        if (!class_exists(\enshrined\svgSanitize\Sanitizer::class)) {
            $extensionBasePath = dirname(__DIR__ . '/../../../');
            @include 'phar://' . $extensionBasePath . '/Libraries/enshrined-svg-sanitize.phar/vendor/autoload.php';
        }
        parent::setUp();
    }
    /**
     * @return array
     */
    public function svgImagesDataProvider()
    {
        return [
            'TYPO3_Logo_Clean' => ['DirtySVG/TYPO3_Logo_Clean.svg', 'CleanSVG/TYPO3_Logo_Clean.svg'],
            'TYPO3_Logo_Script' => ['DirtySVG/TYPO3_Logo_Script.svg', 'CleanSVG/TYPO3_Logo_Script.svg'],
            'TYPO3_Logo_Data' => ['DirtySVG/TYPO3_Logo_Data.svg', 'CleanSVG/TYPO3_Logo_Data.svg'],
        ];
    }

    /**
     * @param string $inputFile
     * @param string $expectedOutputFile
     * @dataProvider svgImagesDataProvider
     */
    public function testThatImagesCanBeCleaned($inputFile, $expectedOutputFile)
    {
        $basePath = dirname(__DIR__ . '/../../') . '/Fixtures/';
        $service = new SvgSanitizerService();
        self::assertStringEqualsFile(
            $basePath . $expectedOutputFile,
            $service->sanitizeAndReturnSvgContent(file_get_contents($basePath . $inputFile))
        );
    }
}

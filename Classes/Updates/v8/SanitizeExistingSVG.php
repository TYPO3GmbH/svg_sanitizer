<?php

/*
 * This file is part of the package t3g/svg-sanitizer.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\SvgSanitizer\Updates\v8;

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

use T3G\SvgSanitizer\Service\UpdateService;
use TYPO3\CMS\Core\Registry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\AbstractUpdate;

/**
 * Class SanitizeExistingSVG
 */
class SanitizeExistingSVG extends AbstractUpdate
{
    /**
     * @var string
     */
    protected $title = '[EXT:svg_sanitizer] Scan and sanitize existing SVG files in fileadmin folder';

    /**
     * Checks if an update is needed
     *
     * @param string &$description The description for the update
     * @return bool Whether an update is needed (TRUE) or not (FALSE)
     */
    public function checkForUpdate(&$description)
    {
        if ($this->isWizardDone()) {
            return false;
        }
        return true;
    }

    /**
     * Second step: Ask user to sanitize existing SVG files
     *
     * @param string $inputPrefix input prefix, all names of form fields have to start with this. Append custom name in [ ... ]
     * @return string HTML output
     */
    public function getUserInput($inputPrefix)
    {
        $markup = [];
        $markup[] = '<div class="panel panel-danger">';
        $markup[] = '  <div class="panel-heading">Are you really sure?</div>';
        $markup[] = '  <div class="panel-body">';
        $markup[] = '    <p>This upgrade wizard will sanitize all SVG file in the fileadmin folder.</p>';
        $markup[] = '    <p>This means that the content of your SVG files will be changed. This automatic process can break your SVG files.</p>';
        $markup[] = '    <p><strong>PLEASE: Create a backup of your SVG files, before starting this wizard!</strong></p>';
        $markup[] = '    <p>Are you really sure, you want to do this now?</p>';
        $markup[] = '    <div class="btn-group clearfix" data-toggle="buttons">';
        $markup[] = '      <label class="btn btn-default active">';
        $markup[] = '        <input type="radio" name="' . $inputPrefix . '[sanitize]" value="0" checked="checked" /> no, don\'t sanitize';
        $markup[] = '      </label>';
        $markup[] = '      <label class="btn btn-default">';
        $markup[] = '        <input type="radio" name="' . $inputPrefix . '[sanitize]" value="1" /> yes, please sanitize';
        $markup[] = '      </label>';
        $markup[] = '    </div>';
        $markup[] = '  </div>';
        $markup[] = '</div>';
        return implode(LF, $markup);
    }

    /**
     * Performs the update
     *
     * @param array &$databaseQueries Queries done in this update
     * @param string &$customMessage Custom message
     *
     * @return bool
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function performUpdate(array &$databaseQueries, &$customMessage)
    {
        $requestParams = GeneralUtility::_GP('install');
        if (!isset($requestParams['values']['T3G\SvgSanitizer\Updates\SanitizeExistingSVG']['sanitize'])) {
            return false;
        }
        $sanitize = (int)$requestParams['values']['T3G\SvgSanitizer\Updates\SanitizeExistingSVG']['sanitize'];

        if ($sanitize === 1) {
            GeneralUtility::makeInstance(UpdateService::class)->executeUpdate();
        }

        // Mark v9 upgrade wizard also as done (bad hack, but required)
        GeneralUtility::makeInstance(Registry::class)->set('installUpdate', 'T3G\SvgSanitizer\Updates\v9\SanitizeExistingSVG', 1);
        $this->markWizardAsDone();
        return true;
    }
}

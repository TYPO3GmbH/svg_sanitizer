# SVG Sanitizer

This extension sanitize every SVG file which is uploaded via FAL API.

## Important to know

This extension remove all script and data values in attributes.
This means, that also an embedded PNG is removed. example:

```
   // before parser
   <image width="100" height="100" xlink:href="data:image/png;base64,xxxx"/>
   // after parser
   <image width="100" height="100" />
```

## What this extension does

- Hooks into FAL API: ``ResourceFactory::addFile()`` and ``ResourceFactory::replaceFile()``
- Hooks into FAL API: ``ResourceStorage::setFileContents()``
- Hooks into DataHandler: Handling files for group/select function
- Hooks into ``GeneralUtility::upload_copy_move()``
- Hooks into ``GeneralUtility::upload_to_tempfile()``
- Provide an upgrade wizard for existing SVG files (please read the warnings in the upgrade wizard carefully)

## Credits

Thanks to Daryll Doyle and his [svg-sanitizer library](https://github.com/darylldoyle/svg-sanitizer)

## Bundling PHAR of external library

The process of bundling a composer package into a dedicated PHAR archive has been taken
from blog post ["How to use PHP libraries in legacy extensions"](http://insight.helhum.io/post/148112375750/how-to-use-php-libraries-in-legacy-extensions).

First install bundler package `clue/phar-composer` globally

```
composer global require clue/phar-composer
```

Then inside the extension folder create the PHAR archive
(in case global composer binaries are not part of the PATH environment, it's
possible to invoke `~/.composer/vendor/bin/phar-composer)` directly)

```
cd typo3conf/ext/svg_sanitizer
phar-composer build enshrined/svg-sanitize Libraries/enshrined-svg-sanitize.phar
```

## Issue Reporting

Please report any issues with the extension in our [Service Desk](https://jira.typo3.com/servicedesk/customer/portal/3/create/122).
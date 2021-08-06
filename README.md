# SVG Sanitizer

This extension will sanitize any SVG file uploaded to the TYPO3 system, but only with the default options.
Please read the following section carefully for all details.

## Important to know

This extension removes all script and data values in attributes.
This means that, for example, embedded graphics such as PNGs are also removed:

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

## WARNING

This extension can only sanitize the files if the upload is done in one of the ways described above.
For example, if a third-party extension allows to upload files and does not use the core APIs described above, SVG Sanitizer cannot sanitize these files.

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

Please report any issues with the extension at [Github](https://github.com/TYPO3GmbH/svg_sanitizer/issues).

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

## Credits
Thanks to Daryll Doyle and his [svg-sanitizer library](https://github.com/darylldoyle/svg-sanitizer)

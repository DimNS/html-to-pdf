# HtmlToPdf
Facade to convert html into pdf, uses the library mpdf

## Install
```bash
composer require dimns/html-to-pdf
```

## Methods
```php
public HtmlToPdf::__construct ( string $path_to_folder [, array $mpdf_config ] )
```
- $path_to_folder *(string)* **Required** - Path to the folder where the file will be placed
- $mpdf_config *(array)* **Optional** - Redefining Mpdf settings
  
  Default settings:
  ```php
  [
      'format'              => 'A4',
      'orientation'         => 'portrait',
      'default_font'        => 'arial',
      'setAutoTopMargin'    => 'stretch',
      'setAutoBottomMargin' => 'stretch',
  ]
  ```
```php
public HtmlToPdf::create ( string $html_body [, string $html_header = null [, string $html_footer = null ]] ) : string
```
- $html_body *(string)* **Required** - Content
- $html_header *(string)* **Optional** - Header
- $html_footer *(string)* **Optional** - Footer

## Usage

### Simple
![Simple usage](https://github.com/dimns/html-to-pdf/raw/master/screenshots/screenshot1.png "Simple usage")
```php
<?php
use DimNS\HtmlToPdf\HtmlToPdf;
use Mpdf\MpdfException;

require_once 'vendor/autoload.php';

$htp = new HtmlToPdf(__DIR__);

$html_body = <<<HTML
<h1>
    Test html to pdf
</h1>
<p>
    <strong>Test</strong> <i>string</i> with <a href="https://domain.tld">link</a>
</p>
HTML;

try {
    echo $htp->create($html_body);
} catch (MpdfException $e) {
    echo $e->getMessage();
}
```

### Advanced
![Advanced usage](https://github.com/dimns/html-to-pdf/raw/master/screenshots/screenshot2.png "Advanced usage")
```php
<?php
use DimNS\HtmlToPdf\HtmlToPdf;
use Mpdf\MpdfException;

require_once 'vendor/autoload.php';

$htp = new HtmlToPdf(__DIR__, [
    'format'         => 'A6',
    'orientation'    => 'landscape',
    'defaultCssFile' => '/path/to/style.css',
]);

$html_body = <<<HTML
<h1>
    Test html to pdf with header and footer
</h1>
<p>
    <strong>Test</strong> <i>string</i> with <a href="https://domain.tld">link</a>
</p>
HTML;

$html_header = <<<HTML
<p>
    <strong>This is header</strong>
</p>
<hr>
HTML;

$html_footer = <<<HTML
<hr>
<p>
    <strong>This is footer</strong>
</p>
HTML;

try {
    echo $htp->create($html_body, $html_header, $html_footer);
} catch (MpdfException $e) {
    echo $e->getMessage();
}
```

\* style.css
```css
.table {
    width: 100%;
}

.text-left {
    text-align: left;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

h1 {
    font-size: 16pt;
    color: green;
}
```
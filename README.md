# [PSR-3](http://www.php-fig.org/psr/psr-3/) context logger decorator

[![Linux Build Status](https://travis-ci.org/WyriHaximus/php-psr-3-context-logger.png)](https://travis-ci.org/WyriHaximus/php-psr-3-context-logger)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/psr-3-context-logger/v/stable.png)](https://packagist.org/packages/WyriHaximus/psr-3-context-logger)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/psr-3-context-logger/downloads.png)](https://packagist.org/packages/WyriHaximus/psr-3-context-logger/stats)
[![Code Coverage](https://scrutinizer-ci.com/g/WyriHaximus/php-psr-3-context-logger/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/WyriHaximus/php-psr-3-context-logger/?branch=master)
[![License](https://poser.pugx.org/WyriHaximus/psr-3-context-logger/license.png)](https://packagist.org/packages/wyrihaximus/psr-3-context-logger)
[![PHP 7 ready](http://php7ready.timesplinter.ch/WyriHaximus/php-psr-3-context-logger/badge.svg)](https://travis-ci.org/WyriHaximus/php-psr-3-context-logger)

### Installation ###

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require wyrihaximus/psr-3-context-logger 
```

## Usage without prefix

Without prefix the message remains untouched and just the context is merged.

```php
$logger = new Psr3Logger();
$contextLogger = new ContextLogger($logger, ['key' => 'value']);
$contextLogger->info('Message'); // $logger will be called with: log('info', 'Message', ['key' => 'value']);
```

## Usage with prefix

With prefix the given prefix, for example `Github` will be prefixed to the message within brackets: `[Github] `.

```php
$logger = new Psr3Logger();
$contextLogger = new ContextLogger($logger, ['key' => 'value'], 'Prefix');
$contextLogger->info('Message'); // $logger will be called with: log('info', '[Prefix] Message', ['key' => 'value']);
```

## Contributing ##

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License ##

Copyright 2018 [Cees-Jan Kiewiet](http://wyrihaximus.net/)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

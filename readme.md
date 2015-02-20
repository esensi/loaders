## Esensi Loaders Traits Package

[![Build Status](https://travis-ci.org/esensi/loaders.svg)](https://travis-ci.org/esensi/loaders)
[![Total Downloads](https://poser.pugx.org/esensi/loaders/downloads.svg)](https://packagist.org/packages/esensi/loaders)
[![Latest Stable Version](https://poser.pugx.org/esensi/loaders/v/stable.svg)](https://github.com/esensi/loaders/releases)
[![License](https://poser.pugx.org/esensi/loaders/license.svg)](https://github.com/esensi/loaders#licensing)

An [Esensi](https://github.com/esensi) package, coded by [Emerson Media](http://www.emersonmedia.com).

> **Want to work with us on great Laravel applications?**
Email us at [careers@emersonmedia.com](http://emersonmedia.com/contact)

The `Esensi/Loader` package is just one package that makes up [Esensi](https://github.com/esensi), a platform built on [Laravel](http://laravel.com). Laravel 4 used the same loader as translation and view services for config files. With Laravel 5 this loader did not support namespaced configs. This package fixes that up and also adds namespaced alias files for better package development. This package uses [PHP traits](http://culttt.com/2014/06/25/php-traits) to supplement Laravel's missing namespaced config and alias loaders. Using traits allows for a high-degree of code reusability and extensibility. While this package provides a reasonable base service provider, developers are free to mix and match traits into any class that needs to make use of namespaced loaders. Using contracts, developers can be confident that the code complies to a reliable interface and is properly unit tested. For more details on the inner workings of the traits please consult the generously documented source code.

> **Have a project in mind?**
Email us at [sales@emersonmedia.com](http://emersonmedia.com/contact), or call 1.877.439.6665.



## Quick Start

> **Notice:** This code is specifically designed to be compatible with the [Laravel Framework](http://laravel.com) and may not be compatible as a stand-alone dependency or as part of another framework.



## Table of Contents

> **Help Write Better Documentation:** The documentation is still a work in progress. You can help others learn to reuse code by contributing better documentation as a pull request.

- **[Installation](#installation)**
- **[Alias Loader](#alias-loader)**
- **[Config Loader](#config-loader)**
- **[Unit Testing](#unit-testing)**
    - [Running the Unit Tests](#running-the-unit-tests)
- **[Contributing](#contributing)**
- **[Licensing](#licensing)**



## Installation

Add the `esensi/loaders` package as a dependency to the application. Using [Composer](https://getcomposer.org), this can be done from the command line:

```bash
composer require esensi/loaders 0.5.*
```

Or manually it can be added to the `composer.json` file:

```json
{
    "require": {
        "esensi/loaders": "0.5.*"
    }
}
```

If manually adding the package, then be sure to run `composer update` to update the dependencies.


## Alias Loader


## Config Loader


## Unit Testing

The [Esensi](http://github.com/esensi) platform includes other great packages just like this [Esensi/Loaders](http://github.com/esensi/loaders) package. This package is currently tagged as `0.5.x` because the other platform packages are not ready for public release. While the others may still be under development, this package already includes features that would be mature enough for a `1.x` release including unit testing and extensive testing in real-world applications.

### Running the Unit Tests

This package uses [PHPUnit](http://phpunit.de) to automate the code testing process. It is included as one of the development dependencies in the `composer.json` file:

```json
{
    "require-dev": {
        "phpunit/phpunit": "4.1.*",
        "mockery/mockery": "0.9.*"
    }
}
```

The test suite can be ran from the command line using the `phpunit` test runner:

```bash
phpunit ./tests
```

> **Pro Tip:** Please help the open-source community by including good code test coverage with your pull requests. The Esensi development team will review pull requests with unit tests and passing tests as a priority. Significant code changes that do not include unit tests will _not_ be merged.



## Contributing

[Emerson Media](http://www.emersonmedia.com) is proud to work with some of the most talented developers in the PHP community. The developer team welcomes requests, suggestions, issues, and of course pull requests. When submitting issues please be as detailed as possible and provide code examples where possible. When submitting pull requests please follow the same code formatting and style guides that the Esensi code base uses. Please help the open-source community by including good code test coverage with your pull requests. **All pull requests _must_ be submitted to the version branch to which the code changes apply.**

> **Note:** The Esensi team does its best to address all issues on Wednesdays. Pull requests are reviewed in priority followed by urgent bug fixes. Each week the package dependencies are re-evaluated and updates are made for new tag releases.



## Licensing

Copyright (c) 2015 [Emerson Media, LP](http://www.emersonmedia.com)

This package is released under the MIT license. Please see the [LICENSE.txt](https://github.com/esensi/loaders/blob/master/LICENSE.txt) file distributed with every copy of the code for commercial licensing terms.

<div align="center">
    <a href="#"><img src="logo-linna-96.png" alt="Linna Logo"></a>
</div>

<br/>

<div align="center">
    <a href="#"><img src="logo-dotenv.png" alt="Linna dotenv Logo"></a>
</div>

<br/>

<div align="center">
    
[![Tests](https://github.com/linna/dotenv/actions/workflows/tests.yml/badge.svg)](https://github.com/linna/dotenv/actions/workflows/tests.yml)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/linna/dotenv/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/linna/dotenv/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/linna/dotenv/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/linna/dotenv/?branch=master)
[![StyleCI](https://github.styleci.io/repos/145428565/shield?branch=master&style=flat)](https://github.styleci.io/repos/145428565)
[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg?style=flat)](https://github.com/php-pds/skeleton)
[![PHP 7.2](https://img.shields.io/badge/PHP-7.2-8892BF.svg)](http://php.net)

</div>

# About
This package provide a way to load .env files values as environement variable, it was insiperd by [nodejs counterpart](https://github.com/motdotla/dotenv).

## Requirements
This package require php 7.2

## Installation
With composer:
```
composer require linna/dotenv
```

## Usage
.env.test file as example
```
APP=linna
APP_ENV=production
USER=user.name@linna.tools
FOO=foo
BAR=bar
BAZ=baz
```

php code for get above values
```php
$env = new Linna\DotEnv\DotEnv();
$env->load('.env.test');

$app = $env->get('APP');
$app_env = $env->get('APP_ENV');

//string 'linna' (length=5)
var_dump($app);

//string 'production' (length=10)
var_dump($app_env);
```

environment information in phpinfo()
```php
phpinfo(INFO_ENVIRONMENT);
```

![phpinfo(INFO_ENVIRONMENT)](dotenv-screen.png)

## Notes
DotEnv class use php function [getenv](http://php.net/manual/en/function.getenv.php) and [putenv](http://php.net/manual/en/function.putenv.php) then 
key and values will not be loaded in `$_ENV` superglobal.

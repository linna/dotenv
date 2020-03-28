
# Linna DotEnv Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
## [v1.0.2](https://github.com/linna/dotenv/compare/v1.0.1...v1.0.2) - 2019-XX-XX

### Added
* backslash in front of native functions
* PHP 7.3 support
* PHP 7.4 support
* `Linna\DotEnv\DotEnv->get()` return type `void` 

### Fixed
* the `=` char inside the `value` cause a wrong interpretation of the `key = value` pair
* `testParticularKeyValue` now use correct `@dataProvider`

### Removed
* PHP 7.1 support

## [v1.0.1](https://github.com/linna/dotenv/compare/v1.0.0...v1.0.1) - 2018-11-19

### Fixed
* Declare in `.env` using `key = value` instead of `key=value` not work

## [v1.0.0](https://github.com/linna/dotenv/compare/v1.0.0...master) - 2018-11-19

### Added
* `Linna\DotEnv\DotEnv` class
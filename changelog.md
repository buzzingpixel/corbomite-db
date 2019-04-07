# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.4.0] - 2019-04-06
### Changed
- Refactored code to remove deprecated calls to Corbomite DI service methods

## [1.3.1] - 2019-03-01
### Changed
- Updated configuration options for PDO

## [1.3.0] - 2019-02-28
### Added
- Added new environment variable options (see documentation)
- Added a DI entry for the Connection class
### Changed
- Added 100% code coverage PHPUnit tests

## [1.2.1] - 2019-01-22
### Fixed
- Fixed a namespace issue

## [1.2.0] - 2019-01-22
### Added
- Added Uuid trait and model

## [1.1.0] - 2019-01-21
### Added
- Added Query Model and Build Query Service

## [1.0.2] - 2019-01-10
### Fixed
- Fixed a bug where Orm::new did not return an instance of Orm

## [1.0.1] - 2019-01-05
### Fixed
- Fixed a bug where di config was calling 'PDO' instead of the PDO class

## [1.0.0] - 2019-01-05
### New
- Initial Release

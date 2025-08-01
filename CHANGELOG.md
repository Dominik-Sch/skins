# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [11.4.0] - 2025-06-30

### First release after rework
- better support for current v13
- add some missing styles
- save and close can be enabled in extension configuration
- new preview renderer for textmedia and textpic can be enabled in extension configuration

## [11.1.5] - 2024-09-12

### Bugfix and compatibility release
- better support for current v12
- add some missing styles
- first release for 13.2.1
  - save and close not working at the moment

## [11.1.1] - 2023-08-30

### Changed

- dropped jQuery
- dropped jQuery-Lib "ColorPicker"
- improved JavaScript performance
- added default styling to ext_tables.sql (fixed first load without colors)

### **NOTE: WORK IN PROGRESS**

## [11.0.0] - 2023-05-07

### Changed

first release for version 12

Breaking changes:
Changed to a more dynamic generation and save action.
The old values will not work in the new version, you have to set the desired colors again.

It's not final version yet.
I have to do some more compatibility checks and tests.

## [10.5.3] - 2022-10-19

### Fixed

- Fix access to possibly undefined array key (fixes #5)

## [10.5.2] - 2022-05-26

### Changed

- Update styles for the mask extension module
- Verify access to the user configuration to prevent possible errors
- Change the flush cache icon styling

## [10.5.1] - 2022-03-18

### Changed

- Update README.md

### Fixed

- Fix version number
- Fix css styles

## [10.5.0] - 2022-03-18

### Added

- Create .gitignore
- Add localization support
- Add new styles
- Add default values for top bar color fields
- Create CHANGELOG.md

### Changed

- Outsource fluid templates
- Update README.md

### Fixed

- Add missing typo3/cms-core version for typo3 11

## [10.4.28] - 2021-10-07

[Unreleased]: https://github.com/Dominik-Sch/skins/compare/v10.5.3...HEAD

[10.5.3]: https://github.com/Dominik-Sch/skins/compare/v10.5.2...10.5.3

[10.5.2]: https://github.com/Dominik-Sch/skins/compare/v10.5.1...10.5.2

[10.5.1]: https://github.com/Dominik-Sch/skins/compare/v10.5.0...10.5.1

[10.5.0]: https://github.com/Dominik-Sch/skins/compare/v10.4.28...10.5.0

[10.4.28]: https://github.com/Dominik-Sch/skins/releases/tag/v10.4.28

# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [6.5.0] - 2022-03-05
### Changed
* Added `post-author-custom` case for `role` option (thanks to @agenziae20).

## [6.4.1] - 2021-02-28
### Changed
* Updated links to documentation.

## [6.4.0] - 2021-02-27
### Added
* Added `post-author` and `post-author-only` cases for `role` option (props to @agenziae20 for the suggestion).
### Changed
* Underscore (`_`) in login names is changed into a dash (`-`) when building the CSS class.
* Updated compatibility to WordPress 5.7.

## [6.3.1] - 2020-11-21
### Added
### Changed
* Added new link to plugin line in the WordPress plugins management page.
* Updated compatibility to WordPress 5.6.

## [6.3] - 2020-03-01
### Added
* Added support for user IDs in recipient option.

## [6.2] - 2019-12-29
### Added
* Added support for custom HTML classes and HTML IDs.
* Added reverse option for custom roles.
* Added case `visitor` which is equivalent to `visitor-only`.
### Changed
* Convert user-entered custom roles into lowercase.
* Administrators can read hidden texts for Visitors.

## [6.1] - 2019-12-22
### Added
* Added use of multiple custom roles.
* Added a new filter when there is no text to be displayed.
* Added a new filter for hidden text.
* Added a new filter for alternate text.
### Changed
* Now Administrators can always read text for custom roles, unless a `role="custom-only"` option has been used.
* Code optimization.

## [6.0] - 2019-12-01
### Added
* Added use of custom roles.

## [5.1] - 2019-10-27
### Changed
* Changed the coding paradigm to OOP.

## [5.0] - 2018-12-08
### Added
* Added `reverse` option to change the logic of the `recipient` option.

## [4.4] - 2018-10-20
### Changed
* Checked code against PHPCS.

## [4.3] - 2018-05-19
### Added
* Added `ubn_private` as an extra shortcode, in case `private` is already in use.
### Security
* Improved security.

## [4.2] - 2016-12-12
### Security
* Improved security.
### Changed
* Changed text domain declaration.
### Added
* Added translation files.

## [4.1] - 2016-10-31
### Added
* NEW: added support for links in alternate text.

## [4.0] - 2016-02-21
### Added
* NEW: Added support for multiple recipents.

## [3.0] - 2015-09-02
### Added
* NEW: Added option for a single user.
### Fixed
* FIX: now, if the role is not correctly entered, the shortcode does not display anything.
### Changed
* Removed CSS class in the alternate text, in order to hide which type of users was the recipent of the text.

## [2.5] - 2015-08-08
### Added
* NEW: Added ability to use "span" as a container.
### Fixed
* FIX: Removed shortcode execution in feed.

## [2.4] - 2014-02-23
### Added
* NEW: now it's possible to use a `div` container instead of `p`, thanks to a pull request of Matt.

## [2.3] - 2013-12-28
### Fixed
* FIX: Added styling option for the alternate text.
### Added
* Added style to role-only alternate text.

## [2.2] - 2013-06-08
### Added
* NEW: now the plugin can show an alternate text if the reader hasn't the capability to read the text.

## [2.1] - 2013-06-06
### Added
* NEW: added the possibility to show a note only to Visitors (thanks to Jacki for the tip).

## [2.0] - 2013-02-16
### Added
* NEW: now you can show a note only to user of a specific role, hiding that note to higher roles.
* Added uninstall.php to delete the new custom capabilities.

## [1.2] - 2013-01-20
### Changed
* Now the inline style appears only if necessary.

## [1.1] - 2012-12-12
### Added
* Upon request, added the possibility to align the text left, right, centered and justified.

## [1.0] - 2012-11-24
### Added
* First release of the plugin.

[Unreleased]: https://github.com/aldolat/private-content/commits/develop
[6.5.0]: https://github.com/aldolat/private-content/compare/6.4.1...6.5.0
[6.4.1]: https://github.com/aldolat/private-content/compare/6.4.0...6.4.1
[6.4.0]: https://github.com/aldolat/private-content/compare/6.3.1...6.4.0
[6.3.1]: https://github.com/aldolat/private-content/compare/6.3...6.3.1
[6.3]: https://github.com/aldolat/private-content/compare/6.2...6.3
[6.2]: https://github.com/aldolat/private-content/compare/6.1...6.2
[6.1]: https://github.com/aldolat/private-content/compare/6.0...6.1
[6.0]: https://github.com/aldolat/private-content/compare/5.1...6.0
[5.1]: https://github.com/aldolat/private-content/compare/5.0...5.1
[5.0]: https://github.com/aldolat/private-content/compare/4.4...5.0
[4.4]: https://github.com/aldolat/private-content/compare/4.3...4.4
[4.3]: https://github.com/aldolat/private-content/compare/4.2...4.3
[4.2]: https://github.com/aldolat/private-content/compare/4.1...4.2
[4.1]: https://github.com/aldolat/private-content/compare/4.0...4.1
[4.0]: https://github.com/aldolat/private-content/compare/3.0...4.0
[3.0]: https://github.com/aldolat/private-content/compare/2.5...3.0
[2.5]: https://github.com/aldolat/private-content/compare/v2.4...2.5
[2.4]: https://github.com/aldolat/private-content/compare/v2.3...v2.4
[2.3]: https://github.com/aldolat/private-content/releases/tag/v2.3
[2.2]: https://plugins.trac.wordpress.org/browser/private-content/tags/2.2
[2.1]: https://plugins.trac.wordpress.org/browser/private-content/tags/2.1
[2.0]: https://plugins.trac.wordpress.org/browser/private-content/tags/2.0
[1.2]: https://plugins.trac.wordpress.org/browser/private-content/tags/1.2
[1.1]: https://plugins.trac.wordpress.org/browser/private-content/tags/1.1
[1.0]: https://plugins.trac.wordpress.org/browser/private-content/tags/1.0

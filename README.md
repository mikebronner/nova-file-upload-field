# File Upload Field for Laravel Nova

[![GitHub (pre-)release](https://img.shields.io/github/release/GeneaLabs/nova-file-upload-field/all.svg)](https://github.com/GeneaLabs/nova-file-upload-field)
[![Packagist](https://img.shields.io/packagist/dt/GeneaLabs/nova-file-upload-field.svg)](https://packagist.org/packages/genealabs/nova-file-upload-field)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/GeneaLabs/nova-file-upload-field/master/LICENSE)

![File Upload Field for Laravel Nova](https://repository-images.githubusercontent.com/192123976/6392e900-91f8-11e9-88b5-74365e97af5a)

## Supporting This Package
This is an MIT-licensed open source project with its ongoing development made possible by the support of the community. If you'd like to support this, and our other packages, please consider [becoming a backer or sponsor on Patreon](https://www.patreon.com/mikebronner).

## Impetus
I needed a file upload field for a few of my projects, with the versatile functionality that worked across all modern browsers in various use-cases. Safari has issues with drag-dropping URLs (it converts them to `webloc` files), different browsers have different little quircks in how they behave (Safari triggers change on input fields when they are updated programatically, Chrome does not in the case of changing files on a file input field).

## Functionality
The following features set this form field appart from others:
- drag-and-drop of URLs
- drag-and-drop of links that point to files
- drag-and-drop of web files (any web element with a src attribute that points to a file)
- drag-and-dop of system files
- image previews
- any uploadable items (files, URLs, links) are available in the request as an `UploadedFile` object in Laravel's Request object

## Commitment to Quality
During package development I try as best as possible to embrace good design and development practices, to help ensure that this package is as good as it can
be. My checklist for package development includes:

-   ✅ Achieve as close to 100% code coverage as possible using unit tests.
-   ✅ Eliminate any issues identified by SensioLabs Insight and Scrutinizer.
-   ✅ Be fully PSR1, PSR2, and PSR4 compliant.
-   ✅ Include comprehensive documentation in README.md.
-   ✅ Provide an up-to-date CHANGELOG.md which adheres to the format outlined
    at <http://keepachangelog.com>.
-   ✅ Have no PHPMD or PHPCS warnings throughout all code.

## Contributing
Please observe and respect all aspects of the included Code of Conduct <https://github.com/GeneaLabs/laravel-model-caching/blob/master/CODE_OF_CONDUCT.md>.

### Reporting Issues
When reporting issues, please fill out the included template as completely as
possible. Incomplete issues may be ignored or closed if there is not enough
information included to be actionable.

### Submitting Pull Requests
Please review the Contribution Guidelines <https://github.com/GeneaLabs/laravel-model-caching/blob/master/CONTRIBUTING.md>.
Only PRs that meet all criterium will be accepted.

## If you ❤️ open-source software, give the repos you use a ⭐️.
We have included the awesome `symfony/thanks` composer package as a dev dependency. Let your OS package maintainers know you appreciate them by starring the packages you use. Simply run composer thanks after installing this package. (And not to worry, since it's a dev-dependency it won't be installed in your
live environment.)

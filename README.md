# File Upload Field for Laravel Nova

[![GitHub (pre-)release](https://img.shields.io/github/release/GeneaLabs/nova-file-upload-field/all.svg)](https://github.com/GeneaLabs/nova-file-upload-field)
[![Packagist](https://img.shields.io/packagist/dt/GeneaLabs/nova-file-upload-field.svg)](https://packagist.org/packages/genealabs/nova-file-upload-field)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/GeneaLabs/nova-file-upload-field/master/LICENSE)

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

# File Upload Field for Laravel Nova

## Impetus
I needed a file upload field for a few of my projects, with the versatile functionality that worked across all modern browsers in various use-cases. Safari has issues with drag-dropping URLs (it converts them to `webloc` files), different browsers have different little quircks in how they behave (Safari triggers change on input fields when they are updated programatically, Chrome does not in the case of changing files on a file input field).

## Functionality
The following features set this form field appart from others:
- drag-and-drop URL attachment that works in Safari and Chrome
- image previews
- drag-and-drop file attachment (file upload fields do this already by default)
- anything dragged onto it is available in the request as an `UploadedFile`

## TODO
- [ ] Add index page field variant
- [ ] Add detail page field variant

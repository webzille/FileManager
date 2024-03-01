## This is a filemanager curated for laravel.

In the meantime it is using the `File` facade for all files operation, which means it doesn't use the `disk()`.
It is planned to be switched over to the `storage()` facade to enable integration with AWS as well as making the
filemanager more configurable.

Many other features are planned... this is a dev version.

To get the package so far, you need to add the `:dev-main` at the end of the require statement

> composer require webzille/filemanager:dev-main

Below are the instructions to implement the filemanager with SimpleMDE, but you can use the filemanager with any
editor of your choice. Only differences would be are how you add a custom button to the editor and how you append
the generated markdown/html to the editor.

In SimpleMDE, in your list of buttons, you would create a custom button which would open the filemanager and pass
the selected files (images) to a function that generates the markdown/

```javascript
{
    name: "internal-image",
    action: function openFileManager(editor) {
        fileManagerWindow('image').then(function(selectedFiles) {
            var markdownContent = generateMarkdown(selectedFiles);

            editor.codemirror.replaceSelection(markdownContent);
        });
    },
    className: "fa fa-file",
    title: "File Manager",
},
```

The `fileManagerWindow(arg)` is the function that opens the filemanager in a new window and sets the environment
to `image` (or whatever else is passed to it).

```javascript
function fileManagerWindow(type) {
    var fileManagerRoute = '{{ route('filemanager', ':type') }}';
    var fileManagerWindow = window.open(
        fileManagerRoute.replace(':type', type),
        'FileManager',
        'resizable=true,scrollbars=true,fullscreen=true'
    );

    return new Promise(function(resolve, reject) {
        window.addEventListener('beforeunload', function() {
            var selectedFiles = fileManagerWindow.selectedFiles;
            resolve(selectedFiles);
        });

        window.addEventListener('message', function(event) {
            if (event.source === fileManagerWindow) {
                var selectedFiles = event.data;
                resolve(selectedFiles);
            }
        });
    });
}
```

And the function to generate the markdown that the custom button invokes is:

```javascript
function generateMarkdown(selectedFiles) {
    var markdownContent = selectedFiles.map(function(file) {
        return '![' + file + '](' + file + ')';
    }).join('\n');

    return markdownContent;
}
```

It is possible to use this filemanager outside of an editor by adding an event listener to a button/input field
or whatever else you may desire and handling the returned file. Here is an example to set an image preview in an
element by setting an event listener to an input text field with an id of 'post-image'.

```javascript
const postImage = document.getElementById('post-image');

// Attach event listener for click and focus events
postImage.addEventListener('click', handleImageSelection);
postImage.addEventListener('focus', handleImageSelection);

function handleImageSelection() {
    fileManagerWindow('image').then(function(selectedFiles) {
        // We only use one image for the post. Using the first regardless of how many images returned.
        setImagePreview(selectedFiles[0]);
    });

    postImage.blur();
}

function setImagePreview(image) {
    postImage.value = image;

    // The DIV the image will be set as a background image to.
    const postImagePreview = document.getElementById('post-image-preview');

    postImagePreview.style.visibility = 'visible';
    postImagePreview.classList.add('pointer'); // A class that adds a cursor: pointer; effect on hover
    postImagePreview.style.backgroundImage = 'url(' + image + ')';

    const postImagePreviewClose = document.getElementById('post-image-preview-close');

    postImagePreviewClose.style.visibility = 'visible';
}
```

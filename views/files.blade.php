<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Raleway&family=Lato&family=Open+Sans:wght@300&family=Roboto:wght@100&display=swap">
    <link rel="stylesheet" href="{{ asset('vendor/webzille-filemanager/style/filemanager.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/webzille-filemanager/style/helpers.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/webzille-filemanager/style/all.min.css') }}">
    <title>File Manager</title>
</head>

<body>
    <form id="uploadFilesModal" class="modal" role="modal">
        <div class="modal-container">
            <a class="close" modal="uploadFilesModal">&times;</a>
            <h2>Upload File</h2>
            <div class="modal-content">
                <div class="input-container">
                    <label for="files">Files</label>
                    <input id="files" type="file" name="files">
                </div>
            </div>
            <div class="btn-con">
                <a href="#" class="btn-link" modal="uploadFilesModal">Close</a>
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </form>

    <form id="newDirectoryModal" class="modal" role="modal">
        <div class="modal-container">
            <a class="close" modal="newDirectoryModal">&times;</a>
            <h2>New Directory's Name</h2>
            <div class="modal-content">
                <div class="input-container">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" autofocus>
                </div>
            </div>
            <div class="btn-con">
                <a href="#" class="btn-link" modal="newDirectoryModal">Close</a>
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
    </form>

    <form id="renameDirectoryModal" class="modal" role="modal">
        <div class="modal-container">
            <a class="close" modal="renameDirectoryModal">&times;</a>
            <h2>Rename Directory</h2>
            <div class="modal-content">
                <div class="input-container">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" class="currentDirectoryName" autofocus>
                </div>
            </div>
            <div class="btn-con">
                <a href="#" class="btn-link" modal="renameDirectoryModal">Close</a>
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-primary">Rename</button>
            </div>
        </div>
    </form>

    <div id="deleteDirectoryModal" class="modal" role="modal">
        <div class="modal-container">
            <a class="close" modal="deleteDirectoryModal">&times;</a>
            <h2>Delete Directory</h2>
            <div class="modal-content">
                <p>Are you sure you want to delete the current directory?</p>
            </div>
            <div class="btn-con">
                <a href="#" class="btn-link" modal="deleteDirectoryModal">Cancel</a>
                <a href="#" class="btn-link" data-action="deleteDirectory">Delete</a>
            </div>
        </div>
    </div>

    <div id="moveDirectoryModal" class="modal" role="modal">
        <div class="modal-container">
            <a class="close" modal="moveDirectoryModal">&times;</a>
            <h2>Move Directory</h2>
            <div class="modal-content">
                <p>Are you sure you want to delete the current directory?</p>
            </div>
            <div class="btn-con">
                <a href="#" class="btn-link" modal="moveDirectoryModal">Cancel</a>
            </div>
        </div>
    </div>

    <div id="previewFileModal" class="modal" role="modal">
        <div class="modal-container">
            <a class="close" modal="previewFileModal">&times;</a>
            <h2>Preview <span id="previewFileName"></span></h2>
            <div class="modal-content" id="filePreview">

            </div>
            <div class="btn-con">
                <a href="#" class="btn-link" id="fileLink" target="_blank">Open File</a>
                <a href="#" class="btn-link" modal="previewFileModal">Close</a>
            </div>
        </div>
    </div>

    <div id="deleteFileModal" class="modal" role="modal">
        <div class="modal-container">
            <a class="close" modal="deleteFileModal">&times;</a>
            <h2>Delete {{ ucfirst($type) }}</h2>
            <div class="modal-content">
                <p>Are you sure you want to delete the selected {{ $type }}(s)?</p>
            </div>
            <div class="btn-con">
                <a href="#" class="btn-link" modal="deleteFileModal">Cancel</a>
                <a href="#" class="btn-link" data-action="deleteFiles">Delete</a>
            </div>
        </div>
    </div>

    <form id="renameFileModal" class="modal" role="modal">
        <div class="modal-container">
            <a class="close" modal="renameFileModal">&times;</a>
            <h2>Rename {{ ucfirst($type) }}</h2>
            <div class="modal-content">
                <div class="input-container">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" autofocus>
                </div>
            </div>
            <div class="btn-con">
                <a href="#" class="btn-link" modal="renameFileModal">Close</a>
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-primary">Rename</button>
            </div>
        </div>
    </form>

    <div id="moveSelectionModal" class="modal" role="modal">
        <div class="modal-container">
            <a class="close" modal="moveSelectionModal">&times;</a>
            <h2>Choose Destination Folder</h2>
            <div class="modal-content">
                <div id="folderTree">
                    <ul class="directory-listing" id="moveItems">
                    </ul>
                </div>
            </div>
            <div class="btn-con">
                <a href="#" class="btn-link" modal="moveSelectionModal">Close</a>
            </div>
        </div>
    </div>

    <header>
        <div>
            <h2>File Manager - {{ ucfirst($type) }}s</h2>
        </div>
        <div class="nav">
            <span id="fileOperations" style="visibility: hidden;">
                <a href="#" data-action="preview">Preview</a>
                <a href="#" modal="moveSelectionModal" data-action="moveItems">Move</a>
                <a href="#" modal="renameFileModal">Rename</a>
                <a href="#" modal="deleteFileModal">Delete</a>
            </span>
            <a href="#" id="selectAllLink" data-action="selectAll">Select All</a>
        </div>
    </header>

    <main>
        <aside id="directory-functions">
            <ul class="directory-functions">
                <li><a href="#" modal="newDirectoryModal">New</a></li>
                <li><a href="#" modal="moveSelectionModal" data-action="moveItems">Move</a></li>
                <li><a href="#" modal="renameDirectoryModal">Rename</a></li>
                <li><a href="#" modal="deleteDirectoryModal">Delete</a></li>
            </ul>
        </aside>
        <div id="directoryListing">
            <aside id="directories">
                <ul class="directory-listing" id="mainTreeView">
                    <li><a href="#" data-url="{{ $root }}"><i class="fa-regular fa-folder"></i>
                            {{ ucfirst($type) }}</a>
                        <ul id="mainTreeViewChildren">
                            @foreach ($folders as $folder)
                                @include('webzille-filemanager::partials.folder', ['folder' => $folder])
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </aside>
            <div class="breadcrumbs">
                <div id="breadcrumbContainer"> <i class="fa-solid fa-chevron-right"></i> <a href="#" data-url="{{ $root }}">{{ $type }}</a>
                </div>
            </div>
        </div>
        <section id="fileView">
            @if (count($files) > 0)
                @foreach ($files as $file)
                    <div class="file" style="background-image: url({{ $file['url'] }})"
                        data-file="{{ $file['url'] }}">
                        <span>{{ $file['name'] }}</span>
                    </div>
                @endforeach
            @else
                <p class="noFiles">No {{ $type }}s found.</p>
            @endif
        </section>
    </main>

    <footer>
        <div class="nav" id="bottomNav">
            <a href="#" data-action="download">Download</a>
            <a href="#" modal="uploadFilesModal">Upload</a>
            <a href="#" data-action="submit">Submit</a>
        </div>
    </footer>
    <script>
        let selectedFiles = [];
        let currentFolder = '{{ $root }}';
        const root = '{{ $root }}';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const dropZone = document.getElementById('fileView');
        const moveItems = document.getElementById('moveItems');

        const filemanagerUploadLink = '{{ route('filemanager.upload') }}';

        document.addEventListener('DOMContentLoaded', function() {
            let directoryListing = document.getElementById('directoryListing');

            directoryListing.addEventListener('click', function(event) {
                let target = event.target;
                if (target.tagName === 'A') {
                    event.preventDefault();
                    var url = target.dataset.url;
                    fetchFolderContent(url);
                }
            });

            document.querySelectorAll('[modal]').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    var modalId = link.getAttribute('modal');

                    toggleModal(modalId);
                });
            });

            dropZone.addEventListener('click', function(event) {
                let target = event.target;
                if (target.classList.contains('file')) {
                    toggleImageSelection(target);
                }
            });

            moveItems.addEventListener('click', function (event) {
                var target = event.target;
                if (target.tagName === 'A') {
                    event.preventDefault();
                    var url = target.dataset.url;
                    moveSelection(url);
                }
            });

            window.addEventListener('click', (event) => {
                var target = event.target;
                if (target.tagName === 'A') {
                    var action = target.dataset.action;
                    if (action) {
                        switch (action) {
                            case 'deleteDirectory':
                                deleteDirectory();
                                break;
                            case 'deleteFiles':
                                deleteSelectedFiles();
                                break;
                            case 'preview':
                                previewFile();
                                break;
                            case 'selectAll':
                                toggleSelectAll();
                                break;
                            case 'moveItems':
                                copyMainTreeViewToMoveItems();
                                break;
                            case 'download':
                                downloadSelectedFiles();
                                break;
                            case 'submit':
                                submitFilesAndClose();
                                break;
                        }
                    }
                }
            });

            document.addEventListener('submit', function(event) {
                event.preventDefault();
                
                var form = event.target;
                var formId = form.getAttribute('id');
                
                switch (formId) {
                    case 'uploadFilesModal':
                        uploadFiles(form['files'].files);
                        break;
                    case 'newDirectoryModal':
                        newDirectory(form['name'].value);
                        break;
                    case 'renameDirectoryModal':
                        renameDirectory(form['name'].value);
                        break;
                    case 'renameFileModal':
                        renameSelectedFile(form['name'].value);
                        break;
                }
            });

            dropZone.addEventListener('drop', handleDrop, false);

            dropZone.addEventListener('dragover', highlight, false);

            dropZone.addEventListener('dragleave', unhighlight, false);
        });

        function highlight(e) {
            e.preventDefault();
            e.stopPropagation();
            dropZone.style.backgroundColor = 'rgba(200, 200, 200, 0.1)';
        }

        function unhighlight(e) {
            e.preventDefault();
            e.stopPropagation();
            dropZone.style.backgroundColor = 'rgba(0, 0, 0, 0)';
        }

        function handleDrop(e) {
            e.preventDefault();
            e.stopPropagation();
            const files = e.dataTransfer.files || [];

            uploadFiles(files);
            unhighlight();
        }

        function copyMainTreeViewToMoveItems() {
            const mainTreeView = document.getElementById('mainTreeView');
            moveItems.innerHTML = mainTreeView.innerHTML;
        }

        function clearMoveItems() {
            moveItems.innerHTML = '';
        }

        function uploadFiles(files) {
            closeModal('uploadFilesModal');
            const formData = new FormData();

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                formData.append('files[]', file);
            }

            formData.append('directory', currentFolder);

            fetch(filemanagerUploadLink, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok.');
                })
                .then(data => {
                    console.log(data.message);

                    fetchFolderContent(currentFolder);
                    clearSelectedFiles();
                })
                .catch(error => {
                    console.error('Error during upload:', error);
                });
        }

        function getElementsByAttributeData(attribute, data) {
            return document.querySelector('[' + attribute + '="' + data + '"]');
        }

        function setCurrentDirectory(directory) {
            currentFolder = directory;

            currentFolderElements = document.getElementsByClassName('currentDirectoryName');

            Array.from(currentFolderElements).forEach(element => {
                element.value = directory.split('/').pop();
            });
        }

        function fetchFolderContent(folderId) {
            fetch('{{ route('filemanager.listFiles') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        _token: csrfToken,
                        folder: folderId
                    })
                })
                .then(response => response.json())
                .then(response => {
                    var folderContent = '';
                    setCurrentDirectory(folderId);
                    clearSelectedFiles();

                    if (response.length > 0) {
                        response.forEach(file => {
                            folderContent += `<div class="file" style="background-image: url('${file.url}')" data-file="${file.url}">
                                            <span>${file.name}</span>
                                        </div>`;
                        });
                    } else {
                        folderContent += `<p class="noFiles">No {{ $type }}s found.</p>`;
                    }

                    dropZone.innerHTML = folderContent;
                    updateBreadcrumb();
                })
                .catch(error => {
                    console.error('Error fetching folder content: ', error);
                    clearSelectedFiles();
                });
        }

        function updateBreadcrumb() {
            let folders = currentFolder.split('/').slice(2);
            let currentRoot = currentFolder.split('/').slice(0, 2).join('/');

            let breadcrumbHtml = '';

            for (let i = 0; i < folders.length; i++) {
                currentRoot += (currentRoot === '' ? '' : '/') + folders[i];
                breadcrumbHtml += ' <i class="fa-solid fa-chevron-right"></i> <a href="#" data-url="' + currentRoot + '">' + folders[i] + '</a>';
            }

            document.getElementById('breadcrumbContainer').innerHTML = breadcrumbHtml;

            contentUpdated = false;
        }

        function toggleSelectAll() {
            let selectAllLink = document.getElementById('selectAllLink');
            let imageDivs = document.querySelectorAll('.file');

            let allSelected = !selectAllLink.classList.contains('selected');

            imageDivs.forEach(function(div) {
                div.classList.toggle('selected', allSelected);

                var fileValue = div.getAttribute('data-file');
                if (allSelected) {
                    if (!selectedFiles.includes(fileValue)) {
                        selectedFiles.push(fileValue);
                    }
                    toggleFileOperations(true);
                } else {
                    selectedFiles = selectedFiles.filter(function(file) {
                        return file !== fileValue;
                    });
                    toggleFileOperations(false);
                }
            });

            selectAllLink.textContent = allSelected ? 'Deselect All' : 'Select All';
            selectAllLink.classList.toggle('selected', allSelected);
        }

        function toggleImageSelection(imageDiv) {
            imageDiv.classList.toggle('selected');

            let fileValue = imageDiv.getAttribute('data-file');

            if (imageDiv.classList.contains('selected')) {
                if (!selectedFiles.includes(fileValue)) {
                    selectedFiles.push(fileValue);
                }
            } else {
                selectedFiles = selectedFiles.filter(function(file) {
                    return file !== fileValue;
                });
            }

            let anyFileSelected = Array.from(document.querySelectorAll('.file')).some(function(file) {
                return file.classList.contains('selected');
            });

            toggleFileOperations(anyFileSelected);

            document.getElementById('selectAllLink').textContent = !anyFileSelected ? 'Select All' : 'Deselect All';
            document.getElementById('selectAllLink').classList.toggle('selected', anyFileSelected);
        }

        function clearSelectedFiles() {
            var allFileElements = document.querySelectorAll('.file');
            allFileElements.forEach(function(fileElement) {
                fileElement.classList.remove('selected');
            });

            selectedFiles = [];

            toggleFileOperations(false);

            document.getElementById('selectAllLink').textContent = 'Select All';
            document.getElementById('selectAllLink').classList.remove('selected');
        }

        function toggleFileOperations(toggle) {
            if (toggle) {
                document.getElementById('fileOperations').style.visibility = 'visible';
            } else {
                document.getElementById('fileOperations').style.visibility = 'hidden';
            }
        }

        function toggleModal(modalId) {
            var modal = document.getElementById(modalId);
            if (modal) {
                if (modal.style.display === 'block') {
                    closeModal(modalId);
                } else {
                    openModal(modalId);
                }
            }
        }

        function closeAllModals() {
            var modals = document.querySelectorAll('[role="modal"]');
            modals.forEach(function(modal) {
                closeModal(modal.id);
            });
        }

        function openModal(modalId) {
            closeAllModals();

            document.getElementById(modalId).style.display = 'block';

            var inputContainers = document.querySelectorAll('.input-container');

            inputContainers.forEach(container => {
                var label = container.querySelector('label');
                var input = container.querySelector('input');

                input.style.paddingLeft = label.offsetWidth + 20 + 'px';
            });
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function previewFile() {
            openModal('previewFileModal');

            if (selectedFiles.length === 1) {
                var selectedFile = selectedFiles[0];

                var urlObject = new URL(selectedFile);

                var pathname = urlObject.pathname;
                console.log('Path Name: '+ pathname);

                var filename = pathname.split('/').pop();

                console.log('File Name: '+ filename);

                console.log(document.getElementById('fileLink'));

                document.getElementById('fileLink').href = selectedFile;

                console.log(document.getElementById('fileLink'));
                document.getElementById('previewFileName').innerHTML = filename;
                document.getElementById('filePreview').style.backgroundImage = "url('" + selectedFile + "')";
            } else {
                console.warn('Need to select one file before previewing.');
            }
        }

        function moveSelection(moveTo) {
            closeModal('moveSelectionModal');

            if(selectedFiles.length !== 0) {
                moveSelectedFiles(moveTo);
            } else {
                moveDirectory(moveTo)
            }

            clearMoveItems();
        }

        function moveSelectedFiles(moveTo) {
            if (selectedFiles.length !== 0) {
                fetch(`{{ route('filemanager.move') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            selectedFiles: selectedFiles,
                            destination: moveTo
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.message);

                        fetchFolderContent(currentFolder);

                        clearSelectedFiles();
                    })
                    .catch(error => {
                        console.error('Error: '+ error);
                        clearSelectedFiles();
                    });
            } else {
                console.warn('Need to select at least one file before moving.');
            }
        }

        function deleteSelectedFiles() {
            closeModal('deleteFileModal');

            if (selectedFiles.length !== 0) {
                fetch('{{ route('filemanager.delete') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            _token: csrfToken,
                            selectedFiles: selectedFiles,
                        })
                    })
                    .then(response => response.json())
                    .then(response => {
                        console.log(response.message);

                        fetchFolderContent(currentFolder);
                        clearSelectedFiles();
                    })
                    .catch(error => {
                        console.error(error);
                        clearSelectedFiles();
                    });
            } else {
                console.warn('Need to select at least one file before deleting.');
            }
        }

        function renameSelectedFile(newFileName) {
            closeModal('renameFileModal');

            if (selectedFiles.length === 1) {
                fetch('{{ route('filemanager.rename') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            _token: csrfToken,
                            selectedFile: selectedFiles[0],
                            newFileName: newFileName
                        })
                    })
                    .then(response => response.json())
                    .then(response => {
                        console.log(response.message);

                        fetchFolderContent(response.directory);
                        clearSelectedFiles();
                    })
                    .catch(error => {
                        console.error(error);
                        clearSelectedFiles();
                    });
            } else {
                console.warn('Need to select exactly one file to rename.');
            }
        }

        function downloadSelectedFiles() {
            fetch('{{ route('filemanager.download') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        _token: csrfToken,
                        selectedFiles: selectedFiles,
                    })
                })
                .then(response => response.blob())
                .then(blob => {
                    var timestampHash = Math.floor(Date.now() / 1000).toString(36);
                    var blobUrl = URL.createObjectURL(blob);

                    var link = document.createElement('a');
                    link.href = blobUrl;
                    link.download = timestampHash + '.zip';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    clearSelectedFiles();
                })
                .catch(error => {
                    console.error(error);
                    clearSelectedFiles();
                });
        }

        function submitFilesAndClose() {
            window.opener.postMessage(selectedFiles, '*');

            window.close();
        }

        function newDirectory(directoryName) {
            closeModal('newDirectoryModal');

            fetch('{{ route('filemanager.folder.new') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        _token: csrfToken,
                        currentFolder: currentFolder,
                        directoryName: directoryName,
                    })
                })
                .then(response => response.json())
                .then(response => {
                    console.log(response.message);

                    updateDirectoryTree()

                    fetchFolderContent(currentFolder + '/' + directoryName);
                    clearSelectedFiles();
                })
                .catch(error => {
                    console.error(error);
                    clearSelectedFiles();
                });
        }

        function renameDirectory(directoryName) {
            closeModal('renameDirectoryModal');

            if(currentFolder !== root)
            {
                fetch('{{ route('filemanager.folder.rename') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            _token: csrfToken,
                            currentFolder: currentFolder,
                            directoryName: directoryName,
                        })
                    })
                    .then(response => response.json())
                    .then(response => {
                        console.log(response.message);

                        let directory = document.querySelector('[data-url="' + currentFolder + '"]');

                        let newPath = response.newPath;
                        let directoryName = newPath.split('/').filter(Boolean).pop();

                        directoryName = directoryName.charAt(0).toUpperCase() + directoryName.slice(1);
                        directory.dataset.url = newPath;
                        directory.innerHTML = directory.childNodes[0].outerHTML + ' ' + directoryName;

                        fetchFolderContent(newPath);
                        clearSelectedFiles();
                    })
                    .catch(error => {
                        console.error(error);
                        clearSelectedFiles();
                    });
            } else {
                console.error('You shouldn\'t rename the root directory.');
            }
        }

        function deleteDirectory() {
            closeModal('deleteDirectoryModal');

            fetch('{{ route('filemanager.folder.delete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        _token: csrfToken,
                        currentFolder: currentFolder
                    })
                })
                .then(response => response.json())
                .then(response => {
                    console.log(response.message);

                    updateDirectoryTree()

                    fetchFolderContent(response.parentDirectory);
                    clearSelectedFiles();
                })
                .catch(error => {
                    console.error(error);
                    clearSelectedFiles();
                });
        }

        function moveDirectory(moveTo) {

            if(currentFolder !== root)
            {
                fetch('{{ route('filemanager.folder.move') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            _token: csrfToken,
                            currentFolder: currentFolder,
                            destination: moveTo
                        })
                    })
                    .then(response => response.json())
                    .then(response => {
                        console.log(response.message);

                        updateDirectoryTree()

                        fetchFolderContent(response.destination);
                        clearSelectedFiles();
                    })
                    .catch(error => {
                        console.error(error);
                        clearSelectedFiles();
                    });
            } else {
                console.error('You shouldn\'t move the root directory.');
            }
        }

        function updateDirectoryTree() {
            fetch('{{ route('filemanager.folder.list') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        _token: csrfToken,
                        directory: root,
                    })
                })
                .then(response => response.json())
                .then(response => {
                    const mainTreeViewChildren = document.getElementById('mainTreeViewChildren');
                    directories = response.directories;

                    mainTreeViewChildren.innerHTML = '';
                    directories.forEach(directory => {
                        addDirectoryToTree(mainTreeViewChildren, directory);
                    });

                    clearSelectedFiles();
                })
                .catch(error => {
                    console.error(error);
                    clearSelectedFiles();
                });
        }

        function addDirectoryToTree(parentElement, directory) {
            var newDirectoryItem = document.createElement('li');
            var newDirectoryUrl = directory.url;
            var newDirectoryName = directory.name;

            addLinkItem(newDirectoryItem, newDirectoryUrl, newDirectoryName);

            parentElement.appendChild(newDirectoryItem);

            if (directory.subDirectories && directory.subDirectories.length > 0) {
                directory.subDirectories.forEach(subDirectory => {
                    addDirectoryToTree(newDirectoryItem, subDirectory);
                });
            }
        }

        function addLinkItem(parentElement, newDirectoryUrl, newDirectoryName) {
            var newDirectoryLink = document.createElement('a');
            newDirectoryLink.setAttribute('href', '#');
            newDirectoryLink.setAttribute('data-url', newDirectoryUrl);

            var newIconElement = document.createElement('i');
            newIconElement.className = 'fa-regular fa-folder';
            newDirectoryLink.appendChild(newIconElement);

            var capitalizedDirectoryName = newDirectoryName.charAt(0).toUpperCase() + newDirectoryName.slice(1);
            newDirectoryLink.appendChild(document.createTextNode(' ' + capitalizedDirectoryName));

            parentElement.appendChild(newDirectoryLink);
        }
    </script>
</body>

</html>

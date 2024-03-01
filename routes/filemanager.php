<?php

use Illuminate\Support\Facades\Route;
use Webzille\FileManager\FileManager;
use Webzille\FileManager\Operations\FileManagerFileOperations;
use Webzille\FileManager\Operations\FileManagerFolderOperations;

Route::group(['middleware' => ['auth', 'web'], 'prefix'=> 'filemanager'], function() {
    Route::get('/files/{type}', [FileManager::class, 'index'])->name('filemanager');

    Route::post('/files/move', [FileManagerFileOperations::class, 'moveFile'])->name('filemanager.move');
    Route::post('/files/rename', [FileManagerFileOperations::class, 'renameFile'])->name('filemanager.rename');
    Route::post('/files/delete', [FileManagerFileOperations::class, 'deleteFile'])->name('filemanager.delete');
    Route::post('/files/retrieve', [FileManagerFileOperations::class, 'listFiles'])->name('filemanager.listFiles');
    Route::post('/files/download', [FileManagerFileOperations::class, 'downloadFile'])->name('filemanager.download');

    
    Route::post('/files/upload', [FileManagerFileOperations::class, 'uploadFiles'])->name('filemanager.upload');
    
    Route::post('/folder/new', [FileManagerFolderOperations::class, 'newFolder'])->name('filemanager.folder.new');
    Route::post('/folder/list', [FileManagerFolderOperations::class, 'listDirectories'])->name('filemanager.folder.list');
    Route::post('/folder/move', [FileManagerFolderOperations::class, 'moveFolder'])->name('filemanager.folder.move');
    Route::post('/folder/rename', [FileManagerFolderOperations::class, 'renameFolder'])->name('filemanager.folder.rename');
    Route::post('/folder/delete', [FileManagerFolderOperations::class, 'deleteFolder'])->name('filemanager.folder.delete');
});
<?php

namespace Webzille\FileManager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/webzille-filemanager'),
        ], 'filemanager_public');

        $this->publishes([
            __DIR__.'/../views'  => base_path('resources/views/vendor/webzille-filemanager'),
        ], 'filemanager_view');
        
        $this->loadViewsFrom(__DIR__.'/../views', 'webzille-filemanager');
        
        $this->loadRoutesFrom(__DIR__.'/../routes/filemanager.php');
    }
}

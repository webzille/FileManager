<?php

namespace Webzille\FileManager;

use Webzille\FileManager\Operations\FileManagerFileOperations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileManager
{

    public FileManagerEnvironment $environment;

    public function index($type)
    {
        $this->environment = (new FileManagerEnvironment)->setEnvironment($type);

        $request = Request::create('/files/retrieve', 'POST', ['folder' => $this->environment->public]);

        return view('webzille-filemanager::files', [
            'type'      => $this->environment->environment,
            'root'      => [
                'public'    => $this->environment->public,
                'storage'   => $this->environment->storage
            ],
            'folders'   => $this->listDirectories($this->environment->public),
            'files'     => json_decode((new FileManagerFileOperations)->listFiles($request)->getContent(), true) ?? [],
        ]);
    }

    public static function listDirectories($path)
    {
        $directories = File::directories($path);

        $items = [];

        foreach ($directories as $dir) {
            $dir = str_replace('\\', '/', $dir);

            $items[] = [
                'name'              => basename($dir),
                'url'               => $dir,
                'subDirectories'    => self::listDirectories($dir)
            ];
        }

        return $items;
    }
}

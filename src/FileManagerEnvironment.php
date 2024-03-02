<?php

namespace Webzille\FileManager;

use Illuminate\Support\Facades\File;

class FileManagerEnvironment
{

    public string $environment;
    public string $storage;
    public string $public;
    public string $shared;

    public function setEnvironment($environment): self
    {
        $this->environment = $environment;
        $this->storage = str_replace('\\', '/', storage_path('app/public/'));
        $this->public = 'storage/' . Auth()->User()->id .'/' . $environment;
        $this->shared = 'storage/shared/' . $environment;

        $this->checkDirectories();

        return $this;
    }

    protected function checkDirectories(): void
    {
        if (!File::exists($this->storage)) {
            File::makeDirectory($this->storage, 0777, true, true);
        }
    }
}

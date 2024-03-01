<?php

namespace Webzille\FileManager\Traits;

trait Path {

    protected function preparePath($url)
    {
        $parts = explode('/', trim(parse_url($url, PHP_URL_PATH), '/'));
        
        array_shift($parts);
        
        $filePath = implode('/', $parts);

        return str_replace('\\', '/', public_path("storage/{$filePath}"));
    }
}
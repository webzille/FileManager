<?php

namespace Webzille\FileManager\Traits;

trait Path {

    protected function preparePath($url)
    {
        $parts = explode('/', trim(parse_url($url, PHP_URL_PATH), '/'));
        
        $filePath = implode('/', array_slice($parts, 3));

        return str_replace('\\', '/', public_path("storage/{$filePath}"));
    }
}

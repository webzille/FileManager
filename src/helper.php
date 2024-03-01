<?php

if (!function_exists('packageAsset')) {
    function packageAsset($path)
    {
        $assetPath = public_path('webzille/filemanager/' . $path);

        if (file_exists($assetPath)) {
            return asset('webzille/filemanager/' . $path);
        } else {
            return asset('../vendor/webzille/filemanager/public' . $path);
        }
    }
}

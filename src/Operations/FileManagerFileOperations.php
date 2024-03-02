<?php

namespace Webzille\FileManager\Operations;

use Webzille\FileManager\Traits\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class FileManagerFileOperations {

    public function moveFile(Request $request)
    {
        try {
            $filesToMove = $request->input('selectedFiles');
            $moveTo = $request->input('destination');
            Log::info('Move To: '. $moveTo);

            if(!File::isDirectory(($moveTo))) {
                return response()->json(['error' => 'Unknown directory location: ' . $moveTo], 404);
            }

            foreach ($filesToMove as $file) {
                $currentFile = $file;
                Log::info('Current File: '. $currentFile);
                $destination = $moveTo . '/' . basename($file);
                Log::info('Destination: '. $destination);

                File::move($currentFile, $destination);
            }
            return response()->json(['message' => 'Files moved successfully']);
        } catch (\Exception $e) {
            Log::error('Exception in FileManagerFileOperations@moveFile: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function deleteFile(Request $request)
    {
        try {
            $files = $request->input('selectedFiles');
            
            foreach($files as $file)
            {
                $filePath = $file;
                File::delete($filePath);
            }
            $parsedUrl = parse_url($file);

            return response()->json([
                'directory' => substr(dirname($parsedUrl['path']), 1),
                'message' => 'Files deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Exception in FileManagerFileOperations@deleteFile: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function renameFile(Request $request)
    {
        $file = $request->input('selectedFile');
        $currentDirectory = $request->input('currentDirectory');
    
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $newFileName = $request->input('newFileName') . ".{$extension}";
        $newFilePath = str_replace('\\', '/', dirname($file) . '/' . $newFileName);

        try {
            if (File::move($file, $newFilePath)) {
                return response()->json([
                    'directory' => $currentDirectory,
                    'message'   => "{$file} was renamed to {$newFileName}."
                ]);
            }
    
            return response()->json([
                'directory' => $currentDirectory,
                'message' => "{$file} failed to be renamed to {$newFileName}."
            ]);
        } catch (\Exception $e) {
            Log::error('Exception in FileManagerFileOperations@renameFile: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function listFiles(Request $request)
    {
        try {
            $folder = $request->input('folder');
    
            if (!File::isDirectory($folder)) {
                return response()->json(['error' => $folder], 404);
            }

            if ($files = File::files($folder)) {
                $folderContent = [];
                foreach ($files as $file) {
                    $folderContent[] = [
                        'name'  => $file->getFilename(),
                        'path'  => str_replace('\\', '/', $file->getPathname()),
                        'url'   => asset(str_replace('\\', '/', $file->getPathname())),
                    ];
                }

                return response()->json($folderContent);
            }
            
            return response()->json([]);
        } catch (\Exception $e) {
            Log::error('Exception in FileManagerFileOperations@listFiles: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function downloadFile(Request $request)
    {
        try {
            $selectedFiles = $request->input('selectedFiles');
        
            if (count($selectedFiles) === 1) {
                $downloadFilePath = $selectedFiles[0];
                return response()->download($downloadFilePath);
            } elseif (count($selectedFiles) > 1) {
                $zipFileName = 'downloaded_files.zip';
                $zipFilePath = storage_path("app/{$zipFileName}");
        
                $zip = new ZipArchive();
                
                if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
                    foreach ($selectedFiles as $file) {
                        $file = $file;
                        $zip->addFile($file, basename($file));
                    }
        
                    $zip->close();
        
                    return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
                } else {
                    return response()->json(['error' => 'Failed to create the zip archive.'], 500);
                }
            } else {
                return response()->json(['error' => 'No files selected.'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Exception in FileManagerFileOperations@downloadFile: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function uploadFiles(Request $request)
    {
        try {
            $files = $request->file('files');
            $directory = $request->input('directory');
            
            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName();
                
                if(!$file->move($directory, $fileName))
                {
                    Log::error('Failed uploading ' . $fileName . ' into ' . $directory);
                }
            }

            return response()->json(['message' => 'Files uploaded successfully']);

        } catch (\Exception $e) {
            Log::error('Exception in FileManagerFileOperations@uploadFiles: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}

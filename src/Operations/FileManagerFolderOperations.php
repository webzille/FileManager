<?php

namespace Webzille\FileManager\Operations;

use Webzille\FileManager\FileManager;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class FileManagerFolderOperations {

    public function newFolder(Request $request)
    {
        try {
            $parentDirectory = $request->input('currentFolder');
            $newDirectoryName = $request->input('directoryName');

            if (!File::exists($parentDirectory)) {
                return Response::json(['error' => 'Parent directory does not exist'], 404);
            }

            $newDirectoryPath = $parentDirectory . '/' . $newDirectoryName;
            File::makeDirectory($newDirectoryPath);
            
            return Response::json(['message' => 'Folder created successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Exception in FileManagerFolderOperations@newFolder: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function moveFolder(Request $request)
    {
        try {
            $currentDirectory = $request->input('currentFolder');
            $destination = $request->input('destination');
            $publicDestination = $request->input('publicDestination');

            $directoryName = basename($currentDirectory);
            $destinationPath = $destination . "/$directoryName";

            if (File::exists($currentDirectory)) {
                File::move($currentDirectory, $destinationPath);

                return response()->json([
                    'message'       => 'Directory moved successfully',
                    'destination'   => $publicDestination . "/$directoryName",
                    'directoryName' => $directoryName
                ], 200);
            } else {
                return response()->json(['error' => 'Current directory not found'], 404);
            }
            
        } catch (\Exception $e) {
            Log::error('Exception in FileManagerFolderOperations@moveFolder: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function renameFolder(Request $request)
    {
        try {
            $currentDirectory = $request->input('currentFolder');
            $newDirectoryName = $request->input('directoryName');

            if (!File::exists($currentDirectory)) {
                return Response::json(['error' => 'Current directory does not exist'], 404);
            }

            $parentDirectory = dirname($currentDirectory);

            $newDirectoryPath = $parentDirectory . '/' . $newDirectoryName;
            File::move($currentDirectory, $newDirectoryPath);

            return Response::json([
                'message'   => 'Folder renamed successfully',
                'newPath'   => $newDirectoryPath
            ], 200);

        } catch (\Exception $e) {
            Log::error('Exception in FileManagerFolderOperations@renameFolder: ' . $e->getMessage());
            return Response::json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function deleteFolder(Request $request)
    {
        try {
            $currentDirectory = $request->input('currentFolder');
            
            if (!File::exists($currentDirectory)) {
                return Response::json(['error' => 'Current directory does not exist'], 404);
            }
            
            $parentDirectory = dirname($currentDirectory);

            if ($parentDirectory === Auth::user()->id) {
                return Response::json(['error' => 'Cannot delete root directory'], 403);
            }
            
            File::deleteDirectory($currentDirectory);
            
            return Response::json([
                'message'           => 'Folder deleted successfully',
                'parentDirectory'   => $parentDirectory
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Exception in FileManagerFolderOperations@deleteFolder: ' . $e->getMessage());
            return Response::json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function listDirectories(Request $request)
    {
        return Response::json([
            'directories'   => FileManager::listDirectories($request->input('directory'))
        ], 200);
    }
}

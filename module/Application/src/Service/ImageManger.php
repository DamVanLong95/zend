<?php
namespace Application\Service;

// The image manager service.
class ImageManager 
{
    // The directory where we save image files.
    private $saveToDir = './data/upload/';
        
    // Returns path to the directory where we save the image files.
    public function getSaveToDir() 
    {
        return $this->saveToDir;
    }  

    // Returns the array of uploaded file names.
    public function getSavedFiles() 
    {
        // The directory where we plan to save uploaded files.
        
        // Check whether the directory already exists, and if not,
        if(!is_dir($this->saveToDir)) {
            if(!mkdir($this->saveToDir)) {
                throw new \Exception('Could not create directory for uploads: ' . 
                             error_get_last());
            }
        }
        
        // Scan the directory and create the list of uploaded files.
        $files = [];        
        $handle  = opendir($this->saveToDir);
        while (false !== ($entry = readdir($handle))) {
            
            if($entry=='.' || $entry=='..')
                continue; // Skip current dir and parent dir.
            
            $files[] = $entry;
        }
        
        // Return the list of uploaded files.
        return $files;
    }  

     // Returns the path to the saved image file.
     public function getImagePathByName($fileName) 
     {
         // Take some precautions to make file name secure.
         $fileName = str_replace("/", "", $fileName);  // Remove slashes.
         $fileName = str_replace("\\", "", $fileName); // Remove back-slashes.
                 
         // Return concatenated directory name and file name.
         return $this->saveToDir . $fileName;                
     }
   
     // Returns the image file content. On error, returns boolean false. 
     public function getImageFileContent($filePath) 
     {
         return file_get_contents($filePath);
     }
}
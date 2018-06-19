<?php
namespace GalleryAPI\service;

use Upload\File;
use Upload\Storage\FileSystem;
use GalleryAPI\Environment;

class UploadService
{
    private $folderPath;
    private $fileHandle;

    public function __construct()
    {
        $this->folderPath = dirname($_SERVER['DOCUMENT_ROOT']) . "/phpWarehouse/". Environment::PROJECT_NAME. "/upload/";
    }

    public function uploadFile($fileId, $postFileName)
    {
        $this->fileHandle = new File($postFileName, new FileSystem($this->folderPath));
        $this->fileHandle->setName($fileId);
        $uploadFileData = [
            'name' => $this->fileHandle->getNameWithExtension(),
            'extentsion' => $this->fileHandle->getExtension(),
            'size' => $this->fileHandle->getSize(),
        ];
        try {
            // Success!
            $this->fileHandle->upload();
            return $uploadFileData;
        } catch (\Exception $e) {
            // Fail!
            return $this->fileHandle->getErrors();
        }
    }
}

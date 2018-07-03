<?php
namespace GalleryAPI\api_page;

use GalleryAPI\page_data\CoverData;
use GalleryAPI\service\CoverService;
use GalleryAPI\service\UploadService;

class Cover
{
    private $coverDataTool;
    private $uploadTool;

    private $albumId;

    public function __construct(string $albumId = null)
    {
        $this->albumId = $albumId;
        $this->uploadTool = new UploadService();
        $this->coverDataTool = new CoverData();
    }

    public function uploadCover($postFileName)
    {
        $coverNumber = $this->coverDataTool->selectCoverCount($this->albumId);
        if ($coverNumber < 3) { //只能上傳三張照片
            $coverId = $this->generateUniqueCoverId();
            $uploadData = $this->uploadTool->uploadFile($coverId, $postFileName);
            $this->coverDataTool->insertCover($coverId, $this->albumId, ($coverNumber + 1), $uploadData['name']);
            $coverFileNames = $this->coverDataTool->selectFileNames($this->albumId);
            $coverTool = new CoverService($this->albumId);
            $coverTool->combineCover($coverFileNames);
        }
    }

    private function generateCoverId(): string
    {
        $length = 10;
        $charaterSet = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        shuffle($charaterSet);
        return implode('', array_slice($charaterSet, 0, $length));
    }

    private function generateUniqueCoverId(): string
    {
        do {
            $id = $this->generateCoverId();
        } while ($this->coverDataTool->selectCheckIdExist($id));
        return $id;
    }
}

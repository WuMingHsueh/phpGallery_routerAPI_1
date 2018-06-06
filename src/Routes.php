<?php
namespace GalleryAPI;

class Routes implements IRouteResponse
{
    /***
     * #        功能                 URL                       Method       Request      Response
     * 1    新增使用者              /account                    POST       使用者資訊    使用者ID
     * 2    取得使用者資訊          /account/{accountID}        GET           -         使用者資訊
     * 3    取得相簿資訊            /album/{albumId}            GET           -         相簿資訊
     * 4    取得最新三張照片        /album/{albumId}/latest     GET           -         相片資訊陣列
     * 5    取得最紅三張照片        /album/{albumId}/hot        GET           -         相片資訊陣列
     * 6    建立相簿                /album                      POST       相簿資訊     相簿ID
     * 7    更新相簿資訊            /album/{albumId}            PATCH      相簿資訊     更新成功/失敗
     * 8    刪除相簿                /album/{albumId}            DELETE        -        刪除成功/失敗
     * 9    查詢相簿單一相片        /album/{albumId}/images/{
     *                             imageID}                     GET           -        相片資訊
     * 10   上傳照片                /album/{albumId}/image      POST       照片資訊      照片ID
     * 11   更新照片                /album/{albumId}/images/{
     *                             imageId}                    PATCH      照片資訊       照片ID
     * 12   刪除照片                /album/{albumId}/images/{
     *                             imageId}                    DELETE     照片資訊       照片ID
     * 13   取得照片內容           /i/{
     *                            imagesId}{imageSuffix}.jpg    GET         -         照片資料(Binary)
     * 14   取得相簿封面           /album/{albumId}/cover.jpg    /GET        -         照片資料(Binary)
     * 15   搬移圖片               /internal/move-image          POST      搬移資訊     搬移結果
     * 16   回復刪除的圖片         /internal/undelete-image      POST      刪除TOKEN
     *                                                                   回復目標相簿   回復結果
     */
    private $method;
    private $pathInfoData;
    private $control;
    
    public function __construct($method, $pathInfoData)
    {
        $this->method = $method;
        $this->pathInfoData = $pathInfoData;
        $this->control = new Control($method, $pathInfoData);
    }

    public function response($request)
    {
        $this->control->controlAPI($request);  //send Request to Control Objects
        echo $this->control->response();
    }
}

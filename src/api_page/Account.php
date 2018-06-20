<?php
namespace GalleryAPI\api_page ;

use GalleryAPI\page_data\AccountData;
use GalleryAPI\service\AuthService;
use GalleryAPI\service\XmlService;

class Account
{
    private $data;
    private $auth;
    private $xmlTool;

    public function __construct()
    {
        $this->data = new AccountData();
        $this->auth = new AuthService();
        $this->xmlTool = new XmlService;
    }

    public function userInfo($id)
    {
        $accountInfo = $this->data->selectAccountInfo($id);
        $accountAlbumInfo = $this->data->selectAccountAlbumInfo($id);
        $data = \array_merge($accountInfo[0], $this->reConstructureFromAlbumsArray($accountAlbumInfo));
        return $this->xmlTool->xmlEncodeDataArrayWithCData($data, ["success" => 1, "status" => "200"]);
    }

    public function create($request)
    {
        // 確認申請帳號是否存在
        $accountExistFlag = $this->data->selectAccountExist($request['account']);
        if ($accountExistFlag) {  // 不存在則寫入db
            $accountId = $this->generateAccountId(); // 產生account Id
            $this->data->insertAccount($request['account'], $request['bio'], $accountId);  // 寫入db
            return $this->xmlTool->xmlEncodeOneLevelWithContent(["type" => "string" ,"status" => "200", "success" => 1], $accountId); // xmlEncodeOneLevelWithContent 為一層的xml 含有標籤內文
            /* Xml output Example:
                <?xml version="1.0" encoding="UTF-8"?>
                <data type="string" success="1" status="200">CNo0hw5</data>
            */
        } else {  // 帳號重複
            $message = "此帳號已被註冊";
            header("HTTP/1.1 400 $message");
            return $this->xmlTool->xmlEncodeOneLevelWithContent(["type" => "string" ,"status" => "400", "success" => 0], $message); // xmlEncodeOneLevelWithContent 為一層的xml 含有標籤內文
            /* Xml output Example:
                <data type="string" success="0" status="400">此帳號已經被註冊</data>
            */
        }
    }

    private function generateAccountId()
    {
        return substr(bin2hex(openssl_random_pseudo_bytes(4)), 1);
    }

    private function reConstructureFromAlbumsArray($albums) {
        $xmlString = "";
        foreach ($albums as $attr) {
            $xmlString .= $this->xmlTool->xmlEncodeOneLevel('album', $attr);
        }
        $data['albums'] = [ "_cdata" => $xmlString];
        return $data;
    }
}

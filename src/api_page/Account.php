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
        return "GET /account/{id} -> " . $id;
    }

    public function create($request)
    {
        // 確認申請帳號是否存在
        $accountExistFlag = $this->data->selectAccountExist($request['account']);
        if ($accountExistFlag) {  // 不存在則寫入db
            $accountToken = $this->auth->generateToken($request['account']); // 產生account Token
            $this->data->insertAccount($request['account'], $request['bio'], $accountToken);  // 寫入db
            return $this->xmlTool->xmlEncodeOneLevelWithContent(["type" => "string" ,"status" => "200", "success" => 1], $accountToken); // xmlEncodeOneLevelWithContent 為一層的xml 含有標籤內文
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
}

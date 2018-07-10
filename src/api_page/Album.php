<?php
namespace GalleryAPI\api_page;

use GalleryAPI\page_data\AlbumData;
use GalleryAPI\service\AuthService;
use GalleryAPI\service\XmlService;
use GalleryAPI\Environment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Album
{
    private $dataTool;
    private $xmlTool;
    private $authTool;

    public function __construct()
    {
        $this->dataTool = new AlbumData();
        $this->xmlTool = new XmlService();
        $this->authTool = new AuthService();
    }

    public function create($request)
    {
        $loginUser = '恩追'; // $loginUser = $this->authTool->getLoginUser();
        $albumId = $this->generateAlbumId();
        $this->dataTool->insertAlbum($albumId, $request['title'], $request['description'], $loginUser);
        return $this->xmlTool->xmlEncodeOneLevelWithContent(["type" => "string", "status" => "200", "success" => 1], $albumId); // xmlEncodeOneLevelWithContent 為一層的xml 含有標籤內文
	}
	
	public function curlCover($albumId)
	{
		$path =  "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/" . Environment::PROJECT_NAME . "/image/cover/{$albumId}.jpg";
		
		$client = new Client;
		try 
		{
			$response = $client->request('GET', $path);
			header('content-type: image/jpg');
            return $response->getBody();
		}
		catch (RequestException $e)
		{
			header('http/1.1 404 找不到封面');
			return $e->getMessage();
		}
	}

    public function delete($albumId)
    {
        return "delete album Id : $albumId";
    }

    public function update($request, $albumId)
    {
        return "patch " . print_r($request, true) . " Id : " . $albumId;
    }

    public function queryAlbumInfo($albumId)
    {
        if ($this->dataTool->selectAlbumExist($albumId)) {
            $albumInfo = $this->dataTool->selectAlbumInfo($albumId);
            $coverInfo = $this->dataTool->selectAlbumCovers($albumId);
            $link = ['link' => "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"];
            $imageCount = $this->dataTool->selectAlbumImageCount($albumId);
            $imageItems = $this->dataTool->selectAlbumImageItem($albumId);
            $data = \array_merge(
                $albumInfo,
                $this->reConstructureArrayXmlCData('covers', $coverInfo),
                $link,
                $imageCount,
                $this->reConstructureArrayXmlCData('images', $imageItems)
            );
            return $this->xmlTool->xmlEncodeDataArrayWithCData($data, ["success" => 1, "status" => "200"]);
        } else {
            header("HTTP/1.1 404 找不到相簿");
            return $this->xmlTool->xmlEncodeOneLevel("data", ["success" => 0, "status" => "404"]);
        }
    }

    public function queryHot($albumId)
    {
        return "get hot of $albumId";
    }

    public function queryLatest($albumId)
    {
        return "get latest of $albumId";
    }

    private function generateAlbumId()
    {
        // 產生 5~11 字的亂數字串為album 的 Id
        return substr(hash('md5', uniqid()), 0, rand(5, 11));
    }

    private function reConstructureArrayXmlCData(string $name, array $arrays): array
    {
        $string = '';
        foreach ($arrays as $array) {
            $string .= $this->xmlTool->xmlEncodeOneLevelWithArray($array);
        }
        $data[$name] = ['_cdata' => $string];
        return $data;
    }
}

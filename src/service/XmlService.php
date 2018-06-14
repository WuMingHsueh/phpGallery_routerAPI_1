<?php
namespace GalleryAPI\service;

use Spatie\ArrayToXml\ArrayToXml;

class XmlService
{
    // https://packagist.org/packages/spatie/array-to-xml
    // https://github.com/spatie/array-to-xml

    public function xmlEncodeOneLevelWithContent(Array $attr, $content)
    {
        $array = [
            "data" => [
                '_attributes' => $attr,
                '_value' => $content
            ]
        ];
        return $this->removeRootTag(ArrayToXml::convert($array, '', true, 'UTF-8'));
    }

    private function removeRootTag($xmlString)
    {
        return str_replace("</root>", "", str_replace("<root>", "", $xmlString));
    }
}

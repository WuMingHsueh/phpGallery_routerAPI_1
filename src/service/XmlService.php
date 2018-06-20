<?php
namespace GalleryAPI\service;

use Spatie\ArrayToXml\ArrayToXml;

class XmlService
{
    // https://packagist.org/packages/spatie/array-to-xml
    // https://github.com/spatie/array-to-xml

    public function xmlEncodeDataArray(array $data, array $attr)
    {
        return ArrayToXml::convert($data, [
            'rootElementName' => 'data',
            '_attributes' => $attr,
        ], true, 'UTF-8');
    }

    public function xmlEncodeDataArrayWithCData(array $data, array $attr) 
    {
        $xmlString = ArrayToXml::convert($data, [
            'rootElementName' => 'data',
            '_attributes' => $attr,
        ], true, 'UTF-8');
        return $this->removeCData($xmlString);
    }

    public function xmlEncodeOneLevel(string $root, array $attr): string 
    {
        $temp = ArrayToXml::convert([], [
            'rootElementName' => $root,
            '_attributes' => $attr
        ]);
        return $this->removePHPEOL($this->removeFirstTag($temp));
    }

    public function xmlEncodeOneLevelWithContent(array $attr, $content)
    {
        $array = [
            "data" => [
                '_attributes' => $attr,
                '_value' => $content
            ]
        ];
        return $this->removeRootTag(ArrayToXml::convert($array, '', true, 'UTF-8'));
    }

    private function removeCData($xmlString)
    {
        return str_replace("]]>", "", str_replace("<![CDATA[", "", $xmlString));
    }

    private function removeFirstTag($xmlString)
    {
        return str_replace('<?xml version="1.0"?>', "", $xmlString);
    }

    private function removePHPEOL($xmlString) 
    {
        return str_replace(PHP_EOL, "", $xmlString);
    }

    private function removeRootTag($xmlString)
    {
        return str_replace("</root>", "", str_replace("<root>", "", $xmlString));
    }
}

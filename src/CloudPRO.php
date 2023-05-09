<?php
namespace CloudPRO;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;

class CloudPRO
{
    private static Client $client;
    private static string $accessKey;
    private static string $boxToken;
    private static CloudPRO $_instance;

    public function __construct()
    {
        self::$client = new Client([
            'base_uri' => 'https://www.idprocloud.com/api/v1/',
        ]);
    }

    public static function begin()
    {
        self::$_instance = new CloudPRO();

        return self::$_instance;
    }

    public static function useAppAccess(string $accessKey)
    {
        self::$accessKey = $accessKey;
        return self::$_instance;
    }

    public static function useBoxToken(string $boxToken)
    {
        self::$boxToken = $boxToken;
        return self::$_instance;
    }

    public static function showNode(string $key)
    {
        return json_decode(self::$client->get("box/$key", [
            "headers" => [
                "PRO-Box-Token" => self::$boxToken
            ]
        ])->getBody()->getContents(), TRUE);
    }

    public static function renameNode(string $key, string $name)
    {
        return json_decode(self::$client->put("box/$key", [
            "headers" => [
                "PRO-Box-Token" => self::$boxToken
            ],
            "form_params" => [
                "name" => $name
            ]
        ])->getBody()->getContents(), TRUE);
    }

    public static function storeFolder(string $name, array $options = [])
    {
        return json_decode(self::$client->post("box", [
            "headers" => [
                "PRO-Box-Token" => self::$boxToken
            ],
            "form_params" => [
                "name" => $name,
            ] + $options
        ])->getBody()->getContents(), TRUE);
    }

    public static function storeNode(string $name, string $path, array $options = [])
    {
        $preparedOptions = array_map(function ($option, $key) {
            return [
                "name" => $key,
                "contents" => $option
            ];
        }, $options, array_keys($options));

        return json_decode(self::$client->post("box", [
            "headers" => [
                "PRO-Box-Token" => self::$boxToken
            ],
            "multipart" => [
                [
                    "name" => "name",
                    "contents" => $name,
                ],
                [
                    "name" => "file",
                    "contents" => Utils::tryFopen($path, "r"),
                ],
                ...$preparedOptions
            ]
        ])->getBody()->getContents(), TRUE);
    }

    public static function moveNode(string $key, string $parentKey)
    {
        return json_decode(self::$client->post("box/cut", [
            "headers" => [
                "PRO-Box-Token" => self::$boxToken
            ],
            "form_params" => [
                "nodeKey" => $key,
                "parentKey" => $parentKey
            ]
        ])->getBody()->getContents(), TRUE);
    }

    public static function copyNode(string $key, string $parentKey)
    {
        return json_decode(self::$client->post("box/copy", [
            "headers" => [
                "PRO-Box-Token" => self::$boxToken
            ],
            "form_params" => [
                "nodeKey" => $key,
                "parentKey" => $parentKey
            ]
        ])->getBody()->getContents(), TRUE);
    }

    public static function deleteNode(string $key)
    {
        return json_decode(self::$client->delete("box/$key", [
            "headers" => [
                "PRO-Box-Token" => self::$boxToken
            ],
        ])->getBody()->getContents(), TRUE);
    }

    public static function storeBox(string $name)
    {
        return json_decode(self::$client->post("app/box", [
            "headers" => [
                "PRO-App-Token" => self::$accessKey
            ],
            "form_params" => [
                "name" => $name,
            ]
        ])->getBody()->getContents(), TRUE);
    }
}
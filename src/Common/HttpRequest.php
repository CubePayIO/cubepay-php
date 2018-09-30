<?php
namespace CubePay\Common;

class HttpRequest {

    private $url;

    public function __construct($url) {
        $this->url = $url;
    }

    public function getResponse($method, $params = []) {
        $response = $this->execute($this->url . $method, $params);

        if (!self::isJSON($response)) {
            $result = (object)[
                        'status' => '500',
                        'last'   => 'Request fail.',
            ];
        } else {
            $result = json_decode($response);
        }

        return $result;
    }

    private function execute($url, $params = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    private static function isJSON($string) {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

}

?>
<?php
namespace CubePay\Common;

class Signature {

    private $clientId, $clientSecret;

    public function __construct($clientId, $clientSecret) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function getParamsWithSignature($params) {
        $params["client_id"] = $this->clientId;
        $params["sign"] = $this->generateSignature($params);

        return $params;
    }

    public function generateSignature($params) {
        if (isset($params["sign"])) {
            unset($params["sign"]);
        }
        ksort($params);
        $string = urldecode(http_build_query($params)) . "&client_secret={$this->clientSecret}";

        return strtoupper(hash("sha256", $string));
    }

    public function verifySignature($params) {
        $clientSign = $params["sign"];
        unset($params["sign"]);

        $serverSgin = $this->generateSignature($params, $this->clientSecret);

        return $serverSgin === $clientSign;
    }

}

?>
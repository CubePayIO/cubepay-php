<?php
namespace CubePay;

use CubePay\Common\HttpRequest;
use CubePay\Common\Signature;

class CubePay {

    private $httpRequest, $signature;

    public function __construct($clientId, $clientSecret, $url) {
        $this->httpRequest = new HttpRequest($url);
        $this->signature = new Signature($clientId, $clientSecret);
    }

    /**
     * Get list of available cryptocurrencies.
     * You can use these currencies at payment API for receive/send coin.
     */
    public function getCoin() {
        $method = "/currency/coin";
        $params = [
                ];
        $signParams = $this->signature->getParamsWithSignature($params);

        $response = $this->httpRequest->getResponse($method, $signParams);

        return $response;
    }

    /**
     * Get list of available fiat currenies.
     * You can only use these fiat currencies for your product's original list price, not for receive/send, 
     * we'll convert value by exchange rate between currency of list price and currency of actual paid.
     */
    public function getFiat() {
        $method = "/currency/fiat";
        $params = [
                ];
        $signParams = $this->signature->getParamsWithSignature($params);

        $response = $this->httpRequest->getResponse($method, $signParams);

        return $response;
    }

    /**
     * Render a page(but not initial a payment yet) within these information:
     * - Your shop information
     * - Item name
     * - Payable coin list and corresponding price.
     */
    public function doPayment($sourceCoinId, $sourceAmount, $itemName, $merchantTransactionId, $other = null, $returnUrl = null, $ipnUrl = null, $sendCoinId = null, $sendAmount = null, $receiveAddress = null) {
        $method = "/payment";
        $params = [
            "source_coin_id"          => $sourceCoinId,
            "source_amount"           => $sourceAmount,
            "item_name"               => $itemName,
            "merchant_transaction_id" => $merchantTransactionId,
            "other"                   => $other,
            "return_url"              => $returnUrl,
            "ipn_url"                 => $ipnUrl,
            "send_coin_id"            => $sendCoinId,
            "send_amount"             => $sendAmount,
            "receive_address"         => $receiveAddress,
        ];
        $signParams = $this->signature->getParamsWithSignature($params);

        $response = $this->httpRequest->getResponse($method, $signParams);

        return $response;
    }

    /**
     * Initial order with specific coin. Order will expire after 6 hours.
     * If define the parameter send_coin_id, receive_address, send_amount, 
     * we'll lock the amount of send coin and fee temporarily and unlock until payment finish or expired.
     */
    public function doPaymentByCoinId($coinId, $sourceCoinId, $sourceAmount, $itemName, $merchantTransactionId, $other = null, $returnUrl = null, $ipnUrl = null, $sendCoinId = null, $sendAmount = null, $receiveAddress = null) {
        $method = "/payment/coin";
        $params = [
            "coin_id"                 => $coinId,
            "source_coin_id"          => $sourceCoinId,
            "source_amount"           => $sourceAmount,
            "item_name"               => $itemName,
            "merchant_transaction_id" => $merchantTransactionId,
            "other"                   => $other,
            "return_url"              => $returnUrl,
            "ipn_url"                 => $ipnUrl,
            "send_coin_id"            => $sendCoinId,
            "send_amount"             => $sendAmount,
            "receive_address"         => $receiveAddress,
        ];
        $signParams = $this->signature->getParamsWithSignature($params);

        $response = $this->httpRequest->getResponse($method, $signParams);

        return $response;
    }

    /**
     * Query payment information by specific identity.
     */
    public function queryPayment($id = null, $merchantTransactionId = null) {
        $method = "/payment/query";
        $params = [
            "id"                      => $id,
            "merchant_transaction_id" => $merchantTransactionId,
        ];
        $signParams = $this->signature->getParamsWithSignature($params);

        $response = $this->httpRequest->getResponse($method, $signParams);

        return $response;
    }

}

?>
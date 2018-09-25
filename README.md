# CubePay API library for PHP 
A third-party cryptocurrency payment gateway. 

Make it easy for receiving cryptocurrency!

More information at http://cubepay.io.

## Installation
- The minimum required PHP version of Yii is PHP 5.4.
- It works best with PHP 7.

```
$ php composer.phar require cubepay/cubepay-api-library
```  

## Usage
**Initialization**
```
$cubepay = new CubePay(CLIENT_ID, CLIENT_SECRET, URL);
```

**Get available cryptocurrencies**

You can use these currencies at payment API for receive/send coin.

```
$response = $cubepay->getCoin();
```

**Getavailable fiat currenies.**

You can only use these fiat currencies for your product's original list price. We'll convert value by exchange rate between currency of list price and currency of actual paid.

```
$response = $cubepay->getFiat();
```

**Do Payment**

Render a page with these payment information:
 - Your shop information
 - Item name
 - Payable coin list and corresponding price.
     
```
$response = $cubepay->doPayment($sourceCoinId, $sourceAmount, $itemName, $merchantTransactionId, $other = null, $returnUrl = null, $ipnUrl = null, $sendCoinId = null, $sendAmount = null, $receiveAddress = null);
```

**Init payment With specific coin**

Initial payment with specific coin. The payment will expire after 6 hours.
     
```
$response = $cubepay->doPaymentByCoinId($coinId, $sourceCoinId, $sourceAmount, $itemName, $merchantTransactionId, $other = null, $returnUrl = null, $ipnUrl = null, $sendCoinId = null, $sendAmount = null, $receiveAddress = null);
```

**Query payment information**

Query payment information by specific identity
     
```
$response = $cubepay->queryPayment($id = null, $merchantTransactionId = null);
```

## API Document

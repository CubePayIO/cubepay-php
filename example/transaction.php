<?php
require '_config.php';

use CubePay\CubePay;

$cubepay = new CubePay(CLIENT_ID, CLIENT_SECRET, URL);
$coinList = $cubepay->getCoin()->data;
$fiatList = $cubepay->getFiat()->data;

if (isset($_POST) && isset($_POST["execute"])) {
    if ($_POST["execute"] == "paymentCoin") {
        $response = $cubepay->doPaymentByCoinId($_POST["coin_id"], $_POST["source_coin_id"], $_POST["source_amount"], $_POST["item_name"], $_POST["merchant_transaction_id"], @$_POST["other"], @$_POST["return_url"], @$_POST["ipn_url"], @$_POST["send_coin_id"], @$_POST["send_amount"], @$_POST["receive_address"]);
    } elseif ($_POST["execute"] == "payment") {
        $response = $cubepay->doPayment($_POST["source_coin_id"], $_POST["source_amount"], $_POST["item_name"], $_POST["merchant_transaction_id"], @$_POST["other"], @$_POST["return_url"], @$_POST["ipn_url"], @$_POST["send_coin_id"], @$_POST["send_amount"], @$_POST["receive_address"]);
    } else {
        $response = $cubepay->queryPayment(@$_POST["id"], @$_POST["merchant_transaction_id"]);
    }
}

//if (isset($_POST) && !isset($_POST["execute"])) {
//    $response = $cubepay->signature->verifySignature($_POST);
//    var_dump($response);exit;
//}

?>

<html>
    <body>
        <?php if (!isset($response)): ?>
            <h3>Do Payment</h3>
            <form method="POST">
                <b>* Source Coin</b> : 
                <select name="source_coin_id" required="true">
                    <?php foreach ((object)array_merge((array)$coinList, (array)$fiatList) as $_value): ?>
                        <option value="<?= $_value->id; ?>"><?= $_value->symbol . " (" . $_value->name . ")"; ?></option>
                    <?php endforeach; ?>
                </select>
                <i> (Coin id of your original list price.)</i>
                <br/>
                <b>* Source Amount</b> : 
                <input type="number" name="source_amount" min="0.1" step="0.0001" value="0.5" required="true"/>
                <i> (Original list price of your product price.)</i>
                <br/>
                <b>* Item name</b> : 
                <input type="text" name="item_name" value="Test Item Name" required="true"/>
                <br/>
                <b>* Merchant Transactiod ID</b> : 
                <input type="text" name="merchant_transaction_id" value="<?= time(); ?>" required="true"/>
                <br/>
                <b>Other</b> : 
                <input type="text" name="other" value="member_account=peter||product_id=product_test"/>
                <i> (Other information you can pass to the payment, such as your member id, your product id or anything you want....We'll return the field for your at IPN_URL.)</i>
                <br/>
                <b>Return Url</b> : 
                <input type="text" name="return_url" value=""/>
                <br/>
                <b>IPN Url</b> : 
                <input type="text" name="ipn_url" value=""/>
                <br/>
                <b>Send Coin</b> : 
                <select name="send_coin_id">
                    <option value="">None</option>
                    <?php foreach ($coinList as $_value): ?>
                        <option value="<?= $_value->id; ?>"><?= $_value->symbol . " (" . $_value->name . ")"; ?></option>
                    <?php endforeach; ?>
                </select>
                <i> (Coin that you want to send back to your customer, we'll send this coin to receive_address you define.If you pass value on send_coin_id, you should pass value on <b>receive_address</b> and <b>send_amount</b> too.)</i>
                <br/>
                <b>Send Amount</b> : 
                <input type="number" name="send_amount" min="0.1" step="0.0001" value=""/>
                <br/>
                <b>Receive Address</b> : 
                <input type="text" name="receive_address" value=""/>
                <br/>
                <button type="submit" name="execute" value="payment">Submit</button>
            </form>
            <hr>
            <h3>Do Payment With Coin</h3>
            <form method="POST">
                <b>* Coin</b> : 
                <select name="coin_id" required="true">
                    <?php foreach ($coinList as $_value): ?>
                        <option value="<?= $_value->id; ?>"><?= $_value->symbol . " (" . $_value->name . ")"; ?></option>
                    <?php endforeach; ?>
                </select>
                <i> (Coin you want to receive by payment.)</i>
                <br/>
                <b>* Source Coin</b> : 
                <select name="source_coin_id" required="true">
                    <?php foreach ((object)array_merge((array)$coinList, (array)$fiatList) as $_value): ?>
                        <option value="<?= $_value->id; ?>"><?= $_value->symbol . " (" . $_value->name . ")"; ?></option>
                    <?php endforeach; ?>
                </select>
                <i> (Coin id of your original list price.)</i>
                <br/>
                <b>* Source Amount</b> : 
                <input type="number" name="source_amount" min="0.1" step="0.0001" value="0.5" required="true"/>
                <i> (Original list price of your product price.)</i>
                <br/>
                <b>* Item name</b> : 
                <input type="text" name="item_name" value="Test Item Name" required="true"/>
                <br/>
                <b>* Merchant Transactiod ID</b> : 
                <input type="text" name="merchant_transaction_id" value="<?= time(); ?>" required="true"/>
                <br/>
                <b>Other</b> : 
                <input type="text" name="other" value="member_account=peter||product_id=product_test"/>
                <i> (Other information you can pass to the payment, such as your member id, your product id or anything you want....We'll return the field for your at IPN_URL.)</i>
                <br/>
                <b>Return Url</b> : 
                <input type="text" name="return_url" value=""/>
                <br/>
                <b>IPN Url</b> : 
                <input type="text" name="ipn_url" value=""/>
                <br/>
                <b>Send Coin</b> : 
                <select name="send_coin_id">
                    <option value="">None</option>
                    <?php foreach ($coinList as $_value): ?>
                        <option value="<?= $_value->id; ?>"><?= $_value->symbol . " (" . $_value->name . ")"; ?></option>
                    <?php endforeach; ?>
                </select>
                <i> (Coin that you want to send back to your customer, we'll send this coin to receive_address you define.If you pass value on send_coin_id, you should pass value on <b>receive_address</b> and <b>send_amount</b> too.)</i>
                <br/>
                <b>Send Amount</b> : 
                <input type="number" name="send_amount" min="0.1" step="0.0001" value=""/>
                <br/>
                <b>Receive Address</b> : 
                <input type="text" name="receive_address" value=""/>
                <br/>
                <button type="submit" name="execute" value="paymentCoin">Submit</button>
            </form>
            <hr>
            <h3>Query Payment By CubePay Payment ID or Merchant Transaction ID</h3>
            <form method="POST">
                <b>Payment ID</b> : 
                <input type="text" name="id" value=""/>
                <br/>
                <b>Merchant Transactiod ID</b> : 
                <input type="text" name="merchant_transaction_id" value=""/>
                <br/>
                <button type="submit" name="execute" value="paymentQuery">Submit</button>
            </form>
        <?php else: ?>
            <?php if ($response->status == 200): ?>
                Raw Data:<br/>
                <textarea rows="10" style="width:100%"><?= json_encode($response); ?></textarea>
                <br/>
                <a href="transaction.php">Go Back</a> &nbsp;&nbsp;
                <?php if ($_POST["execute"] == "paymentCoin"): ?>
                    <a href="<?= $response->data->pay_url; ?>" target="_blank">Redirect to payment</a> 
                    <br/>
                    <b>Pay Address</b> : <?= $response->data->pay_info->address; ?>
                    <br/>
                    <img src="<?= $response->data->pay_info->qrcode; ?>"/>
                <?php elseif ($_POST["execute"] == "payment"): ?>
                    <a href="<?= $response->data; ?>" target="_blank">Redirect to payment</a> 
                <?php endif; ?>
            <?php else:; ?>
                Error : <?= $response->data; ?>
            <?php endif; ?>
        <?php endif; ?>
    </body>
</html>
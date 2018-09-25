<?php
require '_config.php';

use CubePay\CubePay;

$cubepay = new CubePay(CLIENT_ID, CLIENT_SECRET, URL);

if (isset($_GET["execute"])) {
    if ($_GET["execute"] == "coin") {
        $response = $cubepay->getCoin();
    }
    if ($_GET["execute"] == "fiat") {
        $response = $cubepay->getFiat();
    }
}

?>

<html>
    <body>
        <a href="currency.php?execute=coin">List Coins</a> &nbsp;&nbsp; <a href="currency.php?execute=fiat">List Fiats</a>
        <hr>
        <?php if (isset($response)): ?>
            <?php if ($response->status == 200): ?>
                <table>
                    <thead>
                    <th>ID</th>
                    <th>Symbol</th>
                    <th>Name</th>
                </thead>
                <tbody>
                    <?php foreach ($response->data as $_value): ?>
                        <tr>
                            <td><?= $_value->id; ?></td>
                            <td><?= $_value->symbol; ?></td>
                            <td><?= $_value->name; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else:; ?>
            Error : <?= $response->data; ?>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
<?php

use Ramomen\YapikrediPosLaravel\YapiKredi;


$transaction = new YapiKredi();

$testTransaction = $transaction->doSale(
    '1234567890123456', // Card number
    '1221', // Expiry date (month and year) Example: 1221
    '123',  // Card's security code
    '12345678901234567890', // Order ID (activation code) Example: Str::random(20)
    '100',  // Amount Example: 100 (1.00 TRY)
    'YT'    // Currency Example: YT (TRY)
);


// if response is successful
if ($testTransaction->status == true) {
    // do something
    echo 'Transaction is successful';
} else {
    // do something
    echo 'Transaction is not successful';
}

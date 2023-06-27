# YapiKrediPosLaravel

YapiKrediPosLaravel is a library that enables the integration of Yapı Kredi Posnet into Laravel projects.

This library utilizes the Yapı Kredi Posnet API to perform payment transactions.

## Installation

1. Install the library into your Laravel project using `composer`:

````shell
    composer require ramomen/yapikrediposlaravel
````

After the library is installed, you need to configure the following settings in your .env file:

````
YAPIKREDI_MERCHANT_ID=000000000000000
YAPIKREDI_TERMINAL_ID=00000000
YAPIKREDI_MODE=test
````

Note: The YAPIKREDI_MODE setting can be set to either test or production. In the test mode, transactions will be performed in the test environment, while in the production mode, transactions will be performed in the live environment.

In the integration area, you can use the YapiKredi class. Here is an example usage:


````
use Ramomen\YapikrediPosLaravel\YapiKredi;


// Create an instance of YapiKredi and pass the Posnet instance as a parameter
$yapiKredi = new YapiKredi();

// Perform a sale transaction
$result = $yapiKredi->doSale(
    '1234567890123456', // Card number
    '1221', // Expiry date
    '123', // CVC
    'ABC123', // Order ID
    '100', // Amount
    'YT' // Currency
);

// Handle the result of the transaction
if ($result->status) {
    echo 'Transaction successful!' . PHP_EOL;
    echo 'Approval code: ' . $result->approvedCode . PHP_EOL;
    echo 'Activation code: ' . $result->activationCode . PHP_EOL;
    echo 'Mode: ' . $result->mode . PHP_EOL;
} else {
    echo 'Transaction failed!' . PHP_EOL;
    echo 'Error code: ' . $result->errorCode . PHP_EOL;
    echo 'Error message: ' . $result->posnetResponse . PHP_EOL;
    // You can access additional error details using $result->merchantInfo and $result->posnetResponseXMLData
}
````
Please note that the example above is just a demonstration, and you may need to adapt it to fit your specific integration requirements.



Feel free to customize the README file as per your project's needs and provide additional information about the library, usage instructions, and any other relevant details.


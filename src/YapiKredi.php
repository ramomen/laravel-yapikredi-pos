<?php

namespace Ramomen\YapikrediPosLaravel;


class YapiKredi
{
    private $merchantId;
    private $terminalId;
    private $mode;
    private $posnet;


    /**
     * YapiKredi Posnet constructor.
     * @param Posnet $posnet
     */

    public function __construct(Posnet $posnet)
    {
        $this->posnet = $posnet;
        $this->merchantId = $_ENV['YAPIKREDI_MERCHANT_ID'] ?? '000000000000000';
        $this->terminalId = $_ENV['YAPIKREDI_TERMINAL_ID'] ?? '00000000';

        $mode = $_ENV['YAPIKREDI_MODE'] ?? 'test';
        $this->mode = $mode === 'production'
            ? 'https://posnet.yapikredi.com.tr/PosnetWebService/XML'
            : 'https://setmpos.ykb.com/PosnetWebService/XML';
    }

    /**
     * Performs a sale transaction.
     *
     * @param string $cardNumber Card number
     * @param string $yymm Expiry date (month and year) Example: 1221
     * @param string $cvc Card's security code
     * @param string $orderId Order ID (activation code) Example: Str::random(20)
     * @param string $price Amount Example: 100 (1.00 TRY)
     * @param string $currency Currency Example: YT (TRY)
     * @param string|null $installment Installment number (optional)
     * @param string|null $multpoint Bonus usage (optional)
     * @param string|null $extpoint Extra point usage (optional)
     * @return object Represents the result of the transaction
     */

    public function doSale(
        $cardNumber,
        $yymm,
        $cvc,
        $orderId,
        $price,
        $currency,
        $installment = null,
        $multpoint = null,
        $extpoint = null
    ) {
        $posnet = $this->posnet;
        $posnet->UseOpenssl();
        $posnet->SetURL($this->mode);
        $posnet->SetMid($this->merchantId);
        $posnet->SetTid($this->terminalId);

        $posnet->DoSaleTran(
            $cardNumber,
            $yymm,
            $cvc,
            $orderId,
            $price,
            $currency,
            $installment,
            $multpoint,
            $extpoint
        );

        $approvedCode = $posnet->GetApprovedCode();
        $errcode = $posnet->GetResponseCode();

        if ($approvedCode) {
            return (object) [
                'status' => true,
                'approvedCode' => $approvedCode,
                'activationCode' => $orderId,
                'mode' => $this->mode,
            ];
        } else {
            return (object) [
                'status' => false,
                'approvedCode' => $approvedCode,
                'errorCode' => $errcode,
                'merchantInfo' => $posnet->merchantInfo,
                'mode' => $this->mode,
                'posnetResponse' => $posnet->posnetResponse,
                'posnetResponseXMLData' => $posnet->strResponseXMLData,
            ];
        }
    }
}

<?php

namespace App\Services\Payment;

class MyFatoorahPayment implements PaymentGatewayInterface
{
    private $apiURL;
    private $apiKey;

    public function __construct($isLive = false)
    {
        if ($isLive) {
            $this->apiURL = 'https://api.myfatoorah.com';
            $this->apiKey = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53nj
                             Uoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG
                             5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLM
                             vYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt
                             6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX
                            sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY
                            3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A
                            BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjV
                             TIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh
                            wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77
                             652xwPNxMRTMASk1ZsJL';
        } else {
            $this->apiURL = 'https://apitest.myfatoorah.com';
            $this->apiKey = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';
        }
    }

    public function payment($amount, $order_id, $redirect_url, $payment_method = 1)
    {

        $postFields = [
            'paymentMethodId' => $payment_method,
            'InvoiceValue' => $amount,
            'CallBackUrl' => $redirect_url,
            'ErrorUrl' => route('failPayment'),
            'Language' => app()->getLocale(),
            'CustomerReference' => $order_id,
        ];

        return $this->callAPI("$this->apiURL/v2/ExecutePayment", $postFields);
    }

    public function refund($amount, $paymentId)
    {
        $postFields = [
            "KeyType" => 'paymentId',
            "Key" => $paymentId,
            "Amount" => $amount,
            "Comment" => "Refund",
        ];

        return $this->callAPI("$this->apiURL/v2/MakeRefund", $postFields);
    }

    public function validatePayment($paymentId)
    {
        $postFields = [
            'Key' => $paymentId,
            'KeyType' => 'paymentId'
        ];

        return $this->callAPI("$this->apiURL/v2/getPaymentStatus", $postFields);
    }

    private function callAPI($endpointURL, $postFields = [], $requestType = 'POST')
    {
        $curl = curl_init($endpointURL);
        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST => $requestType,
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $this->apiKey", 'Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
        ));

        $response = curl_exec($curl);
        $curlErr = curl_error($curl);

        curl_close($curl);

        if ($curlErr) {
            return (object) ["status" => false, "message" => $curlErr];
        }

        if (!$response) {
            return (object) ["status" => false, "message" => 'No response from API'];
        }

        $error = $this->handleError($response);
        if ($error) {
            return (object) ["status" => false, "message" => $error];
        }

        $res = json_decode($response);

        return (object) ["status" => true, "response" => $res];
    }

    private function handleError($response)
    {
        $json = json_decode($response);
        if (isset($json->IsSuccess) && $json->IsSuccess == true) {
            return null;
        }

        if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
            $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
            $error = implode(', ', array_map(function ($error) {
                return "{$error->Name}: {$error->Error}";
            }, $errorsObj));
        } else if (isset($json->Data->ErrorMessage)) {
            $error = $json->Data->ErrorMessage;
        }

        if (empty($error)) {
            $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
        }

        return $error;
    }
}

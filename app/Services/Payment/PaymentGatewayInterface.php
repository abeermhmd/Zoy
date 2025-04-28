<?php

namespace App\Services\Payment;

interface PaymentGatewayInterface
{
    public function payment($amount, $order_id, $redirect_url, $payment_method = 1);     /// payment_method :  1->knet , 2->mastrcard/visa
    public function refund($amount, $paymentId);
    public function validatePayment($paymentId);
}

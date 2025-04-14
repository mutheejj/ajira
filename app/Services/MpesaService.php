<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MpesaService
{
    protected $baseUrl;
    protected $consumerKey;
    protected $consumerSecret;
    protected $shortCode;
    protected $passKey;
    protected $callbackUrl;

    public function __construct()
    {
        // Initialize with values from config (you'll need to add these to your .env file)
        $this->baseUrl = config('services.mpesa.base_url', 'https://sandbox.safaricom.co.ke');
        $this->consumerKey = config('services.mpesa.consumer_key');
        $this->consumerSecret = config('services.mpesa.consumer_secret');
        $this->shortCode = config('services.mpesa.short_code');
        $this->passKey = config('services.mpesa.pass_key');
        $this->callbackUrl = config('services.mpesa.callback_url');
    }

    /**
     * Get OAuth access token from M-Pesa
     */
    public function getAccessToken()
    {
        try {
            $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
                ->get("{$this->baseUrl}/oauth/v1/generate?grant_type=client_credentials");

            $result = $response->json();
            return $result['access_token'] ?? null;
        } catch (\Exception $e) {
            Log::error('M-Pesa Access Token Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Initiate STK Push transaction
     * 
     * @param string $phoneNumber Phone number to send STK push (format: 2547XXXXXXXX)
     * @param float $amount Amount to be charged
     * @param string $reference Transaction reference
     * @param string $description Transaction description
     * @return array|null
     */
    public function stkPush($phoneNumber, $amount, $reference, $description)
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return [
                'success' => false,
                'message' => 'Unable to get access token from M-Pesa'
            ];
        }

        // Format timestamp for M-Pesa
        $timestamp = Carbon::now()->format('YmdHis');
        $password = base64_encode($this->shortCode . $this->passKey . $timestamp);

        try {
            $response = Http::withToken($accessToken)
                ->post("{$this->baseUrl}/mpesa/stkpush/v1/processrequest", [
                    'BusinessShortCode' => $this->shortCode,
                    'Password' => $password,
                    'Timestamp' => $timestamp,
                    'TransactionType' => 'CustomerPayBillOnline',
                    'Amount' => $amount,
                    'PartyA' => $phoneNumber,
                    'PartyB' => $this->shortCode,
                    'PhoneNumber' => $phoneNumber,
                    'CallBackURL' => $this->callbackUrl,
                    'AccountReference' => $reference,
                    'TransactionDesc' => $description
                ]);

            $result = $response->json();
            Log::info('M-Pesa STK Push Response: ' . json_encode($result));

            if (isset($result['ResponseCode']) && $result['ResponseCode'] == '0') {
                return [
                    'success' => true,
                    'message' => 'STK push initiated successfully',
                    'checkout_request_id' => $result['CheckoutRequestID'],
                    'response' => $result
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $result['errorMessage'] ?? 'STK push failed',
                    'response' => $result
                ];
            }
        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Exception occurred: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check STK Push transaction status
     * 
     * @param string $checkoutRequestId Checkout request ID from STK push
     * @return array|null
     */
    public function checkStkStatus($checkoutRequestId)
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return [
                'success' => false,
                'message' => 'Unable to get access token from M-Pesa'
            ];
        }

        // Format timestamp for M-Pesa
        $timestamp = Carbon::now()->format('YmdHis');
        $password = base64_encode($this->shortCode . $this->passKey . $timestamp);

        try {
            $response = Http::withToken($accessToken)
                ->post("{$this->baseUrl}/mpesa/stkpushquery/v1/query", [
                    'BusinessShortCode' => $this->shortCode,
                    'Password' => $password,
                    'Timestamp' => $timestamp,
                    'CheckoutRequestID' => $checkoutRequestId
                ]);

            $result = $response->json();
            Log::info('M-Pesa STK Status Response: ' . json_encode($result));

            return [
                'success' => isset($result['ResultCode']) && $result['ResultCode'] == '0',
                'message' => $result['ResultDesc'] ?? 'Unknown response',
                'response' => $result
            ];
        } catch (\Exception $e) {
            Log::error('M-Pesa STK Status Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Exception occurred: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process B2C (Business to Customer) payment
     * 
     * @param string $phoneNumber Phone number to receive payment (format: 2547XXXXXXXX)
     * @param float $amount Amount to be paid
     * @param string $reference Transaction reference
     * @param string $remarks Transaction remarks
     * @return array|null
     */
    public function b2c($phoneNumber, $amount, $reference, $remarks)
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return [
                'success' => false,
                'message' => 'Unable to get access token from M-Pesa'
            ];
        }

        try {
            $b2cUrl = "{$this->baseUrl}/mpesa/b2c/v1/paymentrequest";
            $b2cShortCode = config('services.mpesa.b2c_short_code', $this->shortCode);
            $initiatorName = config('services.mpesa.initiator_name');
            $securityCredential = config('services.mpesa.security_credential');
            $b2cResultUrl = config('services.mpesa.b2c_result_url');
            $b2cTimeoutUrl = config('services.mpesa.b2c_timeout_url');

            $response = Http::withToken($accessToken)
                ->post($b2cUrl, [
                    'InitiatorName' => $initiatorName,
                    'SecurityCredential' => $securityCredential,
                    'CommandID' => 'BusinessPayment', // or 'SalaryPayment', 'PromotionPayment'
                    'Amount' => $amount,
                    'PartyA' => $b2cShortCode,
                    'PartyB' => $phoneNumber,
                    'Remarks' => $remarks,
                    'QueueTimeOutURL' => $b2cTimeoutUrl,
                    'ResultURL' => $b2cResultUrl,
                    'Occasion' => $reference
                ]);

            $result = $response->json();
            Log::info('M-Pesa B2C Response: ' . json_encode($result));

            if (isset($result['ResponseCode']) && $result['ResponseCode'] == '0') {
                return [
                    'success' => true,
                    'message' => 'B2C payment initiated successfully',
                    'conversation_id' => $result['ConversationID'] ?? null,
                    'originator_conversation_id' => $result['OriginatorConversationID'] ?? null,
                    'response' => $result
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $result['errorMessage'] ?? 'B2C payment failed',
                    'response' => $result
                ];
            }
        } catch (\Exception $e) {
            Log::error('M-Pesa B2C Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Exception occurred: ' . $e->getMessage()
            ];
        }
    }
} 
<?php

namespace App\Http\Controllers;

use Cloudinary\Api\ApiUtils;
use Cloudinary\Configuration\CloudConfig;
use Illuminate\Http\Request;

class CloudinaryController extends Controller
{
    public function generateSignature()
    {
        $cloudConfig = new CloudConfig([
            "cloud_name" => env('CLOUD_NAME'),
            "api_key" => env('CLOUD_API_KEY'),
            "api_secret" => env('CLOUD_API_SK')
        ]);
        $timestamp = time();
        $params =
            [
                "timestamp" => $timestamp,
                "folder" => 'Lithub'
            ];
        return response()->json(['signature' => ApiUtils::signParameters($params, $cloudConfig->apiSecret), 'timestamp' => $timestamp]);
    }
}

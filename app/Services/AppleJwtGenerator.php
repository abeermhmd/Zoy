<?php

namespace App\Services;

use Firebase\JWT\JWT;

class AppleJwtGenerator
{
    public static function generate()
    {
        $key_file = config('services.apple.auth_key');
        $key_id = config('services.apple.key_id');
        $team_id = config('services.apple.team_id');
        $client_id = config('services.apple.client_id');
        $privateKey = file_get_contents($key_file);

        $now = time();
        $exp = $now + 86400 * 180; // 180 days

        $payload = [
            'iss' => $team_id,
            'iat' => $now,
            'exp' => $exp,
            'aud' => 'https://appleid.apple.com',
            'sub' => $client_id,
        ];

        $headers = [
            'kid' => $key_id,
            'alg' => 'ES256'
        ];

        return JWT::encode($payload, $privateKey, 'ES256', null, $headers);
    }

    /**
     * Get the client secret from config, handling callable configs
     */
    public static function getClientSecret()
    {
        $clientSecret = config('services.apple.client_secret');
        return is_callable($clientSecret) ? $clientSecret() : $clientSecret;
    }
}

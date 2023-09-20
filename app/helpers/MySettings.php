<?php

namespace App\Helpers;

use App\ClientDomain;
use App\User;

//    use Illuminate\Support\Facades\Auth;
//    use Illuminate\Support\Facades\Session;

class MySettings {

    public static function secretHost($secretKey, $userId) {
        $users = User::where('id', '=', $userId)->first();
        $decryption_key = $users->decryption_key;
        $domainId = self::decryptToken($secretKey, $decryption_key);
        $clientDomain = ClientDomain::where('id', '=', $domainId)->first();
        $clientDomain = json_decode(json_encode($clientDomain), true);
        return $clientDomain;
    }
    
    public static function clientDomainData($secretKey, $decryption_key) {
        $domainId = self::decryptToken($secretKey, $decryption_key);
        $clientDomain = ClientDomain::where('id', '=', $domainId)->first();
        return $clientDomain;
    }

    public static function secretHostByUserId($userId) {
    
        $clientDomain = ClientDomain::where('user_id', '=', $userId)->get();
        $clientDomain = json_decode(json_encode($clientDomain), true);
        return $clientDomain;
    }

    /* public static function encrypt($simple_string, $userId) {
      $users = User::where('id', '=', $userId)->first();
      $simple_string .= '_'.$users->email;
      $ciphering = "AES-128-CTR";
      $iv_length = openssl_cipher_iv_length($ciphering);
      $options = 0;
      $encryption_iv = '1234567891011121';
      $encryption_key = $users->decryption_key;
      $encryption = openssl_encrypt($simple_string, $ciphering,
      $encryption_key, $options, $encryption_iv);
      return $encryption;
      }

      public static function decrypt($encryption, $userId) {
      $options = 0;
      $users = User::where('id', '=', $userId)->first();
      //$encryption .= $users->email;
      $decryption_iv = '1234567891011121';
      $ciphering = "AES-128-CTR";
      $decryption_key = $users->decryption_key;
      $decryption=openssl_decrypt ($encryption, $ciphering,
      $decryption_key, $options, $decryption_iv);
      return $decryption;
      } */

    public static function encryptToken($data, $passphrase) {
        $secret_key = hex2bin($passphrase);
       // echo $secret_key;die;
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted_64 = openssl_encrypt($data, 'aes-256-cbc', $secret_key, 0, $iv);
        $iv_64 = base64_encode($iv);
        $json = new \stdClass();
        $json->iv = $iv_64;
        $json->data = $encrypted_64;
        return base64_encode(json_encode($json));
    }

    public static function decryptToken($data, $passphrase) {
        $secret_key = hex2bin($passphrase);
        $json = json_decode(base64_decode($data));
        $iv = base64_decode($json->{'iv'});
        $encrypted_64 = $json->{'data'};
        $data_encrypted = base64_decode($encrypted_64);
        $decrypted = openssl_decrypt($data_encrypted, 'aes-256-cbc', $secret_key, OPENSSL_RAW_DATA, $iv);
        return $decrypted;
    }

}

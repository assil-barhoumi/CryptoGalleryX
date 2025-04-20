<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

class VigenereCipherService
{
    protected $key;

    public function __construct()
    {
        $this->key = Config::get('app.vigenere_key');
    }

    public function encrypt($plaintext)
    {
        $key = $this->key;
        $keyLength = strlen($key);
        $plaintextLength = strlen($plaintext);
        $ciphertext = '';

        for ($i = 0; $i < $plaintextLength; $i++) {
            $ciphertext .= chr(
                (ord($plaintext[$i]) + ord($key[$i % $keyLength])) % 256
            );
        }
        return $ciphertext;
    }

    public function decrypt($ciphertext)
    {
        $key = $this->key;
        $keyLength = strlen($key);
        $ciphertextLength = strlen($ciphertext);
        $plaintext = '';

        for ($i = 0; $i < $ciphertextLength; $i++) {
            $plaintext .= chr(
                (256 + ord($ciphertext[$i]) - ord($key[$i % $keyLength])) % 256
            );
        }
        return $plaintext;
    }
}

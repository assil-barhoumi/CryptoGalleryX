<?php

namespace App\Services;

class XORCipherService
{
    public function encrypt($plaintext, $key)
    {
        $ciphertext = '';
        for ($i = 0; $i < strlen($plaintext); $i++) {
            $ciphertext .= chr(ord($plaintext[$i]) ^ ord($key[$i % strlen($key)]));
        }
        return base64_encode($ciphertext); 
    }

    public function decrypt($ciphertext, $key)
    {
        $ciphertext = base64_decode($ciphertext);
        $plaintext = '';
        for ($i = 0; $i < strlen($ciphertext); $i++) {
            $plaintext .= chr(ord($ciphertext[$i]) ^ ord($key[$i % strlen($key)]));
        }
        return $plaintext;
    }
}

<?php

namespace App\Services;

class ReverseCipherService
{
  
    public function encryptDecrypt($text)
    {
        return strrev($text); 
    }
}

<?php
namespace App\Services;
class AtbashCipherService

{
    public function encrypt_decrypt($text)
    {
        $normalOrder = range('a', 'z');
        $inverseOrder = array_reverse($normalOrder);
        $transformedText = '';

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (ctype_alpha($char)) {
                $isUpper = ctype_upper($char);
                $char = strtolower($char);
                $indexText = array_search($char, $normalOrder);  //pos
                $transformedChar = $inverseOrder[$indexText];      // $normalOrder[25 - $indexText];
                $transformedText .= $isUpper ? strtoupper($transformedChar) : $transformedChar; //if else
            } else {
                $transformedText .= $char;
            }
        }

        return $transformedText;
    }
    
}
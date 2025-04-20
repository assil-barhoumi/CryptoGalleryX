<?php
namespace App\Services;
class CesarCipherService
{
    protected $shift;
    public function __construct($shift)
    {
        $this->shift = $shift;
    }
    public function encrypt($plaintext)
    {
    $pos='';
    $cyphertext='';
     for($i=0;$i<strlen($plaintext);$i++)               
      {
       $char=$plaintext[$i];
      if(ctype_alpha($char))
      {
          $isUpper=ctype_upper($char);
          $char=strtolower($char);
          $pos=ord($char)-ord('a');
          $cypherchar=chr(($pos+$this->shift)%26+ord('a'));
          $cyphertext.=$isUpper?strtoupper($cypherchar):$cypherchar;
        }
        else{
            $cyphertext.=$char;
        }
      }
    return $cyphertext;
    }
    public function decrypt($cyphertext)
    {
        $plaintext = '';
        for ($i = 0; $i < strlen($cyphertext); $i++) {
            $char = $cyphertext[$i];
            if (ctype_alpha($char)) {
                $isUpper = ctype_upper($char);
                $char = strtolower($char);
                $pos = ord($char) - ord('a');
                $decryptedPos = ($pos - $this->shift + 26) % 26;
                $plainchar = chr($decryptedPos + ord('a'));
                $plaintext .= $isUpper ? strtoupper($plainchar) : $plainchar;
            } else {
                $plaintext .= $char;
            }
        }
        return $plaintext;
    }
    
}

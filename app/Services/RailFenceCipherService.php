<?php

namespace App\Services;

class RailFenceCipherService
{
    public function encrypt($plaintext, $rails = 3)
    {
        $fence = array_fill(0, $rails, []);
        $rail = 0;
        $var = 1;

        foreach (str_split($plaintext) as $char) {
            $fence[$rail][] = $char;
            $rail += $var;
            if ($rail == 0 || $rail == $rails - 1) $var = -$var;
        }

        $result = '';
        foreach ($fence as $rail) {
            $result .= implode('', $rail);
        }
        return $result;
    }

    public function decrypt($ciphertext, $rails = 3)
    {
        $fence = array_fill(0, $rails, array_fill(0, strlen($ciphertext), null));
        $rail = 0; $var = 1;

        for ($i = 0; $i < strlen($ciphertext); $i++) {
            $fence[$rail][$i] = '*';
            $rail += $var;
            if ($rail == 0 || $rail == $rails - 1) $var = -$var;
        }

        $index = 0;
        for ($r = 0; $r < $rails; $r++) {
            for ($i = 0; $i < strlen($ciphertext); $i++) {
                if ($fence[$r][$i] === '*' && $index < strlen($ciphertext)) {
                    $fence[$r][$i] = $ciphertext[$index++];
                }
            }
        }

        $result = '';
        $rail = 0; $var = 1;
        for ($i = 0; $i < strlen($ciphertext); $i++) {
            $result .= $fence[$rail][$i];
            $rail += $var;
            if ($rail == 0 || $rail == $rails - 1) $var = -$var;
        }
        return $result;
    }
}

<?php

namespace App\Services;

class PlayfairCipherService
{
    protected $matrix = [];

    public function __construct($key = 'KEYWORD')
    {
        $this->generateMatrix($key);
    }

    
    protected function generateMatrix($key)
    {
        $alphabet = 'ABCDEFGHIKLMNOPQRSTUVWXYZ'; 
        $key = strtoupper(str_replace('J', 'I', $key));
        $key = preg_replace('/[^A-Z]/', '', $key);

        $matrixString = '';
        foreach (str_split($key . $alphabet) as $char) {
            if (strpos($matrixString, $char) === false) {
                $matrixString .= $char;
            }
        }

        $this->matrix = array_chunk(str_split($matrixString), 5);
    }

    
    public function encrypt($plaintext)
    {
        
        $matrix = [];
        $used = [];
        $key = 'KEYWORD'; 
        $keyBytes = array_unique(array_map('ord', str_split($key)));
        foreach ($keyBytes as $byte) {
            $matrix[] = $byte;
            $used[$byte] = true;
        }
        for ($i = 0; $i < 256; $i++) {
            if (!isset($used[$i])) {
                $matrix[] = $i;
            }
        }
        

        $ciphertext = '';
        $len = strlen($plaintext);
        for ($i = 0; $i < $len; $i += 2) {
            $a = ord($plaintext[$i]);
            $b = ($i + 1 < $len) ? ord($plaintext[$i + 1]) : 0;
            $posA = array_search($a, $matrix);
            $posB = array_search($b, $matrix);
            $rowA = intdiv($posA, 16); $colA = $posA % 16;
            $rowB = intdiv($posB, 16); $colB = $posB % 16;
            if ($rowA === $rowB) {
                
                $cipherA = $matrix[$rowA * 16 + (($colA + 1) % 16)];
                $cipherB = $matrix[$rowB * 16 + (($colB + 1) % 16)];
            } elseif ($colA === $colB) {
                
                $cipherA = $matrix[((($rowA + 1) % 16) * 16) + $colA];
                $cipherB = $matrix[((($rowB + 1) % 16) * 16) + $colB];
            } else {
                
                $cipherA = $matrix[$rowA * 16 + $colB];
                $cipherB = $matrix[$rowB * 16 + $colA];
            }
            $ciphertext .= chr($cipherA) . chr($cipherB);
        }
        return $ciphertext;
    }

    public function decrypt($ciphertext)
    {
        
        $matrix = [];
        $used = [];
        $key = 'KEYWORD'; 
        $keyBytes = array_unique(array_map('ord', str_split($key)));
        foreach ($keyBytes as $byte) {
            $matrix[] = $byte;
            $used[$byte] = true;
        }
        for ($i = 0; $i < 256; $i++) {
            if (!isset($used[$i])) {
                $matrix[] = $i;
            }
        }
        $plaintext = '';
        $len = strlen($ciphertext);
        for ($i = 0; $i < $len; $i += 2) {
            $a = ord($ciphertext[$i]);
            $b = ($i + 1 < $len) ? ord($ciphertext[$i + 1]) : 0;
            $posA = array_search($a, $matrix);
            $posB = array_search($b, $matrix);
            $rowA = intdiv($posA, 16); $colA = $posA % 16;
            $rowB = intdiv($posB, 16); $colB = $posB % 16;
            if ($rowA === $rowB) {
                $plainA = $matrix[$rowA * 16 + (($colA + 15) % 16)];
                $plainB = $matrix[$rowB * 16 + (($colB + 15) % 16)];
            } elseif ($colA === $colB) {
                $plainA = $matrix[((($rowA + 15) % 16) * 16) + $colA];
                $plainB = $matrix[((($rowB + 15) % 16) * 16) + $colB];
            } else {
                $plainA = $matrix[$rowA * 16 + $colB];
                $plainB = $matrix[$rowB * 16 + $colA];
            }
            $plaintext .= chr($plainA) . chr($plainB);
        }
        return $plaintext;
    }

    // Finds the position of a character in the matrix
    protected function findPosition($char)
    {
        foreach ($this->matrix as $row => $rowArr) {
            $col = array_search($char, $rowArr);
            if ($col !== false) {
                return [$row, $col];
            }
        }
        return [0, 0];
    }
}

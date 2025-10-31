<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;

class TripleEncryptionService
{
    private const CAESAR_SHIFT = 3;
    private const VIGENERE_KEY = 'SECRETKEY';

    /**
     * Enkripsi: Caesar -> Vigenere -> AES
     */
    public static function encrypt(string $plaintext): string
    {
        $step1 = self::caesarEncrypt($plaintext);
        $step2 = self::vigenereEncrypt($step1);
        $step3 = Crypt::encryptString($step2); // AES
        
        return $step3;
    }

    /**
     * Dekripsi: AES -> Vigenere -> Caesar
     */
    public static function decrypt(string $ciphertext): string
    {
        $step1 = Crypt::decryptString($ciphertext); // AES
        $step2 = self::vigenereDecrypt($step1);
        $step3 = self::caesarDecrypt($step2);
        
        return $step3;
    }

    /**
     * 1. Caesar Cipher - Enkripsi
     */
    private static function caesarEncrypt(string $text): string
    {
        $result = '';
        $length = strlen($text);
        
        for ($i = 0; $i < $length; $i++) {
            $char = $text[$i];
            $ascii = ord($char);
            
            // Uppercase letters
            if ($ascii >= 65 && $ascii <= 90) {
                $result .= chr((($ascii - 65 + self::CAESAR_SHIFT) % 26) + 65);
            }
            // Lowercase letters
            elseif ($ascii >= 97 && $ascii <= 122) {
                $result .= chr((($ascii - 97 + self::CAESAR_SHIFT) % 26) + 97);
            }
            // Other characters (unchanged)
            else {
                $result .= $char;
            }
        }
        
        return $result;
    }

    /**
     * Caesar Cipher - Dekripsi
     */
    private static function caesarDecrypt(string $text): string
    {
        $result = '';
        $length = strlen($text);
        
        for ($i = 0; $i < $length; $i++) {
            $char = $text[$i];
            $ascii = ord($char);
            
            // Uppercase letters
            if ($ascii >= 65 && $ascii <= 90) {
                $result .= chr((($ascii - 65 - self::CAESAR_SHIFT + 26) % 26) + 65);
            }
            // Lowercase letters
            elseif ($ascii >= 97 && $ascii <= 122) {
                $result .= chr((($ascii - 97 - self::CAESAR_SHIFT + 26) % 26) + 97);
            }
            // Other characters (unchanged)
            else {
                $result .= $char;
            }
        }
        
        return $result;
    }

    /**
     * Vigenere Cipher - Enkripsi
     */
    private static function vigenereEncrypt(string $text): string
    {
        $result = '';
        $keyLength = strlen(self::VIGENERE_KEY);
        $keyIndex = 0;
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            $ascii = ord($char);
            
            if (ctype_alpha($char)) {
                $keyChar = self::VIGENERE_KEY[$keyIndex % $keyLength];
                $keyShift = ord(strtoupper($keyChar)) - 65;
                
                // Uppercase letters
                if ($ascii >= 65 && $ascii <= 90) {
                    $result .= chr((($ascii - 65 + $keyShift) % 26) + 65);
                }
                // Lowercase letters
                elseif ($ascii >= 97 && $ascii <= 122) {
                    $result .= chr((($ascii - 97 + $keyShift) % 26) + 97);
                }
                
                $keyIndex++;
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }

    /**
     * Vigenere Cipher - Dekripsi
     */
    private static function vigenereDecrypt(string $text): string
    {
        $result = '';
        $keyLength = strlen(self::VIGENERE_KEY);
        $keyIndex = 0;
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            $ascii = ord($char);
            
            if (ctype_alpha($char)) {
                $keyChar = self::VIGENERE_KEY[$keyIndex % $keyLength];
                $keyShift = ord(strtoupper($keyChar)) - 65;
                
                // Uppercase letters
                if ($ascii >= 65 && $ascii <= 90) {
                    $result .= chr((($ascii - 65 - $keyShift + 26) % 26) + 65);
                }
                // Lowercase letters
                elseif ($ascii >= 97 && $ascii <= 122) {
                    $result .= chr((($ascii - 97 - $keyShift + 26) % 26) + 97);
                }
                
                $keyIndex++;
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }
}
<?php

namespace App\Http\Controllers;

use App\Services\TripleEncryptionService;
use Illuminate\Http\Request;

class TestEncryptionController extends Controller
{
    /**
     * Halaman untuk testing enkripsi
     */
    public function index()
    {
        return view('test-encryption');
    }

    /**
     * Proses testing enkripsi dan dekripsi
     */
    public function test(Request $request)
    {
        $password = $request->input('password', 'MyPassword123');
        
        // Langkah demi langkah enkripsi
        $step1_caesar = $this->caesarEncrypt($password);
        $step2_vigenere = $this->vigenereEncrypt($step1_caesar);
        $step3_aes = $this->aesEncrypt($step2_vigenere);
        
        // Enkripsi lengkap (langsung pakai service)
        $fullEncrypted = TripleEncryptionService::encrypt($password);
        
        // Dekripsi lengkap
        $decrypted = TripleEncryptionService::decrypt($fullEncrypted);
        
        return view('test-encryption', [
            'password' => $password,
            'tested' => true,
            
            // Hasil enkripsi per step
            'step1_caesar' => $step1_caesar,
            'step2_vigenere' => $step2_vigenere,
            'step3_aes' => $step3_aes,
            'full_encrypted' => $fullEncrypted,
            
            // Hasil dekripsi
            'decrypted' => $decrypted,
            'is_match' => $password === $decrypted
        ]);
    }
    
    // Copy method dari TripleEncryptionService untuk testing
    private function caesarEncrypt($text)
    {
        $result = '';
        $shift = 3;
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            $ascii = ord($char);
            
            if ($ascii >= 65 && $ascii <= 90) {
                $result .= chr((($ascii - 65 + $shift) % 26) + 65);
            } elseif ($ascii >= 97 && $ascii <= 122) {
                $result .= chr((($ascii - 97 + $shift) % 26) + 97);
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }
    
    private function vigenereEncrypt($text)
    {
        $result = '';
        $key = 'SECRETKEY';
        $keyLength = strlen($key);
        $keyIndex = 0;
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            $ascii = ord($char);
            
            if (ctype_alpha($char)) {
                $keyChar = $key[$keyIndex % $keyLength];
                $keyShift = ord(strtoupper($keyChar)) - 65;
                
                if ($ascii >= 65 && $ascii <= 90) {
                    $result .= chr((($ascii - 65 + $keyShift) % 26) + 65);
                } elseif ($ascii >= 97 && $ascii <= 122) {
                    $result .= chr((($ascii - 97 + $keyShift) % 26) + 97);
                }
                
                $keyIndex++;
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }
    
    private function aesEncrypt($text)
    {
        return \Illuminate\Support\Facades\Crypt::encryptString($text);
    }
}
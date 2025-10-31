<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Enkripsi 3 Layer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
        }
        
        .result-section {
            margin-top: 30px;
        }
        
        .step {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
        }
        
        .step-title {
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .step-content {
            background: white;
            padding: 12px;
            border-radius: 6px;
            word-break: break-all;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #333;
            border: 1px solid #e0e0e0;
        }
        
        .arrow {
            text-align: center;
            color: #667eea;
            font-size: 24px;
            margin: 10px 0;
            font-weight: bold;
        }
        
        .final-result {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #667eea;
        }
        
        .success {
            color: #28a745;
            font-weight: bold;
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            padding: 15px;
            background: #d4edda;
            border-radius: 8px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 10px;
            background: #667eea;
            color: white;
            border-radius: 12px;
            font-size: 11px;
            margin-left: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Test Enkripsi 3 Layer</h1>
        <p class="subtitle">Caesar → Vigenere → AES</p>
        
        <form method="POST" action="{{ route('test.encryption.process') }}">
            @csrf
            <div class="form-group">
                <label for="password">Masukkan Password untuk di Test:</label>
                <input type="text" id="password" name="password" 
                       value="{{ $password ?? 'MyPassword123' }}" 
                       placeholder="Contoh: MyPassword123">
            </div>
            
            <button type="submit">🚀 Test Enkripsi & Dekripsi</button>
        </form>
        
        @if(isset($tested) && $tested)
        <div class="result-section">
            <h2 style="margin-bottom: 20px; color: #333;">📊 Hasil Testing</h2>
            
            <!-- Original Password -->
            <div class="step">
                <div class="step-title">📝 Password Asli</div>
                <div class="step-content">{{ $password }}</div>
            </div>
            
            <div class="arrow">↓</div>
            
            <!-- Step 1: Caesar -->
            <div class="step">
                <div class="step-title">
                    🔤 Step 1: Caesar Cipher <span class="badge">Shift 3</span>
                </div>
                <div class="step-content">{{ $step1_caesar }}</div>
                <p style="margin-top: 8px; font-size: 12px; color: #666;">
                    <i>Setiap huruf digeser 3 posisi: A→D, B→E, C→F, dst</i>
                </p>
            </div>
            
            <div class="arrow">↓</div>
            
            <!-- Step 2: Vigenere -->
            <div class="step">
                <div class="step-title">
                    🔑 Step 2: Vigenere Cipher <span class="badge">Key: SECRETKEY</span>
                </div>
                <div class="step-content">{{ $step2_vigenere }}</div>
                <p style="margin-top: 8px; font-size: 12px; color: #666;">
                    <i>Enkripsi dengan kunci "SECRETKEY" yang berulang</i>
                </p>
            </div>
            
            <div class="arrow">↓</div>
            
            <!-- Step 3: AES -->
            <div class="step">
                <div class="step-title">
                    🛡️ Step 3: AES-256-CBC <span class="badge">Laravel Crypt</span>
                </div>
                <div class="step-content">{{ $step3_aes }}</div>
                <p style="margin-top: 8px; font-size: 12px; color: #666;">
                    <i>Enkripsi tingkat tinggi dengan AES-256-CBC menggunakan APP_KEY</i>
                </p>
            </div>
            
            <div class="arrow">↓</div>
            
            <!-- Final Encrypted -->
            <div class="final-result">
                <div class="step-title">✅ Hasil Enkripsi Final (Disimpan di Database)</div>
                <div class="step-content">{{ $full_encrypted }}</div>
            </div>
            
            <div class="arrow" style="transform: rotate(180deg);">↓</div>
            
            <!-- Decrypted Result -->
            <div class="final-result">
                <div class="step-title">🔓 Hasil Dekripsi (Kembali ke Password Asli)</div>
                <div class="step-content">{{ $decrypted }}</div>
            </div>
            
            @if($is_match)
                <div class="success">
                    ✅ SUKSES! Password berhasil di-enkripsi dan di-dekripsi dengan benar!
                </div>
            @else
                <div style="color: #dc3545; text-align: center; margin-top: 20px;">
                    ❌ ERROR! Ada kesalahan dalam proses enkripsi/dekripsi
                </div>
            @endif
        </div>
        @endif
    </div>
</body>
</html>
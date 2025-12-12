<?php

namespace App\Console\Commands;

use App\Models\Pasien;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EncryptExistingPasienData extends Command
{
    protected $signature = 'pasien:encrypt-data';
    protected $description = 'Encrypt existing pasien alamat and umur data';

    public function handle()
    {
        $this->info('🔐 Starting encryption process...');
        
        // Ambil semua pasien yang belum terenkripsi
        $pasiens = DB::table('pasiens')->get();
        $encrypted = 0;
        $skipped = 0;

        foreach ($pasiens as $pasien) {
            try {
                // Cek apakah sudah terenkripsi (coba decrypt)
                if ($pasien->alamat) {
                    try {
                        Crypt::decryptString($pasien->alamat);
                        $this->warn("Pasien ID {$pasien->id} alamat already encrypted, skipping...");
                        $skipped++;
                        continue;
                    } catch (\Exception $e) {
                        // Belum terenkripsi, lanjutkan
                    }
                }

                // Encrypt data
                DB::table('pasiens')
                    ->where('id', $pasien->id)
                    ->update([
                        'alamat' => $pasien->alamat ? Crypt::encryptString($pasien->alamat) : null,
                        'umur' => $pasien->umur ? Crypt::encryptString($pasien->umur) : null,
                    ]);

                $encrypted++;
                $this->info("✅ Encrypted pasien ID: {$pasien->id}");
                
            } catch (\Exception $e) {
                $this->error("❌ Failed to encrypt pasien ID {$pasien->id}: " . $e->getMessage());
            }
        }

        $this->info("
🎉 Encryption completed!");
        $this->info("✅ Encrypted: {$encrypted} records");
        $this->info("⏭️  Skipped: {$skipped} records (already encrypted)");
        
        return 0;
    }
}
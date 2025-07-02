<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeleteExpiredOtps extends Command
{
    protected $signature = 'otp:delete-expired';
    protected $description = 'Supprime les OTP expirés de la table otp_verifications';

    public function handle()
    {
        $expirationTime = Carbon::now()->subMinutes(5);

        DB::table('otp_verifications')
            ->where('created_at', '<', $expirationTime)
            ->delete();

        $this->info('OTP expirés supprimés avec succès.');
    }
}

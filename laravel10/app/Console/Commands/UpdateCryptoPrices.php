<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCryptoPrices extends Command
{
    protected $signature = 'crypto:update-prices';
    protected $description = 'Génère aléatoirement les cours des cryptomonnaies';

    public function handle()
    {
        // Récupération des cryptomonnaies
        $cryptos = DB::table('cours_cryptomonnaies')->get();

        foreach ($cryptos as $crypto) {
            // Générer un pourcentage de variation entre -5% et +5%
            $variation = mt_rand(-500, 500) / 10000;

            // Calcul du nouveau prix
            $nouveauPrix = $crypto->prix * (1 + $variation);

            // Mise à jour du cours
            DB::table('cours_cryptomonnaies')
                ->where('id', $crypto->id)
                ->update([
                    'prix' => round($nouveauPrix, 8),
                    'updated_at' => now(),
                ]);
        }

        $this->info('Les cours des cryptomonnaies ont été mis à jour.');
    }
}

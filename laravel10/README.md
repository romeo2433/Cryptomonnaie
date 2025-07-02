1-Installation composer
    Cliquer sur Composer-Setup.exe

2-COMMANDE POUR LA CONFIGURATION DATABASE
    composer require illuminate/database
    composer require doctrine/dbal
3-COMMANDE POUR INSTALLE OUTILS DE DEBUG
    composer require barryvdh/laravel-debugbar --dev

4-OUVRIR TERMINAL postgres 
create database NOM DATABASE: cloud 

5-Makany am chemin misy an ilay base
    php artisan migrate --path=/database/migrations/2025_01_09_181541_create__cryptomonnaies_table.php
    php artisan migrate
n.b:rAHA SANATRIA MISY MI FAILD DIA DIA ITO COMMANDE MAMERINA ILAY BASE 
    php artisan migrate:rollback

6-Inserer la valeur 
    
    INSERT INTO cryptomonnaies (nom, symbole, description) 
        VALUES
            ('Bitcoin', 'BTC', 'La première cryptomonnaie, créée en 2009.'),
            ('Ethereum', 'ETH', 'Une plateforme décentralisée permettant la création de contrats intelligents.'),
            ('Ripple', 'XRP', 'Une cryptomonnaie visant à faciliter les paiements internationaux.'),
            ('Litecoin', 'LTC', 'Une cryptomonnaie de pair à pair inspirée du Bitcoin, mais plus rapide dans le traitement des transactions.');

    INSERT INTO cours_cryptomonnaies (cryptomonnaie_id, prix) VALUES
            (1, 30000.00),  -- Prix de Bitcoin en USD
            (2, 20000.00),   -- Prix d'Ethereum en USD
            (3, 10000.00),      -- Prix de Ripple en USD
            (4, 5000.00);


7-Lancement 
    START.BAT

        http://127.0.0.1:8000/login pour utlisateur 
        http://127.0.0.1:8000/admin/login pour Admin
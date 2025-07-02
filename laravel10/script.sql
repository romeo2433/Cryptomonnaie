-- Création de la table des rôles
CREATE TABLE roles (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,  -- 'admin', 'user'
    description TEXT
);

-- Insertion des rôles de base (admin, user)


-- Création de la table des users
CREATE TABLE users (
    id SERIAL PRIMARY KEY,                       -- Clé primaire auto-incrémentée
    name VARCHAR(255) NOT NULL,                   -- Colonne pour le nom de l'utilisateur
    email VARCHAR(255) UNIQUE NOT NULL,           -- Colonne pour l'email, unique
    email_verified_at TIMESTAMP NULL,             -- Colonne pour la vérification de l'email
    password VARCHAR(255) NOT NULL,               -- Colonne pour le mot de passe
    remember_token VARCHAR(100) NULL,             -- Colonne pour le token de rappel (cookie)
    role_id INT,                                  -- Colonne pour l'ID du rôle
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Colonne pour la date de création
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Colonne pour la date de mise à jour
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL  -- Clé étrangère vers la table des rôles
);

INSERT INTO roles (name, description) VALUES
('admin', 'Administrateur du site'),
('user', 'Utilisateur classique');


-- Vous pouvez ajouter d'autres colonnes à votre table `users` selon vos besoins.
INSERT INTO users (name, email, email_verified_at, password, remember_token, created_at, updated_at)
VALUES
    ('Joshua', 'Joshua@example.com', '2024-12-17 10:00:00', 'hashed_password_here', 'remember_token_here', '2024-12-17 10:00:00', '2024-12-17 10:00:00'),
    ('Tsanta', 'Tsanta@example.com', NULL, 'hashed_password_here', 'remember_token_here', '2024-12-17 10:00:00', '2024-12-17 10:00:00');



---------------------------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE users (
    id SERIAL PRIMARY KEY,                       -- Clé primaire auto-incrémentée
    name VARCHAR(255) NOT NULL,                   -- Colonne pour le nom de l'utilisateur
    email VARCHAR(255) UNIQUE NOT NULL,           -- Colonne pour l'email, unique
    email_verified_at TIMESTAMP NULL,             -- Colonne pour la vérification de l'email
    password VARCHAR(255) NOT NULL,               -- Colonne pour le mot de passe
    remember_token VARCHAR(100) NULL,             -- Colonne pour le token de rappel (cookie)
    role_id INT,                                  -- Colonne pour l'ID du rôle
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Colonne pour la date de création
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Colonne pour la date de mise à jour
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL  -- Clé étrangère vers la table des rôles
);


CREATE TABLE portefeuilles (
    idPortefeuilles SERIAL PRIMARY KEY,
    id INT REFERENCES users(id) ON DELETE CASCADE,
    solde DECIMAL(20, 8) DEFAULT 0.0,  -- Solde en cryptomonnaie
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_maj TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cryptomonnaies (
    idCryptomonnaies SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    symbole VARCHAR(10) NOT NULL UNIQUE,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_maj TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

 php artisan migrate --path=/database/migrations/2025_01_09_181541_create__cryptomonnaies_table.php


CREATE TABLE cours_cryptomonnaies (
    idCours_cryptomonnaies SERIAL PRIMARY KEY,
    cryptomonnaie_id INT REFERENCES cryptomonnaies(id),
    prix DECIMAL(20, 8) NOT NULL,  -- Le prix actuel de la cryptomonnaie
    date_maj TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);








CREATE TABLE transactions (
    idTransactions SERIAL PRIMARY KEY,
    id INT REFERENCES users(id) ON DELETE CASCADE,
    type VARCHAR(20) NOT NULL,  -- "achat", "vente", "depot", "retrait"
    cryptomonnaie_id INT REFERENCES cryptomonnaies(id),
    montant DECIMAL(20, 8) NOT NULL,  -- Montant de la cryptomonnaie
    prix DECIMAL(20, 8) NOT NULL,    -- Prix de la cryptomonnaie au moment de la transaction
    date_transaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE verifications_email (
    idVerifications_email SERIAL PRIMARY KEY,
    id INT REFERENCES users(id) ON DELETE CASCADE,
    token VARCHAR(255) NOT NULL,  -- Le token envoyé par email
    est_verifie BOOLEAN DEFAULT FALSE,
    expiration TIMESTAMP,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE evenements_portefeuille (
    idEvenements_portefeuille SERIAL PRIMARY KEY,
    id INT REFERENCES users(id) ON DELETE CASCADE,
    type_evenement VARCHAR(50) NOT NULL,  -- "depot", "retrait"
    montant DECIMAL(20, 8) NOT NULL,  -- Montant en cryptomonnaie ou en monnaie réelle
    statut VARCHAR(20) NOT NULL,      -- "en_attente", "termine"
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE logs (
    idLogs SERIAL PRIMARY KEY,
    action VARCHAR(255) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE achats_cryptomonnaies (
    id SERIAL PRIMARY KEY, -- Identifiant unique de l'achat
    user_id INT NOT NULL, -- ID de l'utilisateur ayant effectué l'achat
    cryptomonnaie_id INT NOT NULL, -- ID de la cryptomonnaie achetée
    quantite DECIMAL(20, 8) NOT NULL, -- Quantité de cryptomonnaie achetée
    montant_usd DECIMAL(20, 2) NOT NULL, -- Montant total en USD utilisé pour l'achat
    prix_unitaire DECIMAL(20, 8) NOT NULL, -- Prix unitaire de la cryptomonnaie lors de l'achat
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date et heure de l'achat
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Date et heure de la dernière mise à jour
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Lien avec la table des utilisateurs
    FOREIGN KEY (cryptomonnaie_id) REFERENCES cryptomonnaies(id) ON DELETE CASCADE -- Lien avec la table des cryptomonnaies
);


CREATE TABLE admins (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);



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



INSERT INTO portefeuilles (user_id, solde, created_at, updated_at) VALUES (1, 54000, NOW(), NOW());
INSERT INTO portefeuilles (user_id, solde, created_at, updated_at) VALUES (3, 54000, NOW(), NOW());



INSERT INTO transactions (user_id, type_transaction, cryptomonnaie_id, montant, prix)
VALUES
(1, 'achat', 1, 0.05, 45000.00),
(1, 'vente', 2, 0.1, 3000.00),
(1, 'retrait', 3, 0.1, 3000.00),
(1, 'depot', 3, 0.25, 150.00);



INSERT INTO evenements_portefeuille (user_id, type_evenement, montant, statut)
VALUES
(1, 'depot', 1000.00, 'termine'),
(1, 'retrait', 500.00, 'en_attente'),
(1, 'retrait', 500.00, 'en_attente'),
(1, 'depot', 1500.00, 'termine');


INSERT INTO evenements_portefeuille (user_id, type_evenement, montant, statut)
VALUES
(1, 'depot', 0.5, 'termine'),
(1, 'retrait', 0.3, 'en_attente'),
(1, 'depot', 1.0, 'termine'),
(1, 'retrait', 0.2, 'en_attente');




INSERT INTO logs (action) 
VALUES
('Utilisateur Romeo a créé un compte'),
('Utilisateur Antsa a effectué un dépôt de 1000.00'),
('Utilisateur Romeo a acheté du Bitcoin');


listes des affichages de s achats 
SELECT 
    t.user_id,
    c.nom AS cryptomonnaie_nom,
    t.quantite,
    t.montant,
    t.created_at AS date_achat
FROM 
    transactions t
JOIN 
    cryptomonnaies c ON t.cryptomonnaie_id = c.id
ORDER BY 
    t.created_at DESC;






SELECT cryptomonnaie_id, 
       SUM(quantite) AS total_quantite, 
       SUM(montant) AS total_montant
FROM transactions
GROUP BY cryptomonnaie_id;

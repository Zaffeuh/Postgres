CREATE TABLE IF NOT EXISTS citoyens (
            id SERIAL PRIMARY KEY,
            nci VARCHAR(20) UNIQUE NOT NULL,
            nom VARCHAR(100) NOT NULL,
            prenom VARCHAR(100) NOT NULL,
            date_naissance DATE NOT NULL,
            lieu_naissance VARCHAR(255) NOT NULL,
            url_recto TEXT NOT NULL,
            url_verso TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );


 CREATE TABLE IF NOT EXISTS journal (
            id SERIAL PRIMARY KEY,
            nci_recherche VARCHAR(20) NOT NULL,
            ip VARCHAR(45) NOT NULL,
            localisation VARCHAR(255),
            statut VARCHAR(20) NOT NULL CHECK (statut IN ('success', 'error')),
            message TEXT,
            date_recherche TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );


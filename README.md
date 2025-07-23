# AppDAF

Application web PHP avec PostgreSQL et NGINX utilisant Docker.

##  Technologies utilisées

- **PHP** : Langage de programmation principal
- **PostgreSQL** : Base de données
- **NGINX** : Serveur web
- **Docker** : Conteneurisation

##  Prérequis

- Docker (version 20.10+)
- Docker Compose (version 2.0+)

##  Installation

1. **Cloner le projet**
```bash
git clone https://github.com/papesembene/AppDaf.git
cd AppDaf
```

2. **Créer le fichier d'environnement**
```bash
cp .env.example .env
```

3. **Lancer l'application**
```bash
docker-compose up -d --build
```

4. **Vérifier que les services sont actifs**
```bash
docker-compose ps
```

##  Accès à l'application

- **Application web** : http://localhost
- **Base de données PostgreSQL** : 
  - Host: localhost
  - Port: 5432
  - Database: appdafdb
  - User: appdaf
  - Password: password

##  Structure du projet

```
AppDAF/
├── .docker/
│   ├── nginx/
│   │   └── default.conf
│   └── php/
│       └── Dockerfile
├── docker-compose.yml
├── .env.example
├── .gitignore
└── README.md
```

##  Commandes utiles

### Gestion des conteneurs
```bash
# Démarrer l'application
docker-compose up -d

# Démarrer avec reconstruction des images
docker-compose up -d --build

# Arrêter l'application
docker-compose down

# Redémarrer un service spécifique
docker-compose restart nginx
```

### Logs et debugging
```bash
# Voir tous les logs
docker-compose logs -f

# Voir les logs d'un service spécifique
docker-compose logs -f appdaf
docker-compose logs -f db
docker-compose logs -f nginx

# Voir le statut des services
docker-compose ps
```

### Base de données
```bash
# Se connecter à PostgreSQL
docker-compose exec db psql -U appdaf -d appdafdb

# Sauvegarder la base de données
docker-compose exec db pg_dump -U appdaf appdafdb > backup.sql

# Restaurer la base de données
docker-compose exec -T db psql -U appdaf -d appdafdb < backup.sql
```

### Développement
```bash
# Accéder au conteneur PHP
docker-compose exec appdaf bash

# Redémarrer PHP-FPM
docker-compose exec appdaf service php8.1-fpm restart
```

##  Configuration d'environnement

Créez un fichier `.env` basé sur `.env.example` :

```env
POSTGRES_DB=appdafdb
POSTGRES_USER=appdaf
POSTGRES_PASSWORD=password
```

##  Dépannage

### Problèmes courants


2. **Problèmes de permissions**
```bash
# Donner les bonnes permissions
sudo chown -R $USER:$USER .
```

3. **Nettoyer Docker**
```bash
# Supprimer les conteneurs arrêtés
docker-compose down --volumes

# Nettoyer le système Docker
docker system prune -a
```

##  Développement

### Ajouter de nouvelles dépendances PHP
```bash
# Si vous utilisez Composer
docker-compose exec appdaf composer install
docker-compose exec appdaf composer require package-name
```

### Modifier la configuration NGINX
Éditez le fichier `.docker/nginx/default.conf` puis redémarrez :
```bash
docker-compose restart nginx
```

## Contribution

1. Fork le projet
2. Créez votre branche (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Committez vos changements (`git commit -am 'Ajout nouvelle fonctionnalité'`)
4. Push vers la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. Ouvrez une Pull Request


##  Auteur

**Pape Sembene**
- GitHub: [@papesembene](https://github.com/papesembene)



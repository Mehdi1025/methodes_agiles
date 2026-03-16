# 📦 Système de Gestion de Colis

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)
![Docker](https://img.shields.io/badge/Docker-Sail-2496ED?style=flat-square&logo=docker)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)

> **Application intelligente de suivi et gestion de stocks** — Projet universitaire · Méthodes Agiles

---

## 🚀 Installation en une commande (Docker Sail)

**Prérequis :** Docker Desktop installé et démarré.

> ⚠️ **Première fois ?** Si `docker-compose.yml` n'existe pas, exécutez d'abord :
> ```bash
> ./vendor/bin/sail artisan sail:install
> ```
> (Choisissez MySQL, Redis si souhaité, puis validez les options par défaut)

```bash
bash start.sh
```

C'est tout. Le script va :

1. 🐳 Lancer les containers Sail
2. 📦 Installer les dépendances PHP (Composer)
3. 🔑 Générer la clé d'application
4. 🗄️ Créer les tables et insérer les données de test
5. 🎨 Compiler les assets (npm install + build)

**L'application sera accessible sur :** [http://localhost](http://localhost)

---

## 👤 Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| **Admin** | `admin@entrepots.com` | `password` |
| **Magasinier** | `magasinier@entrepots.com` | `password` |
| **Logistique 1** | `logistique1@entrepots.com` | `password` |
| **Logistique 2** | `logistique2@entrepots.com` | `password` |

---

## ✨ Fonctionnalités

- **📊 Tableau de bord** — Vue d'ensemble et indicateurs clés
- **📦 Colis** — Gestion complète avec Smart Scanner (réception par code-barres)
- **🚚 Quais d'Expédition** — Validation des départs par transporteur
- **📋 Pick & Pack** — Missions de picking avec signalement d'anomalies
- **⌘ Command Palette** — Recherche rapide (Ctrl+K) pour les magasiniers
- **🤖 Assistant IA** — LogisBot avec données temps réel (Ollama / Mistral)

---

## 🛠️ Commandes utiles

```bash
# Arrêter les containers
./vendor/bin/sail down

# Relancer les containers
./vendor/bin/sail up -d

# Voir les logs
./vendor/bin/sail logs -f

# Accéder au shell du container
./vendor/bin/sail shell
```

---

## 📋 Configuration .env (Sail)

Le fichier `.env.example` est préconfiguré pour Docker Sail :

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_USERNAME=sail
DB_PASSWORD=password
DB_DATABASE=methode_agile
```

Pour une installation **sans Docker**, modifiez `DB_HOST=127.0.0.1` et vos identifiants MySQL.

---

## 🏗️ Équipe

Mahdi · Mohammed · Matteo — Méthodes Agiles (Phase 1)

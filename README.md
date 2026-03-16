# 📦 Système de Gestion de Stock

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)
![Docker](https://img.shields.io/badge/Docker-Sail-2496ED?style=flat-square&logo=docker)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)

---

## 📋 Présentation

Application intelligente de **gestion de stock** avec **IA locale** (Ollama / Mistral). Suivi des colis, réception par scanner, quais d'expédition, missions de picking et assistant conversationnel LogisBot — le tout tournant sur votre machine.

> Projet universitaire · Méthodes Agiles

---

## ⚙️ Prérequis

- **Docker Desktop** installé et démarré
- **WSL2** activé sur Windows (recommandé pour Sail)

---

## 🚀 Installation rapide (4 étapes)

### 1. Cloner le projet

```bash
git clone <url-du-repo> methode_agile
cd methode_agile
```

### 2. Créer le fichier d'environnement

```bash
cp .env.example .env
```

### 3. Installer Sail (première fois uniquement)

```bash
docker run --rm -v $(pwd):/var/www/html -w /var/www/html laravelsail/php83-composer:latest composer install
```

### 4. Lancer les containers

```bash
./vendor/bin/sail up -d
```

---

## 🤖 Configuration IA (Ollama)

L'assistant LogisBot utilise **Ollama** en local. Pour l'activer :

1. **Installez et lancez Ollama** sur Windows : [ollama.ai](https://ollama.ai)
2. Installez le modèle Mistral : `ollama pull mistral`
3. L'URL `http://host.docker.internal:11434` est déjà configurée dans `.env.example` — le container Sail communique ainsi avec Ollama sur votre machine Windows.

Aucune modification nécessaire si vous utilisez le `.env` par défaut.

---

## 🗄️ Base de données

Pour créer les tables et charger les **50 données de test** (colis, clients, transporteurs, emplacements) :

```bash
./vendor/bin/sail artisan migrate --seed
```

Pour repartir de zéro (réinitialisation complète) :

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

---

## 🌐 Accès

| Service | URL / Port |
|---------|------------|
| **Application** | [http://localhost](http://localhost) |
| **Base de données MySQL** | `localhost:3308` (ou `3306` selon `FORWARD_DB_PORT`) |

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

## 🏗️ Équipe

Mahdi · Mohammed · Matteo — Méthodes Agiles (Phase 1)

# 📦 Système de Gestion de Colis

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)

> **Application intelligente de suivi et gestion de stocks** — Projet universitaire · Méthodes Agiles (Phase 1)

---

## 📋 Description

Le **Système de Gestion de Colis** est un outil centralisant les opérations logistiques d'un entrepôt. Il permet une **traçabilité en temps réel** des colis, de la réception à la livraison, et intègre un **assistant IA embarqué** (Ollama / Mistral) pour optimiser les processus et répondre aux requêtes des opérateurs.

Développé dans le cadre du cours « Méthodes Agiles », ce projet démontre l'application des pratiques agiles en développement logiciel.

**Équipe :** Mahdi · Mohammed · Matteo

---

## ✨ Fonctionnalités Principales

- **📊 Tableau de bord** — Vue d'ensemble des opérations et indicateurs clés
- **📦 CRUD Colis** — Création, consultation, modification et suppression des colis
- **👥 CRUD Clients** — Gestion des clients et de leurs informations de livraison
- **🚚 CRUD Transporteurs** — Gestion des transporteurs partenaires
- **📜 Traçabilité & Historique** — Suivi des mouvements et changements de statut en temps réel
- **🤖 Assistant IA local** — Optimisation et assistance via Ollama / Mistral (LLM embarqué)

---

## 🔧 Prérequis

Avant de lancer le projet, assurez-vous d'avoir les logiciels suivants installés sur votre machine :

| Logiciel | Version minimale |
|----------|------------------|
| **PHP** | 8.2+ |
| **Composer** | 2.x |
| **Node.js** | 18+ |//////////////////////////
| **MySQL** | 8.0+ / 10.6+ |
| **Ollama** | (pour l'assistant IA) |

---

## 🚀 Installation Locale

Suivez ces étapes pour configurer le projet sur votre machine.

### 1️⃣ Cloner le dépôt

```bash
git clone https://github.com/Mehdi1025/methodes_agiles.git
cd methodes_agiles
```

### 2️⃣ Installer les dépendances PHP

```bash
composer install
```

### 3️⃣ Configurer l'environnement

```bash
cp .env.example .env
```

Ouvrez le fichier `.env` et configurez vos accès à la base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=methodes_agiles
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

### 4️⃣ Générer la clé d'application

```bash
php artisan key:generate
```

### 5️⃣ Créer la base de données et la peupler

```bash
php artisan migrate:fresh --seed
```

> Cette commande crée toutes les tables et insère les données de test (utilisateurs, clients, transporteurs, emplacements, colis).

///////////////////////////### 6️⃣ Installer les dépendances frontend et compiler les assets

```bash
npm install
npm run dev
```

> Gardez `npm run dev` actif dans un terminal pour le hot-reload des assets.

### 7️⃣ Lancer le serveur Laravel

Dans un **nouveau terminal** :

```bash
php artisan serve
```

L'application sera accessible à l'adresse : **http://localhost:8000**

---

## 👤 Comptes de test (Seeders)

Les identifiants suivants sont générés par défaut pour tester l'application :

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| **Admin** | `admin@entrepots.com` | `password` |
| **Logistique 1** | `logistique1@entrepots.com` | `password` |
| **Logistique 2** | `logistique2@entrepots.com` | `password` |

---

## 🏗️ Architecture

L'application suit le **pattern MVC** (Model-View-Controller) de Laravel :

- **Models** — Entités métier (Client, Colis, Transporteur, Emplacement, HistoriqueMouvement)
- **Views** — Interfaces utilisateur (Blade + Tailwind CSS)
- **Controllers** — Logique applicative et orchestration des requêtes

La base de données utilise des **UUIDs** pour les clés primaires des principales entités, garantissant unicité et traçabilité.

---

## 📄 Licence

Projet universitaire — Méthodes Agiles (Phase 1)

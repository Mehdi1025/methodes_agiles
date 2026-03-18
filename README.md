<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/Docker-Sail-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker Sail" />
  <img src="https://img.shields.io/badge/AI-Ollama_%7C_Llama_3.2-000000?style=for-the-badge&logo=ollama&logoColor=white" alt="Ollama AI" />
</p>

<h1 align="center">📦 WMS Agile</h1>
<p align="center">
  <strong>Warehouse Management System</strong> — Gestion intelligente d'entrepôt avec IA locale
</p>

<p align="center">
  <em>Projet universitaire · Méthodes Agiles</em>
</p>

---

## 🎯 Description

**WMS Agile** est une application de gestion de stock et de flux logistiques, conçue pour les entrepôts modernes. Elle combine un tableau de bord temps réel, un assistant IA conversationnel (**LogisBot**), des alertes automatiques sur les colis en retard (**Watchdog**), et une réception par scan de QR Codes — le tout tournant en local avec **Ollama** et **Llama 3.2 1B**.

> 🚀 100 % open-source · Pas de cloud obligatoire · Données sur votre machine

---

## ✨ Fonctionnalités clés

| Fonctionnalité | Description |
|----------------|-------------|
| 🐕 **Watchdog** | Alerte automatique sur les colis en souffrance : statut ni livré, ni expédié, ni anomalie, créés il y a plus de 24 h. Badges dans la sidebar, bandeau sur les dashboards, actions rapides (Expédier / Anomalie). |
| 🤖 **LogisBot** | Assistant IA avec **Llama 3.2 1B** via Ollama. **Routeur d'intentions PHP** : salutations, statistiques et hors-sujet gérés sans appeler le LLM. Réponses en français, données temps réel de l'entrepôt. |
| 📱 **QR Codes** | Génération SVG (SimpleSoftwareIO/simple-qrcode), scan caméra pour réception rapide, création de colis par code-barres. |
| 📊 **Tableau de bord** | Vue d'ensemble, indicateurs clés, flux par statut, activité récente. |
| 🚚 **Quais d'expédition** | Validation des départs par transporteur, suivi des colis en cours. |
| 📋 **Pick & Pack** | Missions de picking avec signalement d'anomalies. |
| ⌘ **Command Palette** | Recherche rapide (Ctrl+K) pour les magasiniers. |

---

## 📋 Prérequis

- **Docker Desktop** — installé et démarré
- **WSL2** — activé sur Windows (recommandé pour Sail)
- **Ollama** — [ollama.ai](https://ollama.ai) pour LogisBot (IA locale)

---

## 🚀 Installation

### 1. Cloner le projet

```bash
git clone <url-du-repo> methode_agile
cd methode_agile
```

### 2. Fichier d'environnement

```bash
cp .env.example .env
```

### 3. Installer les dépendances PHP (sans Docker)

```bash
docker run --rm -v $(pwd):/var/www/html -w /var/www/html laravelsail/php83-composer:latest composer install
```

### 4. Lancer les containers Sail

```bash
./vendor/bin/sail up -d
```

### 5. Base de données

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

### 6. Assets frontend

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

### 7. Configurer Ollama (LogisBot)

1. Installez et lancez **Ollama** sur votre machine : [ollama.ai](https://ollama.ai)
2. Téléchargez le modèle :

```bash
ollama pull llama3.2:1b
```

3. L'URL `http://host.docker.internal:11434` est déjà configurée dans `.env` — le container Sail communique avec Ollama sur votre hôte.

---

## 🌐 Accès

| Service | URL |
|---------|-----|
| **Application** | [http://localhost](http://localhost) |
| **phpMyAdmin** | [http://localhost:8080](http://localhost:8080) |
| **MySQL** | `localhost:3306` (ou `3308` si `FORWARD_DB_PORT` défini) |

---

## 👤 Identifiants de test

Générés par les seeders :

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| **Admin** | `admin@entrepots.com` | `password` |
| **Magasinier** | `magasinier@entrepots.com` | `password` |
| **Logistique 1** | `logistique1@entrepots.com` | `password` |
| **Logistique 2** | `logistique2@entrepots.com` | `password` |

---

## 🛠️ Commandes utiles

```bash
# Arrêter les containers
./vendor/bin/sail down

# Relancer
./vendor/bin/sail up -d

# Logs en direct
./vendor/bin/sail logs -f

# Shell dans le container
./vendor/bin/sail shell

# Réinitialiser la BDD (données de test)
./vendor/bin/sail artisan migrate:fresh --seed

# Vider le cache config
./vendor/bin/sail artisan config:clear
```

---

## 📁 Structure technique

```
app/
├── Http/Controllers/
│   ├── AssistantController.php   # Routeur d'intentions + chat LogisBot
│   ├── DashboardController.php   # Watchdog, stats, dashboards
│   └── ColisController.php       # CRUD, scan, statuts rapides
├── Services/
│   └── OllamaService.php         # Appel API /api/chat Ollama
├── Models/
│   └── Colis.php                 # getQrCodeSvg(), getQrCodeSvgMini()
└── Providers/
    └── AppServiceProvider.php    # View Composer Watchdog (sidebar)
```

---

## 🏗️ Équipe

Mahdi · Mohammed · Matteo — **Méthodes Agiles** (Phase 1)

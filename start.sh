#!/bin/bash
set -e

echo "🚀 Démarrage de l'environnement Méthode Agile (Docker Sail)"
echo "=========================================================="

# Créer .env si absent
if [ ! -f .env ]; then
    echo "📋 Copie de .env.example vers .env..."
    cp .env.example .env
fi

# Vérifier si Sail est configuré
if [ ! -f docker-compose.yml ]; then
    echo "⚠️  docker-compose.yml introuvable. Exécutez d'abord :"
    echo "   ./vendor/bin/sail artisan sail:install"
    exit 1
fi

# Installer les dépendances PHP (nécessaire avant sail up)
echo ""
echo "📦 Installation des dépendances Composer..."
composer install

# Lancer les containers Docker
echo ""
echo "🐳 Lancement des containers Sail..."
./vendor/bin/sail up -d

# Attendre que MySQL soit prêt
echo ""
echo "⏳ Attente de MySQL..."
sleep 10

# Générer la clé d'application
echo ""
echo "🔑 Génération de la clé d'application..."
./vendor/bin/sail artisan key:generate

# Migrations et seeding
echo ""
echo "🗄️  Migrations et seeding de la base de données..."
./vendor/bin/sail artisan migrate:fresh --seed

# Installer et compiler les assets
echo ""
echo "🎨 Installation et compilation des assets..."
./vendor/bin/sail npm install
./vendor/bin/sail npm run build

echo ""
echo "=========================================================="
echo "✅ Installation terminée !"
echo ""
echo "🌐 L'application est accessible sur : http://localhost"
echo ""
echo "👤 Comptes de test :"
echo "   • Admin     : admin@entrepots.com / password"
echo "   • Magasinier: magasinier@entrepots.com / password"
echo "   • Logistique: logistique1@entrepots.com / password"
echo ""
echo "Pour arrêter les containers : ./vendor/bin/sail down"
echo "=========================================================="

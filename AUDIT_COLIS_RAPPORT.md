# 🔍 Rapport d'Audit - Fonctionnalité Colis

**Date :** 17 mars 2025  
**Contexte :** Audit post-intégration du travail d'un collègue

---

## 1. Base de données (Migrations)

### ✅ Points positifs
- Utilisation correcte de `Schema::table()` (pas de `Schema::create`)
- La migration ne supprime aucune donnée existante
- Les modifications sont des `change()` de colonnes existantes

### ⚠️ Problèmes identifiés

#### 1.1 Doublon de migration
- **Fichiers :** `2023_10_01_000001_update_colis_table.php` et `2026_10_01_000001_update_colis_table.php`
- **Problème :** La migration `2023` s'exécute **avant** `2025_03_11_create_colis_table` → la table `colis` n'existe pas encore → **échec garanti**
- **Action :** Supprimer `2023_10_01_000001_update_colis_table.php` (doublon erroné)

#### 1.2 Méthode `down()` incorrecte
- `$table->string('date_reception')->change()` → **Erreur** : l'original est `date`, pas `string`. Un rollback casserait le schéma.
- `$table->string('date_expedition')->nullable(false)->change()` → Risque d'échec si des colis ont `date_expedition` NULL
- `$table->string('description')` → L'original dans `create_colis` est `text`, pas `string` (risque de troncature)

#### 1.3 Cohérence avec la migration initiale
La migration `create_colis_table` définit déjà :
- `description` : `text` (non nullable)
- `date_reception` : `date`
- `date_expedition` : `date` nullable
- `fragile` : `boolean`

L'update modifie principalement `description` (text → string nullable). Le `down()` doit rétablir le type `text`.

---

## 2. Sécurité & Validation

### ✅ Points positifs
- Validation présente dans `store()` et `update()`
- Règles `exists:clients,id`, `exists:transporteurs,id`, `exists:emplacements,id` → protection contre les IDs invalides
- Pas d'assignation de masse non contrôlée dans `update()` (utilisation de `$validated`)

### ⚠️ Améliorations suggérées
- Ajouter `|max:255` pour `statut` et `dimensions` (limite DoS / débordement)
- Remplacer `'nullable|string'` par `'nullable|string|max:65535'` pour `description` (cohérence avec `text`)
- Le modèle `$fillable` est correct → pas de vulnérabilité mass assignment

---

## 3. Logique Métier

### 🚨 BUG CRITIQUE dans `store()`
Les champs validés **ne sont pas tous assignés** au colis :

| Champ validé | Assigné dans store() ? |
|--------------|------------------------|
| client_id | ✅ |
| statut | ✅ |
| date_reception | ✅ |
| description | ✅ |
| poids_kg | ✅ |
| dimensions | ✅ |
| fragile | ✅ |
| **date_expedition** | ❌ **MANQUANT** |
| **transporteur_id** | ❌ **MANQUANT** |
| **emplacement_id** | ❌ **MANQUANT** |

**Impact :** Les colis créés n'ont jamais de transporteur, emplacement ou date d'expédition, même si l'utilisateur les renseigne.

### ✅ Méthode `update()`
- Utilise `$colis->update($validated)` → tous les champs validés sont bien persistés via `$fillable`

### ✅ Relations
- Le modèle `Colis` a bien les relations `client()`, `transporteur()`, `emplacement()`
- `index()` et `show()` chargent `client` via `with('client')` — on pourrait ajouter `transporteur` et `emplacement` pour affichage complet

---

## 4. Modèle Colis

### ✅ Points positifs
- `$fillable` contient tous les champs : `code_qr`, `description`, `poids_kg`, `dimensions`, `statut`, `date_reception`, `date_expedition`, `fragile`, `client_id`, `transporteur_id`, `emplacement_id`
- `$casts` corrects pour `date`, `decimal`, `boolean`
- Relations bien définies

### ✅ Aucune modification nécessaire

---

## 5. Synthèse des corrections à appliquer

| Priorité | Fichier | Action |
|----------|---------|--------|
| 🔴 Haute | `database/migrations/2023_10_01_000001_update_colis_table.php` | Supprimer (doublon) |
| 🔴 Haute | `database/migrations/2026_10_01_000001_update_colis_table.php` | Corriger la méthode `down()` |
| 🔴 Haute | `app/Http/Controllers/ColisController.php` | Corriger `store()` : assigner `transporteur_id`, `emplacement_id`, `date_expedition` |
| 🟡 Moyenne | `app/Http/Controllers/ColisController.php` | Renforcer les règles de validation (max) |

---

## 6. Corrections appliquées ✅

| Fichier | Correction |
|---------|-------------|
| `2023_10_01_000001_update_colis_table.php` | **Supprimé** (doublon qui s'exécutait avant la création de la table) |
| `2026_10_01_000001_update_colis_table.php` | `down()` corrigé : `text` au lieu de `string`, types `date` conservés |
| `2026_10_01_000001_update_colis_table.php` | `up()` : `text` au lieu de `string` pour `description` (évite la troncature) |
| `ColisController::store()` | Assignation de `transporteur_id`, `emplacement_id`, `date_expedition` + utilisation de `Colis::create()` |
| `ColisController::store()` | Validation renforcée : `max:65535`, `max:255`, `min:0` |
| `ColisController::update()` | Validation harmonisée + valeurs par défaut pour colonnes NOT NULL |

---

**CONSIGNE RESPECTÉE :** Aucun fichier `.blade.php` n'a été modifié.

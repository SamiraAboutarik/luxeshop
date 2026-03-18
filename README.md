# 🛍️ LuxeShop — E-commerce Platform

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=flat&logo=tailwindcss&logoColor=white)

> Application e-commerce complète pour petites entreprises — gestion produits, panier dynamique, commandes et dashboard admin.

---

## 🖼️ Screenshots

<!-- Ajouter tes screenshots après déploiement -->
| Boutique | Dashboard Admin |
|----------|----------------|
| ![shop](screenshots/shop.png) | ![admin](screenshots/admin.png) |

---

## ✨ Features

- 🔐 **Authentification** — Login / Register / Rôles (admin / user)
- 🛒 **Panier dynamique** — Ajout, modification quantité, suppression
- 📦 **Commandes** — Checkout complet, historique, page confirmation
- 🖼️ **Upload images** — Storage Laravel avec `storage:link`
- 📊 **Dashboard Admin** — Stats en temps réel, top produits, revenu total
- 🗂️ **CRUD Produits** — Création, édition, suppression avec image
- 📋 **Gestion Commandes** — Suivi statut (pending → delivered)
- 🔍 **Filtres & Recherche** — Par catégorie, prix, nom
- 📱 **Responsive** — Mobile-first avec TailwindCSS

---

## 🛠️ Stack technique

| Couche | Technologie |
|--------|------------|
| Backend | Laravel 12, PHP 8.2 |
| Base de données | MySQL 8 |
| Frontend | Blade, TailwindCSS CDN |
| Auth | Laravel Auth Guards |
| Upload | Laravel Storage (local/public) |

---

## 📁 Architecture
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── ShopController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       ├── ProductController.php
│   │       └── OrderController.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── Models/
│   ├── User · Category · Product
│   ├── CartItem · Order · OrderItem
└── Policies/
    └── CartItemPolicy.php
```

---

## ⚙️ Installation locale
```bash
# Cloner le projet
git clone https://github.com/SamiraAboutarik/luxeshop.git
cd luxeshop

# Installer les dépendances
composer install

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Base de données (.env)
DB_DATABASE=luxeshop
DB_USERNAME=root
DB_PASSWORD=

# Migrations + données de test
php artisan migrate
php artisan db:seed

# Lien storage pour les images
php artisan storage:link

# Lancer le serveur
php artisan serve
```

## 👤 Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| 👑 Admin | admin@shop.com | password |
| 🧑 User | user@shop.com | password |

---

## 📊 Modèle de données
```
users ──────────────── cart_items
  │                         │
  │                     products ── categories
  │                         │
  └──── orders ──── order_items
```

---

## 🚀 Déploiement

Voir section [Deploy](#) — hébergé sur Railway / InfinityFree.

---

## 👩‍💻 Auteure

**Samira Aboutarik** — Étudiante DEVOWFS @ OFPPT Agadir  
[GitHub](https://github.com/SamiraAboutarik)
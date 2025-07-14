# Laravel 12 Migration Guide - FoxInnovs/Language

## 🚀 Installation

### 1. Mise à jour de votre projet

```bash
# Cloner votre fork
git clone https://github.com/foxinnovs/language.git
cd language

# Appliquer les corrections Laravel 12
chmod +x migrate-to-laravel12.sh
./migrate-to-laravel12.sh
```

### 2. Mise à jour du composer.json de votre projet

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/foxinnovs/language"
        }
    ],
    "require": {
        "foxinnovs/language": "dev-main"
    }
}
```

### 3. Installation du package

```bash
composer remove akaunting/language
composer require foxinnovs/language
```

### 4. Publication des assets

```bash
php artisan vendor:publish --provider="Akaunting\Language\Provider"
```

## 🔧 Configuration

### 1. Variables d'environnement

Ajoutez à votre `.env` :

```env
LANGUAGE_AUTO_DETECT=true
LANGUAGE_DEFAULT=en
LANGUAGE_SWITCHER_ENABLED=true
LANGUAGE_STORAGE=session
LANGUAGE_CACHE_ENABLED=true
```

### 2. Middleware

Dans `app/Http/Kernel.php`, ajoutez :

```php
protected $middlewareGroups = [
    'web' => [
        // ... autres middlewares
        \Akaunting\Language\Middleware\SetLanguage::class,
    ],
];
```

### 3. TrustProxies (si nécessaire)

Si vous utilisez des proxies, remplacez dans `app/Http/Middleware/TrustProxies.php` :

```php
<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    protected $proxies;
    
    protected $headers = Request::HEADER_X_FORWARDED_FOR | 
                        Request::HEADER_X_FORWARDED_HOST | 
                        Request::HEADER_X_FORWARDED_PORT | 
                        Request::HEADER_X_FORWARDED_PROTO | 
                        Request::HEADER_X_FORWARDED_AWS_ELB;
}
```

## 🧪 Tests

```bash
# Installer les dépendances de développement
composer install --dev

# Lancer les tests
./vendor/bin/phpunit tests/Laravel12CompatibilityTest.php
```

## 📦 Publication sur Packagist

1. Poussez vos modifications :

```bash
git add .
git commit -m "Laravel 12 compatibility update"
git push origin main
```

2. Créez une release sur GitHub
3. Soumettez à Packagist : https://packagist.org/packages/submit

## 🔄 Changements principaux

- ✅ Mise à jour `composer.json` pour Laravel 12
- ✅ Remplacement `Fideloper\Proxy\TrustProxies` par `Illuminate\Http\Middleware\TrustProxies`
- ✅ Mise à jour des constantes de headers
- ✅ Compatibilité PHP 8.1+
- ✅ Tests de compatibilité
- ✅ Configuration moderne

## 🐛 Résolution des problèmes

### Erreur "Class not found"

```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Middleware non trouvé

Vérifiez que le middleware est bien enregistré dans `app/Http/Kernel.php`

### Problème de TrustProxies

Assurez-vous d'utiliser la nouvelle version du middleware fournie

## 📞 Support

Pour toute question ou problème :
- Créez une issue sur : https://github.com/foxinnovs/language/issues
- Consultez la documentation Laravel 12

## 🎯 Prochaines étapes

1. Testez dans votre environnement de développement
2. Validez en staging
3. Déployez en production
4. Considérez contribuer au projet original
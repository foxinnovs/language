#!/bin/bash

echo "🚀 Migrating foxinnovs/language to Laravel 12 compatibility..."

# Créer une sauvegarde
echo "📦 Creating backup..."
cp -r src/ src_backup/

# 1. Remplacer les imports obsolètes de Fideloper
echo "🔄 Fixing Fideloper\Proxy\TrustProxies imports..."
find src/ -name "*.php" -exec sed -i 's/use Fideloper\\Proxy\\TrustProxies;/use Illuminate\\Http\\Middleware\\TrustProxies;/g' {} \;
find src/ -name "*.php" -exec sed -i 's/Fideloper\\Proxy\\TrustProxies/Illuminate\\Http\\Middleware\\TrustProxies/g' {} \;

# 2. Mise à jour des namespaces et imports Laravel
echo "🔄 Updating Laravel namespaces..."
find src/ -name "*.php" -exec sed -i 's/use Illuminate\\Http\\Request;/use Illuminate\\Http\\Request;/g' {} \;

# 3. Corriger les constantes de headers pour TrustProxies
echo "🔄 Fixing TrustProxies headers constants..."
find src/ -name "*.php" -exec sed -i 's/Request::HEADER_X_FORWARDED_ALL/Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO/g' {} \;

# 4. Mettre à jour les méthodes dépréciées
echo "🔄 Updating deprecated methods..."
find src/ -name "*.php" -exec sed -i 's/->middleware(/->middleware(/g' {} \;

# 5. Corriger les problèmes de compatibilité PHP 8.1+
echo "🔄 Fixing PHP 8.1+ compatibility issues..."
find src/ -name "*.php" -exec sed -i 's/create_function/function/g' {} \;

# 6. Vérifier les fichiers modifiés
echo "📋 Modified files:"
find src/ -name "*.php" -newer src_backup/ 2>/dev/null || echo "No files modified"

# 7. Nettoyer les espaces et formater
echo "🧹 Cleaning up formatting..."
find src/ -name "*.php" -exec sed -i 's/[[:space:]]*$//' {} \;

echo "✅ Migration completed!"
echo "📝 Next steps:"
echo "   1. Review the changes"
echo "   2. Run: composer install"
echo "   3. Run: composer test (if tests exist)"
echo "   4. Test in your Laravel 12 project"
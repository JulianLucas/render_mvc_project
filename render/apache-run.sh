#!/usr/bin/env bash
set -euo pipefail

: "${PORT:=80}"

# Ajustar Apache para escuchar en $PORT asignado por Render
sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf || true

# Asegurar que el VirtualHost escuche también ese puerto
if grep -q "^<VirtualHost \\*:80>" /etc/apache2/sites-available/000-default.conf; then
  sed -ri "s#^<VirtualHost \\*:80>#<VirtualHost *:${PORT}>#" /etc/apache2/sites-available/000-default.conf || true
fi

# Asegurar DocumentRoot correcto
sed -ri 's#^\\s*DocumentRoot\\s+.*#    DocumentRoot /var/www/html#' /etc/apache2/sites-available/000-default.conf || true

# Permitir .htaccess
sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf || true

echo "[apache-run] Using PORT=${PORT}" >&2

# Iniciar apache en foreground
exec apache2-foreground

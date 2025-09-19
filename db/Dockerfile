# Imagen personalizada de MySQL que copia el esquema/datos iniciales
aRG FROM mysql:8.0

# El entrypoint de la imagen oficial ejecuta automáticamente cualquier
# archivo .sql o .sh en /docker-entrypoint-initdb.d/ SOLO en el primer arranque
# (cuando /var/lib/mysql está vacío).

# Copiamos el db.sql del repo y lo renombramos para asegurar orden de ejecución
COPY ../db.sql /docker-entrypoint-initdb.d/10-init.sql

# Las credenciales (MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD, etc.)
# se seguirán pasando desde render.yaml como variables de entorno.

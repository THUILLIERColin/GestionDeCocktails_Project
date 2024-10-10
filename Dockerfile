# Utilise une image PHP avec Apache pré-configurée
FROM php:8.1-apache

# Copie tous les fichiers de ton projet dans le dossier par défaut d'Apache
COPY . /var/www/html/

# Grant access 
RUN chown -R www-data:www-data /var/www/html

# Expose le port 80 pour l'accès HTTP
EXPOSE 80
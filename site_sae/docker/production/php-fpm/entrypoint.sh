#!/bin/sh
set -e

# Initialize storage directory if empty
# -----------------------------------------------------------
# If the storage directory is empty, copy the initial contents
# and set the correct permissions.
# -----------------------------------------------------------
if [ ! "$(ls -A /var/www/storage)" ]; then
  echo "Initializing storage directory..."
  cp -R /var/www/storage-init/. /var/www/storage
  chown -R www-data:www-data /var/www/storage
fi

# Remove storage-init directory
rm -rf /var/www/storage-init

# Run Laravel migrations
# -----------------------------------------------------------
# Ensure the database schema is up to date.
# -----------------------------------------------------------
php artisan migrate --force

# Run Laravel seeders
# -----------------------------------------------------------
# Seed the database with initial data.
# -----------------------------------------------------------
# php artisan db:seed --force

# Generate application key
# -----------------------------------------------------------
# Generate a new application key if it doesn't exist.
# -----------------------------------------------------------
php artisan key:generate

# Generate application storage link
# -----------------------------------------------------------
# Create a symbolic link from the public storage directory to the storage directory.
# This is necessary for serving files from the storage directory.
# -----------------------------------------------------------
php artisan storage:link

# Clear and cache configurations
# -----------------------------------------------------------
# Improves performance by caching config and routes.
# -----------------------------------------------------------
php artisan config:cache
php artisan route:cache

# Run the default command
exec "$@"

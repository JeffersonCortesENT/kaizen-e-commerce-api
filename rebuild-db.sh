#!/bin/bash

# Load environment variables from .env file
DB_NAME=$(grep DB_DATABASE .env | cut -d '=' -f2)
DB_USER=$(grep DB_USERNAME .env | cut -d '=' -f2)
DB_PASSWORD=$(grep DB_PASSWORD .env | cut -d '=' -f2)
DB_HOST=$(grep DB_HOST .env | cut -d '=' -f2)
DB_PORT=$(grep DB_PORT .env | cut -d '=' -f2)
MYSQL_CONTAINER="mysql8.0"  # Change this if needed
LARAVEL_CONTAINER="api.kaizen-e-commerce"  # Change this if needed

# Ensure required .env variables are set (DB_PASSWORD can be empty)
if [[ -z "$DB_NAME" || -z "$DB_USER" || -z "$DB_HOST" || -z "$DB_PORT" ]]; then
  echo "Error: Could not read required database credentials from .env file."
  exit 1
fi

echo "Resetting database '$DB_NAME'..."

# Construct MySQL command based on whether DB_PASSWORD is set
if [[ -z "$DB_PASSWORD" ]]; then
  MYSQL_CMD="mysql -u$DB_USER -h$DB_HOST -P$DB_PORT -e"
else
  MYSQL_CMD="mysql -u$DB_USER -p$DB_PASSWORD -h$DB_HOST -P$DB_PORT -e"
fi

# Drop the database if it exists
docker exec -i $MYSQL_CONTAINER $MYSQL_CMD "DROP DATABASE IF EXISTS \`$DB_NAME\`;"
if [[ $? -eq 0 ]]; then
  echo "Database '$DB_NAME' dropped successfully."
else
  echo "Failed to drop database. Check MySQL container logs."
  exit 1
fi

# Recreate the database
docker exec -i $MYSQL_CONTAINER $MYSQL_CMD "CREATE DATABASE \`$DB_NAME\`;"
if [[ $? -eq 0 ]]; then
  echo "Database '$DB_NAME' created successfully!"
else
  echo "Failed to create database. Check MySQL container logs."
  exit 1
fi

echo "Running migrations..."
docker exec -it $LARAVEL_CONTAINER php artisan migrate --seed

if [[ $? -eq 0 ]]; then
  echo "Migrations completed successfully!"
else
  echo "Migration failed. Check Laravel logs."
  exit 1
fi

#!/bin/bash
set -e

cp -r /var/tmp/postgresql/postgresql.conf /var/lib/postgresql/data/postgresql.conf

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    ALTER USER postgres WITH PASSWORD 'postgres2024';
    CREATE DATABASE geoglify;
    CREATE EXTENSION IF NOT EXISTS postgis;
    GRANT ALL PRIVILEGES ON DATABASE geoglify TO postgres;
EOSQL
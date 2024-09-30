#!/bin/bash
set -e

cp -r /var/tmp/postgresql/postgresql.conf /var/lib/postgresql/data/postgresql.conf

psql -v ON_ERROR_STOP=1 --username postgres --dbname postgres <<-EOSQL
    CREATE USER dbadmin WITH PASSWORD 'geoglify2024';
    ALTER USER postgres WITH PASSWORD 'postgres2024';
    CREATE DATABASE geoglify;
    ALTER USER dbadmin WITH SUPERUSER;
    GRANT ALL PRIVILEGES ON DATABASE geoglify TO postgres;
    GRANT ALL PRIVILEGES ON DATABASE geoglify TO dbadmin;
    CREATE EXTENSION postgis;
EOSQL
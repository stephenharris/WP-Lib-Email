#!/usr/bin/env bash

if [ $# -lt 3 ]; then
	echo "usage: $0 <db-name> <db-user> <db-pass> [db-host] [wp-version]"
	exit 1
fi

parent=$(dirname $PWD)
grandparent=$(dirname $parent)

DB_NAME=$1
DB_USER=$2
DB_PASS=$3
DB_HOST=${4-localhost}
WP_VERSION=${5-latest}

WP_TESTS_DIR=${WP_TESTS_DIR-/tmp/wordpress-tests-lib}
WP_CORE_DIR=/tmp/wordpress/

#set -ex;

# Download WordPress
mkdir -p $WP_CORE_DIR;
mkdir -p $WP_TESTS_DIR;

vendor/bin/wp core download --force --version=$WP_VERSION --path=$WP_CORE_DIR;

# Create WordPress config
vendor/bin/wp core config --dbname=$DB_NAME --dbuser=$DB_USER --dbpass=$DB_PASS --path=$WP_CORE_DIR

# Install the database tables
vendor/bin/wp db create --path=$WP_CORE_DIR
vendor/bin/wp core install --url="wp.dev" --title="wp.dev" --admin_user="admin" --admin_password="password" --admin_email="admin@wp.dev" --path=$WP_CORE_DIR --skip-email

# Test library
vendor/bin/wp test-library download --library-path=/tmp/wp-test-library --path=$WP_CORE_DIR
vendor/bin/wp test-library config --dbname=$DB_NAME --dbuser=$DB_USER --dbpass=$DB_PASS --library-path=/tmp/wp-test-library --path=$WP_CORE_DIR
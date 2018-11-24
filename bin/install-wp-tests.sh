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
cd $WP_CORE_DIR;
wp core download --force --version=$WP_VERSION;

# Create WordPress config
wp core config --dbname=$DB_NAME --dbuser=$DB_USER --dbpass=$DB_PASS

# Install the database tables
wp db create
wp core install --url="wp.dev" --title="wp.dev" --admin_user="admin" --admin_password="password" --admin_email="admin@wp.dev" --skip-email

# Test library
wp test-library download --library-path=/tmp/wp-test-library
wp test-library config --dbname=$DB_NAME --dbuser=$DB_USER --dbpass=$DB_PASS --library-path=/tmp/wp-test-library

# Copy in plugin
rm -rf ${WP_CORE_DIR}wp-content/plugins/*
ln -s $WORKSPACE/bookedup ${WP_CORE_DIR}/wp-content/plugins/bookedup

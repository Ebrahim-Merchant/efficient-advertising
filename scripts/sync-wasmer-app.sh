#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
APP_DIR="${ROOT_DIR}/app"

rm -rf "${APP_DIR}"
mkdir -p "${APP_DIR}/wp-content"

root_files=(
  "index.php"
  "license.txt"
  "robots.txt"
  "wp-blog-header.php"
  "wp-comments-post.php"
  "wp-cron.php"
  "wp-links-opml.php"
  "wp-load.php"
  "wp-login.php"
  "wp-mail.php"
  "wp-settings.php"
  "wp-signup.php"
  "wp-trackback.php"
  "xmlrpc.php"
)

for path in "${root_files[@]}"; do
  cp -a "${ROOT_DIR}/${path}" "${APP_DIR}/${path}"
done

cp -a "${ROOT_DIR}/wp-config.wasmer.php" "${APP_DIR}/wp-config.php"
rsync -a --delete "${ROOT_DIR}/wp-admin/" "${APP_DIR}/wp-admin/"
rsync -a --delete "${ROOT_DIR}/wp-includes/" "${APP_DIR}/wp-includes/"

cp -a "${ROOT_DIR}/wp-content/index.php" "${APP_DIR}/wp-content/index.php"

if [[ -f "${ROOT_DIR}/wp-content/maintenance.php" ]]; then
  cp -a "${ROOT_DIR}/wp-content/maintenance.php" "${APP_DIR}/wp-content/maintenance.php"
fi

content_dirs=(
  "litespeed"
  "maintenance"
  "mc_data"
  "mu-plugins"
  "plugins"
  "speedycache-config"
  "themes"
  "updraft"
)

for dir in "${content_dirs[@]}"; do
  if [[ -d "${ROOT_DIR}/wp-content/${dir}" ]]; then
    rsync -a --delete "${ROOT_DIR}/wp-content/${dir}/" "${APP_DIR}/wp-content/${dir}/"
  fi
done

mkdir -p "${APP_DIR}/wp-content/uploads"

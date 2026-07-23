#!/bin/bash

# Sair imediatamente se algum comando falhar
set -e

echo "Rodando as migrations do banco de dados..."
# O --force é necessário em produção para não pedir confirmação
php artisan migrate --force

echo "Limpando caches do Laravel..."
php artisan optimize:clear

echo "Iniciando o servidor Apache..."
# Inicia o Apache no modo foreground (primeiro plano) para o container não fechar
apache2-foreground

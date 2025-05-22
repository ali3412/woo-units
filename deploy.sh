#!/bin/bash

echo "Выгрузка изменений плагина woo-units на GitHub..."

# Добавление всех изменений
git add .

# Запрос описания коммита
echo "Введите описание изменений:"
read commit_message

# Создание коммита
git commit -m "$commit_message"

# Отправка на GitHub
git push origin main

echo "Выгрузка завершена!"

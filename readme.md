# Тестовое задание: Парсер изображений

Краткое описание задачи: Реализовать скрипт, который загружает все картинки с сайта

## Окружение

Для запуска требуется:
1. [Docker compose](https://docs.docker.com/compose/install/)

## Установка и сборка

Клонирование проекта:
```
git clone git@github.com:maldinsky/images-parser-test-task.git
```

Перейти в папку с проектом и запустить:

```
docker-compose up --build
```

Перейти в папку app:
1. переименовать .example.env в .env, проверить правильность конфигурации (проверить права на папку для сохранения изображений).
2. выполнить команды:

```
composer install
```

Перейти в папку frontend:
1. переименовать .example.env в .env, проверить правильность конфигурации.
2. выполнить команды:

```
npm install
npm run dev
```
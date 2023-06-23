Развернуть проект:

1. Установить Yii в директорию taskforce:

composer create-project --prefer-dist yiisoft/yii2-app-basic summary

2. Загрузить проект из гита в директорию summary:

git clone git@github.com:dkrech07/summary.git

3. Загрузить зависимости:

composer install
composer update

4. Выполнить автозагрузку кастомных классов:

composer dump-autoload

5. Создать базу данных:

CREATE DATABASE summary
  DEFAULT CHARACTER SET utf8mb4;

6. Получить структуру базы данных:

yii migrate

7. Загрузить тестовые данные:

yii fixture "Status, Summary"

php yii fixture/load Status
php yii fixture/load Summary

Дополнительно:

1. Генерация тестовых данных:

php yii fixture/generate fixture 1 --count=10
php yii fixture/generate fixture 2 --count=10
php yii fixture/generate fixture 3 --count=50
...

Фоновый процесс для получения подробного и краткого описания по Крону:

Для консоли:
php yii cron/index

Для настройки на сервере:
cd ~/summary.na4u.ru/ && ./bin/php ~/summary.na4u.ru/yii_project/yii cron/index
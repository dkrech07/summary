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

php yii cron

cd ~/summary.na4u.ru/ && /home/c75780/summary.na4u.ru/yii_project/vendor/yiisoft/yii2/yii cron -m=cron

cd ~/summary.na4u.ru/ && ./bin/php ~/summary.na4u.ru/yii_project/vendor/yiisoft/yii2/yii ~/summary.na4u.ru/yii_project/commands/LogController.php log -m=log

cd ~/summary.na4u.ru/ && ./bin/php ~/summary.na4u.ru/yii_project/vendor/yiisoft/yii2/Yii.php log/write
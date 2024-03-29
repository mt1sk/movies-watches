## Просмотренные фильмы
##### Основные сущности:
- пользователь
- фильм
- просмотр
##### Endpoints:
- регистрация пользователя ```/api/v1/register``` ```POST```
- аутентификация пользователя ```/api/v1/login``` ```POST```
- список всех фильмов ```/api/v1/movies``` ```GET```
- просмотр фильма ```/api/v1/movies/{id}``` ```GET```
- создание фильма ```/api/v1/movies``` ```POST```
- редактирование фильма ```/api/v1/movies/{id}``` ```PATCH```
- удаление фильма ```/api/v1/movies/{id}``` ```DELETE```


### Информация по установке
1. Клонируем репозиторий
2. В корне копируем ```.env.example``` -> ```.env```
   - проверяем не заняты ли порты: ```80```, ```3306```, ```8080```; если заняты - меняем в ```.env``` файле **и учитытваем в дальнейших настройках**
   - по необходимости меняем пароль к базе данных
3. Поднимаем контейнеры: ```sudo docker-compose up -d --build```
4. В админере создаем базу данных, [http://localhost:8080](http://localhost:8080), режим сопоставления **utf8mb4_general_ci**
5. В папке ```src``` копируем файл ```.env.example``` -> ```.env``` и указываем настройки базы данных:
   - ```DB_HOST=db```
   - ```DB_PORT=3306```
   - ```DB_PASSWORD``` берём из настроек docker-compose
   - ```DB_DATABASE``` прасваиваем созданное вами имя
6. Заходим в докер контейнер ```web```: ```docker exec -it your_container_name bash```
   - генерируем ```APP_KEY```: ```php artisan key:generate```
   - выполняем миграции: ```php artisan migrate```
   - выполняем настройку laravel passport: ```php artisan passport:install```

### RESTAURANT SITE
1.- Clone the repository in a new directory of your choice ("directoryName").
```
git clone https://github.com/u83mm/my-symfony-restaurant.git "directoryName"
```

2.- Navigate to the new directory.
```
cd directoryName
```
3.- Create "log" directoriy and inside "log" directory create "apache", "db" and "php" directories.
```
mkdir log log/apache log/db log/php
```
4.- Build the project and stands up the containers
```
docker compose build
docker compose up -d
```
5.- Access to phpMyAdmin.
```
http://localhost:8080/
user: admin
passwd: admin
```
6.- Select "my_database", go to "import" menu and search my_database.sql file in your "directoryName".

7.- Go to PHP container and install the project.
```
docker exec -it php bash
composer install
exit
```

8.- Go to your localhost in the browser and you can do login.
```
http://localhost/
user: admin@admin.com
passwd: adminadmin
```


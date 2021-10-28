
## Setup Guide

- Make sure your Docker is up and running
- cd into the project repository
- Build project container using below command
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs
```
- Start the application
```bash
docker compose up --build -d
```

- Navigate into the application container
```bash
docker exec -it eskimi-task-app-1 bash
```

Connect storage folder to public to make uploaded banner visible
```bash
php artisan storage:link
```

- Create database tables and populate with dummy records
```bash
php artisan migrate --seed
```

- Install frontend dependencies
```bash
npm install
```

- Build/Compile frontend assets

```bash
npm run dev
```

- Exit Container
```bash
exit
```

- Application endpoint: http://127.0.0.1:8084


## Run Unit Test

```bash
vendor/bin/phpunit
```


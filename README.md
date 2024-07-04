## Required Environments
- PHP: 7.4
- Laravel: 8.7 
- MySQL: 8.0
- Composer: 2.2.x (current 2.2.1)
- Node: 16.14.x (current 16.14.2)
- NPM: 8.5.x (current 8.5.0)
- Docker: 20.10.x (current 20.10.8)
- Docker compose: 1.29.x (current 1.29.2)
- Vuejs: 3.2.36

## How to set up development?

- Step 1: cd "{project/path}"
- Step 2: docker-compose up -d --build
- Step 3: docker exec -it timeshare_reservation_app cp .env.example .env
- Step 4: Change config in .env 
- Step 5: docker exec -it timeshare_reservation_app composer update
- Step 6: docker exec -it timeshare_reservation_app php artisan migrate
- Step 7: docker exec -it timeshare_reservation_app php artisan key:generate
- Step 8: docker exec -it timeshare_reservation_app php artisan jwt:secret
- Step 9: docker exec -it timeshare_reservation_app php artisan storage:link
- Step 10: docker exec -it timeshare_reservation_app php artisan db:seed
- Step 11: docker exec -it timeshare_reservation_app npm install --legacy-peer-deps
- Step 12: docker exec -it timeshare_reservation_app npm run production
- Step 13: docker exec -it timeshare_reservation_app php artisan optimize
- Step 14: You can access the application in your web browser at: http://localhost:8032 
- Step 15: You can access admin site in your web browser at: http://localhost:8032/admin/login

### Check basic auth with docker
- cd {project/path}/docker/app/hosts
- Check config: vim 000-default.conf
- Check account and password basic authentication: .htpasswd

### Run vue (frontend template)

- Install: npm install --legacy-peer-deps
- Development build: npm run dev
- Production build: npm run production
- Watch development: npm run watch

### PHP version

- docker exec -it timeshare_reservation_app php --version

### PHP extensions

- docker exec -it timeshare_reservation_app php -m

### MySQL version 8.0

- docker exec -it timeshare_reservation_db mysql --version
- Port: 3306
- Hostname: mysql
- Account: root / root
- Database name: timeshare_reservation

### Admin Seeder
- All seeder
- docker exec -it timeshare_reservation_app php artisan db:seed
- Seeder by Table
- docker exec -it timeshare_reservation_app php artisan db:seed --class=CreateAdminSeeder

### Config import export Excel, csv

- composer require maatwebsite/excel
- php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config

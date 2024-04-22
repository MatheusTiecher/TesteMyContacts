setup:
	docker compose -f docker-compose.yaml up -d --build
	docker exec -t test_my_contacts_laravel cp .env.example .env
	docker exec -t test_my_contacts_laravel composer install
	docker exec -t test_my_contacts_laravel npm install
	docker exec -t test_my_contacts_laravel npm run build
	docker exec -t test_my_contacts_laravel php artisan key:generate
	docker exec -t test_my_contacts_laravel php artisan migrate
	docker exec -t test_my_contacts_laravel chmod -R 755 /var/www/html/storage
	docker exec -t test_my_contacts_laravel chmod -R 755 /var/www/html/bootstrap/cache
	docker exec -t test_my_contacts_laravel chown -R www-data:www-data /var/www/html/storage
	docker exec -t test_my_contacts_laravel chown -R www-data:www-data /var/www/html/bootstrap/cache

up:
	docker compose -f docker-compose.yaml up -d

down:
	docker compose -f docker-compose.yaml down
run:
	composer install --no-interaction --prefer-dist --apcu-autoloader
ci:
	vendor/bin/ecs check --config ecs.php
fix:
	vendor/bin/ecs check --config ecs.php --fix

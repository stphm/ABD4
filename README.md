# Groupe de pham_s 997040

## Setup

1. Ajouter les entrées qui se trouvent dans `docker/hosts.txt` dans votre fichier hosts de votre machine
2. docker-compose up -d
3. cd vdm-api && composer install && pnpm build
4. Lancer les commandes suivantes :

   - docker-compose exec php_fpm php bin/console doctrine:database:drop --force
   - docker-compose exec php_fpm php bin/console doctrine:database:create
   - docker-compose exec php_fpm php bin/console doctrine:migrations:migrate --no-interaction
   - docker-compose exec php_fpm php bin/console doctrine:fixtures:load --no-interaction

API : http://api.vdm.local
~Build du front : http://vdm.local~

## Génerer un faux traffic

- Se rendre dans le container **php_fpm**
- `php lib/generator/script.php | php bin/console traffic:generator:handler`

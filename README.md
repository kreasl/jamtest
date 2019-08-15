## Install
1. Run `composer install`
2. Configure `DATABASE_URL` config optino in `.env` file
3. Run DB migrations: `php ./bin/console doctrine:migrations:migrate`

## Run
use `symfony start:server` to run application - it should be served at http://127.0.0.1:8000/

## Contribution
There's a quick dirty solution applied to run React application along with Symfony one

Because of that if you'd like to play with react code - you need to build and "deploy" React files manually:
`(cd src.frontend; npm run-script build ; cp ./build/index.html ../templates/ui/; cp -r ./build/static ../public/; ../bin/console cache:clear)`

## Roadmap
Upcoming changes:
1. Unit tests
2. UI styles
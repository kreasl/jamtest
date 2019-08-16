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

## Tests

Run `php ./vendor/bin/simple-phpunit`

1. There are tests defined for all the happy path scenarios
2. Most of them are implemented already
3. Negative cases are not there yet
4. Also mocks and page objects are not used yet
5. Yet I've fixed a couple of bugs using it already. Yay!

## Roadmap
Upcoming changes:
1. UI styles
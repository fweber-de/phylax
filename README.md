Phylax Error Tracker
====================

App Monitor

## Installation

    composer install
    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force
    php app/console cache:clear --env=prod

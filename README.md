Phylax Error Tracker
====================

App Monitor

* Can send Email or Slack Notifications
* Application Heartbeat Monitoring

## Installation

    composer install
    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force
    php app/console cache:clear --env=prod

## Update

    git pull
    composer install
    php app/console doctrine:schema:update --force
    php app/console cache:clear --env=prod

## Important Libraries/Bundles

* SymfonyBundle [PhylaxTrackerBundle](https://github.com/fweber-de/PhylaxTrackerBundle)
* Heartbeat Monitor Library [HeartbeatLib]()

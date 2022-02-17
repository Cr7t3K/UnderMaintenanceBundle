# Under Maintenance Bundle

Installation
============

### Install it via composer
```bash
composer require cvr/under-maintenance-bundle
```

### Register the bundle
Register bundle into `config/bundles.php`:
```php
return [
    //.....
    Cvr\UnderMaintenanceBundle\UnderMaintenanceBundle::class => ['all' => true],
];
```


Usage
=====

Enable maintenance and configure your token in your `.env`:

```
###< cvr/under-maintenance-bundle ###
# Maintenance mode (0=disabled and 1=enabled)
MAINTENANCE=1
MAINTENANCE_TOKEN=<your-token>
###< cvr/under-maintenance-bundle ###
```

Access your site with the maintenance token
```
http://your-domain?maintenance=<your-token>
```

Override Maintenance Templates
==============================

Create new folder named `UnderMaintenanceBundle` in your `templates/bundles/` application and create new twig template `maintenance.html.twig`.

> Then, don't forget to clear the cache `php bin/console cache:clear`

```
├── bin/
├── config/
├── public/
├── src/
├── templates/
│   └── bundles/
│       └── UnderMaintenanceBundle/
│           └── maintenance.html.twig
├── tests/
├── translations/
```

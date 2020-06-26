# Northern Maintenance Mode Bundle

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require northernco/maintenance-mode-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require northernco/markdown-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Northern\MaintenanceModeBundle\NorthernMaintenanceModeBundle::class => ['all' => true],
];
```

Usage
=====

Once the bundle is installed, you can both enable and disable
maintenance mode on your application by running the following 
commands:

To enable maintenance mode:
`bin/console app:maintenance --enable`

To disable maintenance mode:
`bin/console app:maintenance --disable`

Overriding the Default Template
===============================
To override the default maintenance mode template, create your
own template file at `templates/bundles/NorthernMaintenanceModeBundle/maintenance.html.twig`

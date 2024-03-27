# PING PLUGIN


## install steps for development


```bash
cp .env.example .env
composer install --ignore-platform-req=ext-intl
sail up -d
sail artisan telescope:install
sail artisan app:install --force

```

## develop

```bash
mkdir -p packages/wdog
cd packages/wdog
git clone git clone <REPO> ping
```

Modify main `composer.json`

```json
"require": {
    "wdog/ping": "dev-main"
},

"repositories": [{
        "type": "path",
        "url": "packages/wdog/ping",
        "options": {
            "symlink": true
        }
}]
```


```bash
# in main project
composer upgrade --ignore-platform-req=ext-intl
sail artisan ping:install
```


To Apply Plugin to Admin Panel adding these lines to `Providers/Filamente/AdminPanelProvider.php`

```php
$panel->plugins([
    PingPlugin::make()
])
```


## Run Queue

```bash
sail artisan queue:work
sail artisan schedule:list
```

## Lint

```bash
sail bin duster lint --using=pint -v
sail bin duster fix --using=pint -v
```

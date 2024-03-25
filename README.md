# PING PLUGIN


## install steps for development


```bash
cp .env.example .env
composer install --ignore-platform-req=ext-intl
sail up -d
sail artisan telescope:install
sail artisan app:install --force


mkdir -p packages/wdog
cd packages/wdog
git clone git clone ssh://git@192.168.88.100:2222/wdog/Ping.git ping


Modify main `composer.json`

```json
"require": {
       "wdog/ping": "dev-main"
},

"repositories": [
    {
        "type": "path",
        "url": "packages/wdog/ping",
        "options": {
            "symlink": true
        }
    }
    ]
```

```bash
# main project
composer upgrade --ignore-platform-req=ext-intl
sail artisan ping:install
```


To Apply Plugin to PANEL add to `Providers/Filamente/AdminPanelProvider.php`

```php
$panel->plugins([
    PingPlugin::make()
])
```


# run queue
sail artisan queue:work
# lint
sail bin duster lint --using=pint -v
```

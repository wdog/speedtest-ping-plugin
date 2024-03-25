
Apply to PANEL


AdminPanelProvider

```php
$panel->plugins([
    PingPlugin::make()
])

```


main composer.json

```

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


## base


```bash
cp .env.example .env
composer install --ignore-platform-req=ext-intl
sail up -d
sail artisan app:install --force



# run queue
sail artisan queue:work
# lint
sail bin duster lint --using=pint -v
```

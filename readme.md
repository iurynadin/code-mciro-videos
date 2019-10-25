## Repositório Curso Micro Serviços Codeeducation

1. dar permissao no arquivo de entrypoint:
```chmod +x ./.docker/entrypoint.sh```

2. Testar o funcionamento da criação dos containers:
```docker logs micro-videos-app```

3. Instalar o barryvdh/laravel-ide-helper
```
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
php artisan ide-helper:models

```
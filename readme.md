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

docker run -it --link micro-videos-db:mysql --rm mysql sh -c 'exec mysql -h"$MYSQL_PORT_3306_TCP_ADDR" -P"$MYSQL_PORT_3306_TCP_PORT" -uroot -p"$MYSQL_ENV_MYSQL_ROOT_PASSWORD"'


### Para Iniciar
1. Buildar os servicos:
```docker-compose up -d --build```

2. Listar o serviços que foram criados:
```docker ps -a```

3. Acessar http://0.0.0.0:8000/

Caso necessite de executar algum comando dentro do container: ```docker exec -it micro-videos-app bash```
ou ```docker-compose exec micro-videos-app bash```

<!-- continues from:  
Implementando recurso de vídeo e rela... (Projeto Prático)
https://portal.code.education/lms/#/168/155/98/conteudos?capitulo=658&conteudo=5803
-->



### Modo transacional
Pegando como exemplo o registro do vídeo, é registrado o video, na sequencia a categoria e por último o gênero. Se no momento de registrar a categoria ou gênero der algum problema, o vídeo é deletado. Ou tudo da certo ou "nao registra".
Auto Commit - Padrão de banco de dados relacionais
Modo Transação. Checkpoints/Savepoints:
- begin transaction - Marca inicio da transação
- transactions - executa todas as transações pertinentes
- commmit - persiste as transações no banco
- rollback - desfaz todas as transações do checkpoint/savepoints
ex:
```
$obj = \DB::transaction(function() use($request, $validatedData){
    $obj = $this->model()::create($validatedData);
    $obj->categories()->sync($request->get('categories_id'));
    $obj->genres()->sync($request->get('genres_id'));
    return $obj;
});
```


<!-- continuar do video: Primeiro API Resource de Category -->
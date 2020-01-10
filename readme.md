Laravel Firebird
===

Package desenvolvido para realizar uma melhor integração entre o Firebird
e os models *Eloquent* do *Laravel*

Este pacote tráz algumas melhoras comparado ao seu projeto inspirador:
[Laravel Firebird](https://github.com/jacquestvanzuydam/laravel-firebird)

Este package corrige a falta de `reconnector`, necessário nas versões mais novas do Laravel,
além de permitir o uso do `auto increment`, seja por generator, seja por incremento
manual da chave primária.

Instalação
---
Para utilização deste package, fazer a instalação via composer:

```bash
$ composer require igrejanet/laravel-firebird
```

Após a instalação, os models devem extender a uma nova classe.

```php
<?php

namespace App\Models;

use Igrejanet\Firebird\FirebirdModel;

class User extends FirebirdModel
{
    protected $primaryKey = 'ID';

    protected $generator = 'GEN_USERS';
}
```

É valido lembrar que, por padrão, as colunas em um banco de dados firebird
são retornadas em *UPPER CASE*. Neste caso, é importante setar a `primary key`
para que o model possa funcionar corretamente.

Caso o model não possua um generator definido, o model irá gerar um ID automaticamente,
baseado no último id + 1;

### Integração com Masterkey Repository
O padrão repository é lindo, não é? Pois bem. Pensando nisso, este package funciona
perfeitamente com o nosso package de repository [Masterkey Repository](https://github.com/MasterkeyInformatica/Repository);

O que muda? Nada. Apenas realize a instalação do package e voila

```bash
$ composer require masterkey/repository:^7.3
```

Versões anteriores não são suportadas e/ou não foram testadas
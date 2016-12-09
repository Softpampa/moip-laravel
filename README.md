# Moip Laravel
Este package permite receber WebHooks do Moip assim como fornece Façades para o [Moip SDK](https://github.com/Softpampa/moip-sdk-php).

## Instalação

Via composer

```
composer require softpampa/moip-laravel
```

## Configuração

`app/config.php`

```php
<?php

'aliases' => array(
    ...
    'MoipPayments'    => 'Softpampa\MoipLaravel\MoipPaymentsFacade',
    'MoipSubscriptions' => 'Softpampa\MoipLaravel\MoipSubscriptionsFacade'
)
```

Para publicar o arquivo de configuração e criar as tabelas. Execute:

```shell 
$ php artisan config:publish softpampa/moip-laravel
$ php artisan migrate --package="softpampa/moip-laravel"
``` 

Importar planos e assinaturas

```shell
$ php artisan moip:import
```

Importar uma assinatura pelo código

```shell
$ php artisan moip:subscription:import $CODE
```

## Utilizando

```php
<?php

use Softpampa\MoipLaravel\Models\MoipCustomer;

class User extends Eloquent {
    
    public function moip()
    {
        return $this->hasOne(MoipCustomer::class, 'user_id', 'id');
    }

}
```

Alguns exemplos

```php
<?php

$user = User::find(1);

// Retorna todas assinaturas do customer
$user->moip->subscriptions->toArray();

// Retorna um assinatura por código
$user->moip->subscriptions()->byCode('882173')->first();

// Retorna o plano de um assinatura
$user->moip->subscriptions()->byCode('882173')->first()->plan;

// Retorna o cliente de um assinatura
$user->moip->subscriptions()->byCode('882173')->first()->customer;
```

## Webhook

Para receber requisições do Moip é necessário configurar a URL de Webhook

```shell
$ php artisan moip:setup
```

### WebTunnel para localhost

Caso a aplicações esteja rodando no localhost é necessário criar um WebTunnel, o [ngrok](https://ngrok.com/) dá conta da situação:

```shell
$ php artisan serve
$ ngrok http 8000

# Informar URL: {subdomain}.ngrok.io/webhook/moip/subscription
$ php artisan moip:setup
```

## Todo

 * Criar controle ao importar dados para existir duplicados;
 * Buscar na API se assinatura, fatura, pagamento ou plano se não existirem no banco de dados.


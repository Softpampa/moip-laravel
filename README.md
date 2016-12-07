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

// Retorna todas assinaturas do customer
User::find(1)->moip->subscriptions->toArray();
```

## Webhook

Para receber requisições do Moip é necessário configurar a URL de Webhook

```shell
$ php artisan moip:setup
```

## WebTunnel para localhost

Caso a aplicações esteja rodando no localhost é necessário criar um WebTunnel, o [ngrok](https://ngrok.com/) dá conta da situação:

```shell
$ php artisan serve
$ ngrok http 8000

# Informar URL: {random}.ngrok.io/webhook/moip/subscription
$ php artisan moip:setup
```



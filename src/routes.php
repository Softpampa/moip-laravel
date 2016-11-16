<?php

Route::post('webhook/moip/subscriptions', ['as' => 'webhook.moip.subscriptions', 'uses' => '\Softpampa\MoipLaravel\Controllers\WebHookController@handle']);
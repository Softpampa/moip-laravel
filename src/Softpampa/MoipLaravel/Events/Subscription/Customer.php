<?php namespace Softpampa\MoipLaravel\Events\Subscription;

use Softpampa\MoipLaravel\Models\MoipCustomerCreditCard;

class Customer {

    public function onCreated($data)
    {
        $resource = $data['resource'];

        if (! empty($resource['billing_info']['credit_cards'])) {
            MoipCustomerCreditCard::create(array_merge($resource['billing_info']['credit_cards'][0], ['customer_code' => $resource['code']]));
        }
    }

    public function onUpdated($data)
    {
        $resource = $data['resource'];

        if (! empty($resource['billing_info']['credit_cards'])) {
            $creditCard = $resource['billing_info']['credit_cards'][0];

            \Log::info('HAS', [MoipCustomerCreditCard::byVault($creditCard['vault'])]);

             if ($card = MoipCustomerCreditCard::byVault($creditCard['vault'])->first()) {
                $card->update([
                    'holder_name' => $creditCard['holder_name'],
                    'first_six_digits' => $creditCard['first_six_digits'],
                    'last_four_digits' => $creditCard['last_four_digits'],
                    'brand' => $creditCard['brand'],
                    'vault' => $creditCard['vault']
                ]);
             } else {
                $this->onCreated($data);
             }
        }
    }

}
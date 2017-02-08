<?php namespace Softpampa\MoipLaravel\Events\Subscription;

use Softpampa\MoipLaravel\models\MoipCustomerCreditCard;

class Customer
{
    /**
     * When customer was created
     *
     * @param  array  $data
     * @return void
     */
    public function onCreated($data)
    {
        $resource = $data['resource'];

        if (! empty($resource['billing_info']['credit_cards'])) {
            $this->addCustomerCreditCard($resource['code'], $resource['billing_info']['credit_cards'][0]);
        }
    }

    /**
     * Add new customer credit card
     *
     * @param  string  $code
     * @param void
     */
    protected function addCustomerCreditCard($code, array $creditCard)
    {
        MoipCustomerCreditCard::create(array_merge($creditCard, ['customer_code' => $code]));
    }

    /**
     * When customer was updated
     *
     * @param  array  $data
     * @return void
     */
    public function onUpdated($data)
    {
        $resource = $data['resource'];
        $creditCard = $resource['billing_info']['credit_cards'][0];

        if (! empty($creditCard)) {
            if ($card = MoipCustomerCreditCard::byVault($creditCard['vault'])->first()) {
                $card->update([
                   'holder_name' => $creditCard['holder_name'],
                   'first_six_digits' => $creditCard['first_six_digits'],
                   'last_four_digits' => $creditCard['last_four_digits'],
                   'brand' => $creditCard['brand'],
                   'vault' => $creditCard['vault']
                ]);
            } else {
                $this->addCustomerCreditCard($resource['code'], $creditCard);
            }
        }
    }
}

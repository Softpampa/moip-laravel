<?php namespace Softpampa\MoipLaravel\Commands\Subscriptions;

use Illuminate\Console\Command;
use Softpampa\MoipLaravel\Models\MoipPlan;
use Softpampa\MoipLaravel\Models\MoipSubscription;
use Symfony\Component\Console\Input\InputArgument;

class MoipSubscriptionImportCommand extends Command
{
    /**
     * Command name
     *
     * @var string
     */
    protected $name = 'moip:subscription:import';

    /**
     * Command description
     *
     * @var string
     */
    protected $description = 'Import Moip API Subscription by code';

    /**
     * Fire command
     *
     * @return void
     */
    public function fire()
    {
        $code = $this->argument('code');
        $subscription = app('moip-subscriptions')->subscriptions()->find($code);

        MoipSubscription::firstOrCreate(json_decode(json_encode($subscription), true));

        $this->info("Imported subscription {$code}!");
    }

    /**
     * Command arguments
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            ['code', InputArgument::REQUIRED]
        ];
    }
}

<?php namespace Softpampa\MoipLaravel\Commands\Subscriptions;

use Illuminate\Console\Command;
use Softpampa\MoipLaravel\Models\MoipPlan;
use Softpampa\MoipLaravel\Models\MoipSubscription;

class MoipImportCommand extends Command {

    /**
     * Command name
     * 
     * @var string
     */
    protected $name = 'moip:import';

    /**
     * Command description
     * 
     * @var string
     */
    protected $description = 'Import data from Moip API';

    /**
     * Fire command
     * 
     * @var void
     */
    public function fire()
    {
        if ($this->confirm('Import plans? [yes|no]')) {
            $this->importPlans();
        }

        if ($this->confirm('Import subscriptions? [yes|no]')) {
            $this->importSubscriptions();
        }
    }

    /**
     * Import plans from Moip API
     * 
     * @return void
     */
    protected function importPlans()
    {
        $plans = app('moip-subscriptions')->plans()->all();

        $this->info("Importing {$plans->count()} plans");

        foreach ($plans as $plan) {
            MoipPlan::create(json_decode(json_encode($plan), true));
        }

        $this->info('Done!');
    }

    /**
     * Import subscriptions from Moip API
     * 
     * @return void
     */
    protected function importSubscriptions()
    {
        $subscriptions = app('moip-subscriptions')->subscriptions()->all();
        
        $this->info("Importing {$subscriptions->count()} plans");

        foreach ($subscriptions as $subscription) {
            MoipSubscription::create(json_decode(json_encode($subscription), true));
        }

        $this->info('Done!');

    }

}
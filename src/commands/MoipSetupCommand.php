<?php namespace Softpampa\MoipLaravel\Commands;

use Illuminate\Console\Command;

class MoipSetupCommand extends Command {

    /**
     * Command name
     * 
     * @var string
     */
    protected $name = 'moip:setup';

    /**
     * Command description
     * 
     * @var string
     */
    protected $description = 'Setup Moip SDK';

    /**
     * Fire command
     * 
     * @var void
     */
    public function fire()
    {
        if ($this->confirm('Do you wish to set Moip webhook? [yes|no]')) {
            $this->setUserPreferences();
        }
    }

    /**
     * Set user preferences
     * 
     * @var void
     */
    protected function setUserPreferences()
    {
        $preferences = app('moip-subscriptions')->preferences();
        $preferences->setWebHook(route('webhook.moip.subscriptions'));
        $preferences->save();

        $this->info('Done!');
    }

}
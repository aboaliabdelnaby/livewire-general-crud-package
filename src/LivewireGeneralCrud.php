<?php

namespace LivewireComponents\GeneralComponents;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use LivewireComponents\GeneralComponents\Providers\GeneralComponentsServiceProvider;

class LivewireGeneralCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livewire:general-crud {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Livewire General Crud';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Installing GeneralCrud...');

        $this->info('Publishing configuration...');

        if (! $this->configExists('GeneralCrud.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration($force = true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }

        $this->info('Installed GeneralCrud');
    }

    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => GeneralComponentsServiceProvider::class,
            '--tag' => "CrudComponents"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }
}

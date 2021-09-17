<?php

namespace App\Console\Commands;

use App\Models\Host;
use App\Service\Xampp;
use Illuminate\Console\Command;

class install extends Command
{
    protected string $envSource;
    protected string $envTarget;
    protected Xampp $xampp;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install or Update App';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {

        $this->envTarget = base_path('.env');
        if (!file_exists($this->envTarget)) {
            $this->info('Create .env file');
            $this->envSource = base_path('.env.example');
            copy($this->envSource, $this->envTarget);

            $this->line(__('.env file created'));
            $this->info(__('Adjust the settings in `:env` if you don\'t have `C:\xampp` as XAMPP installation folder.', ['env' => $this->envTarget]));
            $this->alert(__('Run install again'));

            return 0;
        }


        $errors = $writeErrors = 0;

        $files = [
            config('tool.paths.httpd-xampp-conf'),
            config('tool.paths.httpd-vhosts-conf'),
            config('tool.paths.hosts'),
            config('tool.paths.xampp-path').'\php\php.exe',
            config('tool.paths.xampp-path').'\php\php.ini',
        ];
        $folders = [
            config('tool.paths.xampp-path'),
            config('tool.paths.xampp-path').'\php',
        ];

        foreach ($files as $file) {
            if (!file_exists($file) || !is_file($file)) {
                $this->error(__('File `:file` not found', ['file' => $file]));
                $errors++;
                continue;
            }
            if (!is_writeable($file)) {
                $this->error(__('The file :file is not writeable. Please run the install as administrator', ['file' => $file]));
                $writeErrors++;
            }
        }
        foreach ($folders as $folder) {
            if (!file_exists($folder) || !is_dir($folder)) {
                $this->error(__('Folder `:folder` not found', ['folder' => $folder]));
                $errors++;
            }
        }

        if ($errors || $writeErrors) {
            if ($errors) {
                $this->alert(__('Please set up the .env file and try the install again'));
            }
            return 0;
        }


        $this->install();

        return 0;
    }

    protected function install()
    {
        $this->xampp = new Xampp;

        $this->info(__('Start install...'));

        $this->line(__('Start migration'));
        $this->line(__('Start migration'));
        $this->call('migrate', [
            '--force' => true,
        ]);

        $this->line(__('Configure PHP Versions'));
        $this->xampp->updatePhpVersions();
        sleep(0.5);

        $this->createLocalhost();

        $this->line(__('Update `httpd-xampp.conf'));
        $this->xampp->updateHttpdXamppConfFile();

        $this->line(__('Update `httpd-vhosts.conf`'));
        $this->xampp->updateVhostsConf();

        $this->line(__('Update `host` file'));
        $this->xampp->updateHostFile();

        $this->line(__('Run `Apache` restart'));
        $this->xampp->apacheRestart();

        $this->line(__('Update the `httpd-xampp.conf` file'));

        $this->info(__('Installation completed. (Re)start Apache and open the url :url in your browser.', ['url' => config('app.url')]));
    }

    protected function createLocalhost()
    {
        $hosts = Host::all()->count();
        if (!$hosts) {
            $this->info(__('Create default `localhost` host'));
            $this->call('db:seed', [
                'class' => 'HostSeeder',
                '--force' => true,
            ]);
        }
    }
}

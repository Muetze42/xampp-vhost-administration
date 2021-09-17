<?php

namespace App\Jobs\AppInstaller;

use App\Models\Host;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Helpers\Process;

class ComposerCreateProject implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Host $host;
    protected string $package;
    protected bool $createDB;
    protected ?string $database;
    protected string $composerCmd;
    protected Process $process;

    /**
     * Create a new job instance.
     *
     * @param Host $host
     * @param string $package
     * @param bool $createDB
     * @param null $database
     */
    public function __construct(Host $host, string $package, bool $createDB = false, $database = null)
    {
        $this->host = $host;
        $this->package = $package;
        $this->createDB = $createDB;
        $this->database = $database;
        $this->composerCmd = $host->cmd_composer;
        $this->process = new Process;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!is_dir($this->host->path)) {
            mkdir($this->host->path, 0777, true);
        }

        $command = 'cd '.dirname($this->host->path, 1).' && '.$this->composerCmd.' create-project '.$this->package.' '.basename($this->host->path).' --prefer-dist';
        if (!$this->process->runCommand($command)) {
            return;
        }

        $command = 'cd '.$this->host->path.' && '.$this->composerCmd.' install';
        if (!$this->process->runCommand($command)) {
            return;
        }

        $this->database = !$this->database ? dbName($this->host->name) : $this->database;

        if ($this->createDB) {
            try {
                DB::connection('mysql')->statement('CREATE DATABASE IF NOT EXISTS `'.$this->database.'`');
            } catch (Exception $exception) {
                Log::error($exception);
            }
        }

        $this->processAfterInstall();
    }

    protected function processAfterInstall()
    {
        //
    }
}

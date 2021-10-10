<?php

namespace NormanHuth\VHostTool\Jobs;

use App\Models\Host;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use NormanHuth\VHostTool\Traits\CreateDatabase;
use ZipArchive;

class Unzip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CreateDatabase;

    protected Host $host;
    protected string $file;
    protected bool $createDB;
    protected ?string $database;
    protected ZipArchive $zip;

    /**
     * Create a new job instance.
     *
     * @param Host $host
     * @param string $file
     * @param bool $createDB
     * @param string|null $database
     */
    public function __construct(Host $host, string $file, bool $createDB = false, ?string $database = null)
    {
        $this->host = $host;
        $this->file = $file;
        $this->createDB = $createDB;
        $this->database = $database;
        $this->zip = new ZipArchive;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->createDatabase();
        $res = $this->zip->open($this->file);
        if ($res === true) {
            $this->zip->extractTo($this->host->path);
            $this->zip->close();
        } else {
            Log::error('Unzip Error. File: '.$this->file."\nError Code:");
        }

        $this->processAfterInstall();
    }

    protected function processAfterInstall()
    {
        //
    }
}

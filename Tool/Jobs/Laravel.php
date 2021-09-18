<?php

namespace NormanHuth\VHostTool\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Laravel extends ComposerCreateProject
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected function processAfterInstall()
    {
        $envFile = $this->host->path.'/.env';
        $name = ctype_space($this->host->name) ? '"'.$this->host->name.'"' : $this->host->name;

        replaceInFile('APP_NAME=Laravel', 'APP_NAME="'.$name.'"', $envFile);
        replaceInFile('DB_DATABASE=laravel', 'DB_DATABASE='.$this->database, $envFile);
        replaceInFile('APP_URL=http://localhost', 'APP_URL=http://'.$this->host->domain, $envFile);
        replaceInFile('APP_TIMEZONE=UTC', 'APP_TIMEZONE='.config('tool.installers.default-timezone'), $envFile);
        replaceInFile('APP_LOCALE=en', 'APP_LOCALE='.config('tool.installers.default-locale'), $envFile);

        $this->host->update(['path' => $this->host->path.'\public']);
    }
}

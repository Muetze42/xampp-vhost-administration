<?php

namespace NormanHuth\VHostTool\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WordPress extends Unzip
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected function processAfterInstall()
    {
        $sourceFile = $this->host->path.'/wp-config-sample.php';
        $content = null;
        $lines = explode("\n", file_get_contents($sourceFile));
        foreach ($lines as $line) {
            if (preg_match('/define/', $line) && preg_match('/DB_NAME/', $line)) {
                $content.= 'define( \'DB_NAME\', \''.$this->database.'\' );'."\n";
            } elseif (preg_match('/define/', $line) && preg_match('/DB_PASSWORD/', $line)) {
                $content.= 'define( \'DB_PASSWORD\', \'\' );'."\n";
            } elseif (preg_match('/define/', $line) && preg_match('/DB_USER/', $line)) {
                $content.= 'define( \'DB_USER\', \'root\' );'."\n";
            } else {
                $content.=$line."\n";
            }
        }

        file_put_contents($this->host->path.'/wp-config.php', $content);
    }
}

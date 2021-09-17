<?php


namespace App\Service\Xampp;


use App\Helpers\Process;
use App\Models\Php;

trait PhpVersions
{
    /**
     * Update or create exist PHP versions.
     */
    public function updatePhpVersions()
    {
        $process = new Process;
        $process->disableCommandLogging();
        $process->disableOutputLogging();
        $process->runCommand('cd '.$this->xamppPath.'/php && php -v');
        $output = $process->getOutput();
        $version = $this->getPhpVersion($output);

        Php::updateOrCreate(
            ['path' => winSep($this->xamppPath.'/php')],
            [
                'version'      => $version,
                'default'      => true,
                'cmd_php'      => 'php',
                'cmd_composer' => 'composer',
            ]
        );

        $folders = glob($this->xamppPath.'/*', GLOB_ONLYDIR);
        foreach ($folders as $folder) {
            $basename = basename($folder);
            if (str_starts_with($basename, 'php') && strlen($basename) > 3 && !str_contains($basename, '.')
                && is_file($folder.'\php.exe') && is_file($folder.'\php.ini')) {

                $process = new Process;
                $process->disableCommandLogging();
                $process->disableOutputLogging();
                $process->runCommand('cd '.$folder.' && php -v');
                $output = $process->getOutput();
                $version = $this->getPhpVersion($output);

                Php::updateOrCreate(
                    ['path' => winSep($folder)],
                    [
                        'version'      => $version,
                        'cmd_php'      => 'php'.phpSlug(substr(phpSlug($folder), 3)),
                        'cmd_composer' => 'composer'.phpSlug(substr(phpSlug($folder), 3)),
                    ]
                );
            }
        }
    }

    /**
     * @param array $output
     * @return string
     */
    protected function getPhpVersion(array $output): string
    {
        return explode(' ', $output[0])[1];
    }
}

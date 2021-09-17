<?php


namespace App\Service;


use App\Helpers\Process;
use App\Models\Php;
use App\Service\Xampp\PhpVersions;
use App\Service\Xampp\SetVariables;
use App\Service\Xampp\UpdateHostFile;
use App\Service\Xampp\UpdateVhostsConf;

class Xampp
{
    use SetVariables, UpdateHostFile, UpdateVhostsConf, PhpVersions;

    protected string $xamppPath;
    protected string $httpdXamppConfFile;
    protected string $httpdVhostsConfFile;
    protected string $hostsFile;
    protected bool $tryApacheRestart = true;
    protected string $appHost;

    public function __construct()
    {
        $this->setVariables();
    }

    public function update()
    {
        $this->updateHostFile();
        $this->updateVhostsConf();
        $this->apacheRestart();
    }

    public function updateHttpdXamppConfFile()
    {
        $data = file_get_contents(base_path('stubs/tool/httpd-xampp.stub'));
        $data = str_replace([
            '{{ php-path }}',
            '{{php-path}}',
        ], unixSep($this->xamppPath), $data);
        $data = str_replace('{{ xampp-path }}', unixSep($this->xamppPath), $data);

        $versions = Php::where('default', false)->get();
        foreach ($versions as $version) {
            $alias = file_get_contents(base_path('stubs/tool/httpd-xampp.alias.stub'));
            $replace = [
                '{{ php-path }}'   => unixSep($version->path),
                '{{php-path}}'     => unixSep($version->path),
                '{{ php-slug }}'   => phpSlug($version->path),
                '{{php-slug}}'     => phpSlug($version->path),
                '{{ xampp-path }}' => unixSep($this->xamppPath),
                '{{xampp-path}}'   => unixSep($this->xamppPath),
            ];
            $data.= str_replace(array_keys($replace), array_values($replace), $alias);

            file_put_contents($this->httpdXamppConfFile, $data);
        }
    }

    public function apacheRestart()
    {
        //
    }
}

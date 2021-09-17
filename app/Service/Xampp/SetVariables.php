<?php


namespace App\Service\Xampp;


trait SetVariables
{
    public function setVariables()
    {
        $this->appHost = basename(config('app.url'));
        $this->setXamppPath();
        $this->setHttpdXamppConfFile();
        $this->setHttpdVhostsConfFile();
        $this->setHostsFile();
    }

    public function setXamppPath(?string $path = null)
    {
        if ($path) {
            $this->xamppPath = $path;
            return;
        }
        $this->xamppPath = config('tool.paths.xampp-path');
    }

    public function setHttpdXamppConfFile(?string $path = null)
    {
        if ($path) {
            $this->httpdXamppConfFile = $path;
            return;
        }
        $this->httpdXamppConfFile = config('tool.paths.httpd-xampp-conf');
    }

    public function setHttpdVhostsConfFile(?string $path = null)
    {
        if ($path) {
            $this->httpdVhostsConfFile = $path;
            return;
        }
        $this->httpdVhostsConfFile = config('tool.paths.httpd-vhosts-conf');
    }

    public function setHostsFile(?string $path = null)
    {
        if ($path) {
            $this->hostsFile = $path;
            return;
        }
        $this->hostsFile = config('tool.paths.hosts');
    }
}

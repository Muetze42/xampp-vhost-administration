<?php


namespace App\Service\Xampp;


use App\Models\Host;
use App\Models\Php;

trait UpdateVhostsConf
{
    public function updateVhostsConf()
    {
        $hosts = Host::all();

        $data = '';

        foreach ($hosts as $host) {
            $data.= $this->addVirtualHost($host);
            foreach ($host->subdomains as $subdomain) {
                $data.= $this->addVirtualHost($host, $subdomain);
            }
        }

        $data.= $this->addToolHost();

        file_put_contents($this->httpdVhostsConfFile, $data);
    }

    protected function addVirtualHost(Host $host, ?string $subdomain = null): string
    {
        $stub = !empty($host->php) && $host->php->default ? 'vhost.stub' : 'vhost.cgi.stub';
        $content = file_get_contents(base_path('stubs/tool/'.$stub));

        $replace = [
            '{{ host }}'       => $subdomain ? $subdomain.'.'.$host->domain : $host->domain,
            '{{host}}'         => $subdomain ? $subdomain.'.'.$host->domain : $host->domain,
            '{{ path }}'       => $host->path,
            '{{path}}'         => $host->path,
            '{{ xampp-path }}' => $this->xamppPath,
            '{{xampp-path}}'   => $this->xamppPath,
            '{{ php-slug }}'   => phpSlug($host->php->path),
            '{{php-slug}}'     => phpSlug($host->php->path),
        ];

        return str_replace(array_keys($replace), array_values($replace), $content);
    }

    protected function addToolHost(): string
    {
        $content = file_get_contents(base_path('stubs/tool/vhost.stub'));

        $php = Php::where('default', true)->first();

        $replace = [
            '{{ host }}'       => $this->appHost,
            '{{host}}'         => $this->appHost,
            '{{ path }}'       => winSep(base_path('public')),
            '{{path}}'         => winSep(base_path('public')),
            '{{ xampp-path }}' => $this->xamppPath,
            '{{xampp-path}}'   => $this->xamppPath,
            '{{ php-slug }}'   => phpSlug($php->path),
            '{{php-slug}}'     => phpSlug($php->path),
        ];

        return str_replace(array_keys($replace), array_values($replace), $content);
    }
}

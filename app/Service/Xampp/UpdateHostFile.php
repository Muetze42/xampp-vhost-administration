<?php


namespace App\Service\Xampp;


use App\Models\Host;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

trait UpdateHostFile
{
    public int $spacing = 2;
    public array $skipLines = [
        '# Virtual Hosts by Xampp',
        '# End of Virtual Hosts by Xampp',
    ];

    public function updateHostFile()
    {
        $source = file_get_contents($this->hostsFile);
        $data = '';
        $xamppData = '';

        $lines = explode("\n", $source);

        $neededHosts[] = basename(config('app.url'));
        $hosts = Host::all();

        $remove = [];
        $cache = Cache::get('remove');

        if (!empty($cache)) {
            $remove = $cache;
        }

        foreach ($hosts as $host) {
            $neededHosts[] = $host->domain;
            foreach ($host->subdomains as $subdomain) {
                $neededHosts[] = $subdomain.'.'.$host->domain;
            }
        }

        foreach ($lines as $line)
        {
            if (in_array(trim($line), $this->skipLines)) {
                continue;
            }

            $clean = prepareLine($line);
            $parts = explode(' ', $clean);

            if (!empty($parts[1]) && $parts[0] == '127.0.0.1') {
                if (in_array($parts[1], $neededHosts) || in_array($parts[1], $remove)) {
                    continue;
                }
            }

            $data.= $line."\n";
        }

        $longest = longestArrayValue($neededHosts);

        foreach ($hosts as $host) {
            $xamppData.= "127.0.0.1\t".$host->domain;
            if ($host->name != $host->domain) {
                $xamppData.= str_repeat(' ', $longest-strlen($host->domain)+$this->spacing);
                $xamppData.= '# '.$host->name;
            }
            $xamppData.= "\n";

            foreach ($host->subdomains as $subdomain) {
                $domain = $subdomain.'.'.$host->domain;
                $xamppData.= "127.0.0.1\t".$domain;

                $xamppData.= str_repeat(' ', $longest-strlen($domain)+$this->spacing);
                $xamppData.= '# [Subdomain of '.$host->name.']';

                $xamppData.= "\n";
            }
        }

        $xamppData.= "127.0.0.1\t".$this->appHost."\t# VHostTool";

        $content = "# Virtual Hosts by Xampp\n";
        $content.= $xamppData;
        $content.= "\n# End of Virtual Hosts by Xampp\n\n";
        $content.= trim($data);
        $content = preg_replace('/^\s+/m', "\n", $content);

        file_put_contents($this->hostsFile,  $content."\n");
        Cache::forget('remove');
    }
}

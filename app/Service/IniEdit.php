<?php


namespace App\Service;


class IniEdit
{
    protected string $file;
    protected string $content;
    protected array|false $parse;

    public function __construct(string $file)
    {
        $this->file = $file;
        $this->parse = parse_ini_file($file);
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function getValue(string $key): ?string
    {
        return $this->parse[$key] ?? null;
    }

    public function update(array $attributes)
    {
        $contents = file_get_contents($this->file);
        $lines = explode("\n", $contents);
        $data = '';

        foreach ($lines as $line) {
            $key = trim(explode('=', $line)[0]);
            if (isset($attributes[$key])) {
                $data.= $key.'='.$attributes[$key]."\n";
                continue;
            }
            $data.= $line."\n";
        }

        file_put_contents($this->file, trim($data));
    }
}

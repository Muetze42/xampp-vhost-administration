<?php

namespace NormanHuth\VHostTool\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

trait CreateDatabase
{
    protected function createDatabase()
    {
        $this->database = !$this->database ? dbName($this->host->name) : $this->database;

        if ($this->createDB) {
            try {
                DB::connection('mysql')->statement('CREATE DATABASE IF NOT EXISTS `'.$this->database.'`');
            } catch (Exception $exception) {
                Log::error($exception);
            }
        }
    }
}

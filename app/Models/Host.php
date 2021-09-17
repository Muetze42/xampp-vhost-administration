<?php

namespace App\Models;

use App\Service\Xampp;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Cache;

class Host extends Model
{
    use HasFactory;

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'subdomains' => 'array',
    ];

    /**
     * @param Builder $query
     * @param string $column
     * @param string $direction
     * @return Builder
     */
    public function scopeOrderBy(Builder  $query, string $column, string $direction = 'asc'): Builder
    {
        if ($this->connection == 'sqlite' || (!$this->connection && config('database.default') == 'sqlite')) {
            return $query->orderByRaw($column.' COLLATE NOCASE '.$direction);
        }

        return $query->orderByRaw($column.' '.$direction);
    }

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($host) {
            if (!$host->name) {
                $host->name = $host->domain;
            }
        });
        static::updated(function($host) {
            $remove = [];
            if ($host->domain != $host->getOriginal('domain')) {
                $remove[] = $host->getOriginal('domain');

                foreach ($host->getOriginal('subdomains') as $subdomain) {
                    $remove[] = $subdomain.'.'.$host->getOriginal('domain');
                }
            }
            if ($host->subdomains != $host->getOriginal('subdomains')) {
                foreach ($host->getOriginal('subdomains') as $old) {
                    if (!in_array($old, $host->subdomains)) {
                        $remove[] = $old.'.'.$host->getOriginal('domain');
                    }
                }
            }
            if (count($remove)) {
                Cache::put('remove', $remove, 60);
            }

            (new Xampp)->update();
        });
        static::created(function() {
            (new Xampp)->update();
        });
        static::deleted(function($host) {
            $remove[] = $host->domain;
            foreach ($host->subdomains as $subdomain) {
                $remove[] = $subdomain.'.'.$host->domain;
            }
            Cache::put('remove', $remove,  60);

            (new Xampp)->update();
        });
    }

    /**
     * Get the PHP model that owns the host.
     */
    public function php(): BelongsTo
    {
        return $this->belongsTo(Php::class);
    }
}

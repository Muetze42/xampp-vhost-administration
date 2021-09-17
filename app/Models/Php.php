<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Php extends Model
{
    use HasFactory;

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the hosts for the php version.
     */
    public function hosts(): HasMany
    {
        return $this->hasMany(Host::class);
    }
}

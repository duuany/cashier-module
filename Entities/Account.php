<?php

namespace Modules\Cashier\Entities;

use Balping\HashSlug\HasHashSlug;
use Duuany\EloquentFilters\Concerns\HasFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Account extends Model
{
    use HasHashSlug, HasFilters, PresentableTrait, SoftDeletes;

    protected $presenter = null;

    protected $fillable = [
        'store_id',
        'title',
        'description'
    ];

    protected $dates = ['deleted_at'];

    public function cashiers()
    {
        return $this->hasMany(Cashier::class);
    }
}

<?php

namespace Modules\Cashier\Entities;

use Balping\HashSlug\HasHashSlug;
use Duuany\EloquentFilters\Concerns\HasFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use Modules\Cashier\Presenters\CashierPresenter;

class Cashier extends Model
{
    use HasHashSlug, HasFilters, PresentableTrait, SoftDeletes;

    protected $presenter = CashierPresenter::class;

    protected static $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    protected $fillable = [
        'account_id',
        'description',
        'cashier_type',
        'amount',
        'pay_at',
        'billed_at'
    ];

    protected $dates = ['billed_at', 'pay_at', 'deleted_at'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = intval(preg_replace('/\D/', '', $value));
    }
}

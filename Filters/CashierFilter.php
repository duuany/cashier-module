<?php

namespace Modules\Cashier\Filters;

use Carbon\Carbon;
use Duuany\EloquentFilters\EloquentFilters;

class CashierFilter extends EloquentFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array $filters
     */
    protected $filters = ['month', 'year'];
    protected $delimiter = ';';

    protected function month($value)
    {
        if(!empty($value)) {
            $firstMonthDay = Carbon::now()->month($value)->firstOfMonth()->toDateString();
            $lastMonthDay = Carbon::now()->month($value)->lastOfMonth()->toDateString();
        } else {
            $firstMonthDay = Carbon::now()->firstOfMonth()->toDateString();
            $lastMonthDay = Carbon::now()->lastOfMonth()->toDateString();
        }

        $this->whereBetween('billed_at', [$firstMonthDay, $lastMonthDay]);
    }

    protected function year($value)
    {
        if(!$value) {
            return null;
        }

        $this->whereYear('billed_at', $value);
    }
}
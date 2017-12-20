<?php

use Carbon\Carbon;
use Faker\Generator as Faker;
use Modules\Cashier\Entities\Account;
use Modules\Cashier\Entities\Cashier;

$factory->define(Cashier::class, function (Faker $faker) {
    return [
        'account_id' => Account::all()->random()->id,
        'description' => $faker->sentence,
        'cashier_type' => $faker->randomElement(['inbound', 'outbound']),
        'amount' => $faker->numberBetween(999, 999999),
        'billed_at' => Carbon::today()->toDateString()
    ];
});

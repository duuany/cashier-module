<?php

use App\Store;
use Faker\Generator as Faker;
use Modules\Cashier\Entities\Account;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'store_id' => Store::all()->random()->id,
        'title' => $faker->word,
        'description' => $faker->sentence
    ];
});

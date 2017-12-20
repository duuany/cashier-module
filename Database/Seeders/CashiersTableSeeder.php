<?php
namespace Modules\Cashier\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cashier\Entities\Cashier;

class CashiersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cashier::class, 2)->create();

        factory(Cashier::class, 2)->create([
            'cashier_type' => 'inbound',
            'pay_at' => \Carbon\Carbon::now()->addDays(2),
            'billed_at' => null
        ]);

        factory(Cashier::class, 2)->create([
            'cashier_type' => 'outbound',
            'pay_at' => \Carbon\Carbon::now()->addMonth(2),
            'billed_at' => null
        ]);

    }
}

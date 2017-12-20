<?php
namespace Modules\Cashier\Database\Seeders;

use App\Store;
use Illuminate\Database\Seeder;
use Modules\Cashier\Entities\Account;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::all()->each(function ($store) {
            factory(Account::class)->create([
                'store_id' => $store->id,
                'title' => 'Caixa da Empresa',
                'description' => 'Caixa padrão da empresa'
            ]);
        });
    }
}

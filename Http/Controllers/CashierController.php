<?php

namespace Modules\Cashier\Http\Controllers;

use Modules\Cashier\Entities\Account;
use Modules\Cashier\Entities\Cashier;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Cashier\Filters\CashierFilter;
use Modules\Cashier\Http\Requests\CashierFormRequest;

class CashierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(CashierFilter $filters)
    {
        $account = Account::where('store_id', auth()->user()->store->id)->first();
        $cashiers = Cashier::filter($filters)
                           ->where('account_id', $account->id)
                           ->whereNotNull('billed_at');

        $credits = Cashier::where('account_id', $account->id)
                          ->whereNull('billed_at')
                          ->where('cashier_type', 'inbound')
                          ->sum('amount');

        $debits = Cashier::where('account_id', $account->id)
                         ->whereNull('billed_at')
                         ->where('cashier_type', 'outbound')
                         ->sum('amount');

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        $month = request('month') ?: Carbon::now()->month;
        $selectedMonth = mb_strtoupper(Carbon::now()->month($month)->formatLocalized('%B'));
        $selectedYear = request('year') ?: Carbon::now()->year;

        $cashiersCollection = $cashiers->get();
        $monthInbounds = $cashiersCollection->where('cashier_type', 'inbound');
        $monthOutbounds = $cashiersCollection->where('cashier_type', 'outbound');

        $totalInbounds = number_format($monthInbounds->sum('amount') / 100, 2, ',', '.');
        $totalOutbounds = number_format($monthOutbounds->sum('amount') / 100, 2, ',', '.');
        $profit = number_format(($monthInbounds->sum('amount') - $monthOutbounds->sum('amount')) / 100, 2, ',', '.');

        $cashiers = $cashiers->paginate();

        return view('cashier::index', compact(
                'account',
                'cashiers',
                'monthInbounds',
                'monthOutbounds',
                'totalInbounds',
                'totalOutbounds',
                'profit',
                'selectedMonth',
                'selectedYear',
                'credits',
                'debits'
            )
        );
    }

    public function edit(Cashier $cashier)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $currentMonth = Carbon::now()->month;
        $accounts = Account::where('store_id', auth()->user()->store->id)->get();
        return view('cashier::edit', compact('cashier', 'accounts', 'currentMonth'));
    }

    public function update(Cashier $cashier, CashierFormRequest $request)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $cashier->update($request->all());

        flash()->success('Conta atualizada com sucesso.');

        return redirect()->route('cashiers.edit', $cashier);
    }

    public function delete(Cashier $cashier)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $currentMonth = Carbon::now()->month;
        $redirect = route('cashiers.index', ['month' => $currentMonth]);
        return view('cashier::delete', compact('cashier', 'redirect'));
    }

    public function destroy(Cashier $cashier)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $cashier->delete();

        flash()->info('Caixa excluído, OK.');

        $currentMonth = Carbon::now()->month;
        return redirect()->route('cashiers.index', ['month' => $currentMonth]);
    }

    protected function deniesRequest()
    {
        flash()->error('Erro ao processar solicitação.');
        return redirect()->route('cashiers.debit.index');
    }
}

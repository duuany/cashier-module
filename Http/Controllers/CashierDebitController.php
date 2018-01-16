<?php

namespace Modules\Cashier\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Cashier\Entities\Account;
use Modules\Cashier\Entities\Cashier;
use Modules\Cashier\Http\Requests\CashierFormRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CashierDebitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $account = Account::where('store_id', auth()->user()->store->id)->first();

        $cashiers = Cashier::where('account_id', $account->id)
            ->where('cashier_type', 'outbound')
            ->whereNotNull('pay_at')
            ->paginate();

        return view('cashier::debit.index', compact('cashiers', 'currentMonth'));
    }

    public function create()
    {
        $accounts = Account::where('store_id', auth()->user()->store->id)->get();
        $cashier = new Cashier;
        return view('cashier::debit.create', compact('cashier', 'accounts'));
    }

    public function store(CashierFormRequest $request)
    {
        $request['cashier_type'] = 'outbound';
        Cashier::create($request->all());

        flash()->success('Conta a Pagar adicionada com sucesso.');

        return redirect()->route('cashiers.debit.index');
    }

    public function edit(Cashier $cashier)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $accounts = Account::where('store_id', auth()->user()->store->id)->get();
        return view('cashier::debit.edit', compact('cashier', 'accounts'));
    }

    public function update(Cashier $cashier, CashierFormRequest $request)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $cashier->update($request->all());

        flash()->success('Conta a Pagar atualizada com sucesso.');

        return redirect()->route('cashiers.debit.index');
    }

    public function paid(Cashier $cashier, Request $request)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $cashier->update($request->only('billed_at'));

        flash()->info('Conta a Pagar marcada como paga com sucesso.');

        return redirect()->route('cashiers.debit.index');
    }

    public function unpaid(Cashier $cashier)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $cashier->update(['billed_at' => null]);

        flash()->info('Conta a Pagar marcada como não paga.');

        return redirect()->route('cashiers.debit.index');
    }

    public function delete(Cashier $cashier)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $redirect = route('cashiers.debit.index');
        return view('cashier::debit.delete', compact('cashier', 'redirect'));
    }

    public function destroy(Cashier $cashier)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $cashier->delete();

        flash()->info('Conta a Pagar removida com sucesso.');

        return redirect()->route('cashiers.debit.index');
    }
    
    protected function deniesRequest()
    {
        flash()->error('Erro ao processar solicitação.');
        return redirect()->route('cashiers.debit.index');
    }
}

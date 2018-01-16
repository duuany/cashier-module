<?php

namespace Modules\Cashier\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Cashier\Entities\Account;
use Modules\Cashier\Entities\Cashier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Cashier\Http\Requests\CashierFormRequest;

class CashierCreditController extends Controller
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
            ->where('cashier_type', 'inbound')
            ->whereNotNull('pay_at')
            ->paginate();

        return view('cashier::credit.index', compact('cashiers', 'currentMonth'));
    }

    public function create()
    {
        $accounts = Account::where('store_id', auth()->user()->store->id)->get();
        $cashier = new Cashier;
        return view('cashier::credit.create', compact('cashier', 'accounts'));
    }

    public function store(CashierFormRequest $request)
    {
        $request['cashier_type'] = 'inbound';
        Cashier::create($request->all());

        flash()->success('Conta a receber adicionada com sucesso.');

        return redirect()->route('cashiers.credit.index');
    }

    public function edit(Cashier $cashier)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $accounts = Account::where('store_id', auth()->user()->store->id)->get();
        return view('cashier::credit.edit', compact('cashier', 'accounts'));
    }

    public function update(Cashier $cashier, CashierFormRequest $request)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $cashier->update($request->all());

        flash()->success('Conta a receber atualizada com sucesso.');

        return redirect()->route('cashiers.credit.index');
    }

    public function paid(Cashier $cashier, Request $request)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $cashier->update($request->only('billed_at'));

        flash()->info('Conta a Receber marcada como recebida com sucesso.');

        return redirect()->route('cashiers.credit.index');
    }

    public function unpaid(Cashier $cashier)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $cashier->update(['billed_at' => null]);

        flash()->info('Conta a Receber marcada como não recebida.');

        return redirect()->route('cashiers.credit.index');
    }

    public function delete(Cashier $cashier)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $redirect = route('cashiers.credit.index');
        return view('cashier::credit.delete', compact('cashier', 'redirect'));
    }

    public function destroy(Cashier $cashier)
    {
        if(Gate::denies('cashier.authorization', $cashier)) {
            return $this->deniesRequest();
        }

        $cashier->delete();

        flash()->info('Conta a Receber removida com sucesso.');

        return redirect()->route('cashiers.credit.index');
    }

    protected function deniesRequest()
    {
        flash()->error('Erro ao processar solicitação.');
        return redirect()->route('cashiers.credit.index');
    }
}

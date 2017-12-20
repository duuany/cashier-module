<?php

namespace Modules\Cashier\Http\Controllers;

use Modules\Cashier\Entities\Account;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Cashier\Http\Requests\AccountFormRequest;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $accounts = Account::where('store_id', auth()->user()->store->id)->paginate();

        return view('accounts.index', compact('accounts'));
    }

    public function store(AccountFormRequest $request)
    {
        auth()->user()->store->accounts()->save(
            Account::make($request->all())
        );

        flash()->success('Conta criada com sucesso.');

        return redirect()->route('accounts.index');
    }

    public function delete(Account $account)
    {
        return view('accounts.delete', compact('account'));
    }

    public function destroy(Account $account)
    {
        if(Gate::denies('account.authorization', $account)) {
            return $this->deniesRequest();
        }

        $account->delete();

        flash()->info('Conta removida com sucesso.');

        return redirect()->route('accounts.index');
    }

    protected function deniesRequest()
    {
        flash()->error('Erro ao processar solicitação. Recurso ou link não existe.');
        return redirect()->route('home');
    }
}

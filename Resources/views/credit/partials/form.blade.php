<div class="form-group {{ $errors->has('description') ? 'has-error': '' }}">
    <label for="description" class="input-control">Descrição</label>
    <input placeholder="Descreva o que será recebido" type="text" name="description" id="description" class="form-control" value="{{ old('description', $cashier->description) }}" />
    @if($errors->has('description'))
        <span class="help-block">{{ $errors->first('description') }}</span>
    @endif
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('account_id') ? 'has-error': '' }}">
            <label for="account_id" class="input-control">Conta:</label>
            <select name="account_id" id="accounts" class="form-control">
                <option value="">-- Selecione uma conta --</option>
                @foreach($accounts as $account)
                    <option @if(old('account_id', $cashier->account_id) == $account->id) selected @endif
                    value="{{ $account->id }}"
                    >{{ $account->title }}</option>
                @endforeach
            </select>
            @if($errors->has('account_id'))
                <span class="help-block">{{ $errors->first('account_id') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('amount') ? 'has-error': '' }}">
            <label for="amount" class="input-control">Valor R$</label>
            <input placeholder="0,00" type="text" name="amount" id="amount" class="form-control"
                   value="{{ old('amount', $cashier->present()->amountValue ) }}" />
            @if($errors->has('amount'))
                <span class="help-block">{{ $errors->first('amount') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('pay_at') ? 'has-error': '' }}">
            <label for="pay_at" class="input-control">Data a Receber:</label>
            <input type="date"
                   name="pay_at"
                   id="pay_at"
                   class="form-control"
                   value="{{ old('pay_at', optional($cashier->pay_at)->toDateString()) }}"
            />
            @if($errors->has('pay_at'))
                <span class="help-block">{{ $errors->first('pay_at') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="charged">Marcar como recebido?</label>
            <select name="charged" id="charged" class="form-control">
                <option value="">Não</option>
                <option value="1">Sim</option>
            </select>
        </div>
    </div>
</div>
@extends('layouts.app')

@section('content')

    @include('flash::message')
    @include('cashier::partials.error_alert')

    <h3>
        <i class="glyphicon glyphicon-usd"></i>
        Caixa @if(request()->has('month'))(<span class="text-uppercase">{{ $selectedMonth }}/{{ $selectedYear }}</span>)@endif
    </h3>
    <hr />

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-9">
                <form action="{{ route('cashiers.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-addon">Mês Referência</span>
                        <select name="month" id="month" class="form-control">
                            <option value="">-- Selecione um mês --</option>
                            <option value="1" @if(request('month') == 1) selected @endif>JANEIRO</option>
                            <option value="2" @if(request('month') == 2) selected @endif>FEVEREIRO</option>
                            <option value="3" @if(request('month') == 3) selected @endif>MARÇO</option>
                            <option value="4" @if(request('month') == 4) selected @endif>ABRIL</option>
                            <option value="5" @if(request('month') == 5) selected @endif>MAIO</option>
                            <option value="6" @if(request('month') == 6) selected @endif>JUNHO</option>
                            <option value="7" @if(request('month') == 7) selected @endif>JULHO</option>
                            <option value="8" @if(request('month') == 8) selected @endif>AGOSTO</option>
                            <option value="9" @if(request('month') == 9) selected @endif>SETEMBRO</option>
                            <option value="10" @if(request('month') == 10) selected @endif>OUTUBRO</option>
                            <option value="11" @if(request('month') == 11) selected @endif>NOVEMBRO</option>
                            <option value="12" @if(request('month') == 12) selected @endif>DEZEMBRO</option>
                        </select>
                        <span class="input-group-addon">Ano Referência</span>
                        <input class="form-control"
                               size="4"
                               type="text"
                               maxlength="4"
                               minlength="4"
                               name="year"
                               placeholder="{{ $selectedYear }}"
                               value="{{ request('year') }}"
                        >
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Selecionar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <a class="btn btn-primary btn-block disabled">
                    <i class="glyphicon glyphicon-search"></i>
                    Busca Avançada
                </a>
            </div>
            {{--<div class="col-md-9">--}}
                {{--<br />--}}
                {{--<form action="{{ route('cashiers.index') }}" method="GET">--}}
                    {{--<div class="input-group">--}}
                        {{--<span class="input-group-addon">Início</span>--}}
                        {{--<input type="date" name="start" id="between_start" class="form-control">--}}
                        {{--<span class="input-group-addon">Fim</span>--}}
                        {{--<input type="date" name="end" id="between_end" class="form-control">--}}
                        {{--<div class="input-group-btn">--}}
                            {{--<button type="submit" class="btn btn-primary">Filtrar</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
        </div>
    </div>

    @if(request()->has('month'))
    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <p><strong>Total Receitas do Mês</strong></p>
                    <h3 class="text-success"><strong>R$ {{ $totalInbounds }}</strong></h3>
                </div>
                <div class="col-md-3">
                    <p><strong>Total Despesas do Mês</strong></p>
                    <h3 class="text-danger"><strong>R$ {{ $totalOutbounds }}</strong></h3>
                </div>
                <div class="col-md-3">
                    <p><strong>Lucro Líquido do Mês</strong></p>
                    <h3 class="text-primary"><strong>R$ {{ $profit }}</strong></h3>
                </div>
                <div class="col-md-3">
                    <p><strong>Conta</strong></p>
                    <h4><strong>{{ $account->title }}</strong></h4>
                </div>
            </div>
        </div>
    </div>
    <hr />
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-danger">
                <div class="panel-heading">Total Contas a Pagar</div>
                <div class="panel-body">
                    <h4 class="text-center">R$ {{ number_format($debits / 100, 2, ',','.') }}</h4>
                    <a href="{{ route('cashiers.debit.index') }}" class="btn btn-danger btn-block">
                        <i class="glyphicon glyphicon-circle-arrow-down"></i>
                        Contas a Pagar
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">Total Contas a Receber</div>
                <div class="panel-body">
                    <h4 class="text-center">R$ {{ number_format($credits / 100, 2, ',','.') }}</h4>
                    <a href="{{ route('cashiers.credit.index') }}" class="btn btn-success btn-block">
                        <i class="glyphicon glyphicon-circle-arrow-up"></i>
                        Contas a Receber
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    @if(request()->has('month'))
                        @if(count($cashiers))
                            @include('cashier::partials.list')
                        @else
                            <h3>Não há registros para o mês de <strong>{{ $selectedMonth }}</strong>.</h3>
                            <p>
                                <small>Selecione outro mês na lista <strong>Mês Referencia</strong>.</small>
                            </p>
                        @endif
                    @else
                        <small>Para obter os registros de receitas e despesas do mês selecionado.</small>
                        <h3>Selecione um mês de referência e clique em <strong>selecionar</strong>.</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
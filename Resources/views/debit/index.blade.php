@extends('layouts.app')

@section('content')

    @include('flash::message')
    @include('cashier::partials.error_alert')

    <h3>
        <i class="glyphicon glyphicon-circle-arrow-down"></i>
        Contas a Pagar
        <a href="{{ route('cashiers.index', ['month' => $currentMonth]) }}" class="btn-link" title="Voltar para Caixa Mensal">
            <i class="glyphicon glyphicon-share-alt"></i>
        </a>
        <div class="col-md-3 pull-right">
            <a href="{{ route('cashiers.debit.create') }}" class="btn btn-primary btn-block">
                <i class="glyphicon glyphicon-plus"></i>
                Adicionar Conta a Pagar
            </a>
        </div>
    </h3>
    <hr />

    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
            @include('cashier::debit.partials.list')
        </div>
    </div>

@endsection
@extends('layouts.app')

@section('content')

    @include('flash::message')
    @include('cashier::partials.error_alert')

    <h3>
        <i class="glyphicon glyphicon-circle-arrow-down"></i>
        Editar Conta a Pagar
        <a href="{{ route('cashiers.debit.index') }}" class="btn-link" title="Voltar para Contas a Receber">
            <i class="glyphicon glyphicon-share-alt"></i>
        </a>
    </h3>
    <hr />
    <form action="{{ route('cashiers.debit.update', $cashier) }}" method="POST">
        {{ csrf_field() }}
        <div class="panel panel-success">
            <div class="panel-heading"></div>
            <div class="panel-body">
                @include('cashier::debit.partials.form')
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="glyphicon glyphicon-save"></i>
                            Atualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
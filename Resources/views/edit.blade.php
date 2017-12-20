@extends('layouts.app')

@section('content')

    @include('flash::message')
    @include('cashier::partials.error_alert')

    <h3>
        <i class="glyphicon glyphicon-usd"></i>
        Editar Registro de Caixa
        <a href="{{ route('cashiers.index', ['month' => $currentMonth]) }}" class="btn-link" title="Voltar para Caixa">
            <i class="glyphicon glyphicon-share-alt"></i>
        </a>
    </h3>
    <hr />
    <form action="{{ route('cashiers.update', $cashier) }}" method="POST">
        {{ csrf_field() }}
        <div class="panel panel-success">
            <div class="panel-heading"></div>
            <div class="panel-body">
                @include('cashier::partials.form')
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
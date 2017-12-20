@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h3>Deseja remover a Conta a Receber</h3>
        <h4><strong>{{ $cashier->description }}</strong> no valor de <strong>R$ {{ $cashier->present()->amountValue }}</strong>?</h4>
        <hr/>
        <div class="row">
            <div class="col-md-3 col-md-offset-3">
                <form action="{{ route('cashiers.credit.destroy', $cashier) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger btn-block">
                        <i class="glyphicon glyphicon-trash"></i>
                        SIM! REMOVER
                    </button>
                </form>
            </div>
            <div class="col-md-3">
                <a href="{{ $redirect }}" class="btn btn-default btn-block">
                    <i class="glyphicon glyphicon-arrow-left"></i>
                    NAO! CANCELAR
                </a>
            </div>
        </div>
    </div>

@endsection
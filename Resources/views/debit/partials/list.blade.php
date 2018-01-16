<table class="table table-hover table-striped">
    <thead>
    <tr>
        <th>Descrição</th>
        <th>Tipo</th>
        <th class="text-right">Valor R$</th>
        <th class="text-right">Data Pagto.</th>
        <th class="text-right">Data a Pagar</th>
        <th>Status</th>
        <th width="1%"></th>
        <th width="1%"></th>
        <th width="1%"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($cashiers as $cashier)
        <tr>
            <td title="{{ $cashier->description }}">{{ $cashier->present()->truncateDescription }}</td>
            <td nowrap>
                <i class="glyphicon {{ $cashier->present()->typeIcon }} text-{{ $cashier->present()->typeColor }}"></i>
                {{ $cashier->present()->type }}
            </td>
            <td align="right" nowrap><strong>{{ $cashier->present()->amountValue }}</strong></td>
            <td align="right" nowrap>{{ $cashier->present()->billedDate }}</td>
            <td align="right" nowrap>{{ $cashier->present()->payatDate }}</td>
            <td>
                {{ $cashier->present()->status }}
            </td>
            <td>
                @if(is_null($cashier->billed_at))
                    @include('cashier::partials.modal', [
                        'title' => 'Indique a Data de Pagamento',
                        'labelText' => 'Data do Pagamento:',
                        'route' => 'cashiers.debit.paid',
                        'modal_id' => 'cash_' . $cashier->slug(),
                        'buttonTitle' => 'Pagar'
                    ])
                @else
                    <form action="{{ route('cashiers.debit.unpaid', $cashier) }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-xs btn-default" type="submit" title="Cancelar Pagamento">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                        </button>
                    </form>
                @endif
            </td>
            <td>
                <a href="{{ route('cashiers.debit.edit', $cashier) }}"
                   class="btn btn-xs btn-success"
                   title="Editar Pagamento">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td>
                <a href="{{ route('cashiers.debit.delete', $cashier) }}" class="btn btn-xs btn-danger" title="Remover Pagamento">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $cashiers->appends(request()->query())->links() }}
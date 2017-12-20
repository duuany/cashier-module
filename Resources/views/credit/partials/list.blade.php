<table class="table table-hover table-striped">
    <thead>
    <tr>
        <th>Descrição</th>
        <th>Tipo</th>
        <th class="text-right">Valor R$</th>
        <th class="text-right">Data Pagto.</th>
        <th class="text-right">Data a Receber</th>
        <th>Situação</th>
        <th width="1%"></th>
        <th width="1%"></th>
        <th width="1%"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($cashiers as $cashier)
        <tr>
            <td title="{{ $cashier->description }}">{{ $cashier->description }}</td>
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
                        'title' => 'Indique a Data do Recebimento',
                        'labelText' => 'Data do Recebimento:',
                        'route' => 'cashiers.credit.paid',
                        'modal_id' => 'cash_' . $cashier->slug(),
                        'buttonTitle' => 'Receber'
                    ])
                @else
                    <form action="{{ route('cashiers.credit.unpaid', $cashier) }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-xs btn-default" type="submit" title="Cancelar Recebimento">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                        </button>
                    </form>
                @endif
            </td>
            <td>
                <a href="{{ route('cashiers.credit.edit', $cashier) }}"
                   class="btn btn-xs btn-success"
                   title="Editar Recebimento">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td>
                <a href="{{ route('cashiers.credit.delete', $cashier) }}" class="btn btn-xs btn-danger" title="Remover Recebimento">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

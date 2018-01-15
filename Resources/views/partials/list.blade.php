<table class="table table-hover table-striped">
    <thead>
    <tr>
        <th>Descrição</th>
        <th>Tipo</th>
        <th class="text-right">Valor R$</th>
        <th class="text-right">Data Lançamento</th>
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
                <td>
                    <a href="{{ route('cashiers.edit', $cashier) }}" class="btn btn-xs btn-success" title="Editar Registro">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </a>
                </td>
                <td>
                    <a href="{{ route('cashiers.delete', $cashier) }}" class="btn btn-xs btn-danger" title="Remover Registro">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $cashiers->appends(request()->query())->links() }}

<button class="btn btn-xs btn-warning"
        type="button"
        title="{{ $buttonTitle }}"
        data-toggle="modal" data-target="#{{ $modal_id }}"
>
    <i class="glyphicon glyphicon-usd"></i>
</button>
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                ><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $title }}</h4>
            </div>
            <form action="{{ route($route, $cashier) }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('billed_at') ? 'has-error': '' }}">
                                <label for="billed_at" class="input-control">{{ $labelText }}</label>
                                <input type="date" name="billed_at" id="billed_at" class="form-control" required  />
                            </div>
                        </div>
                        <button style="margin-top: 24px;" type="submit" class="btn btn-primary">
                            <i class="glyphicon glyphicon-save"></i>
                            Confirmar
                        </button>
                        <button style="margin-top: 24px;" type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="glyphicon glyphicon-remove"></i>
                            Cancelar
                        </button>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="card">
    <div class="card-header">
        <i class="fa fa-filter"></i> Filtro
    </div>
    <div class="card-body">
        <form method="GET" action="{{ url()->current() }}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="termo">Palavra-chave</label>
                        <input value="{{ request()->key_word ? request()->key_word : '' }}"  placeholder="nome cliente, produto.." type="text" class="form-control" name="key_word" id="termo"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="input_flow">Fluxo</label>
                        <select name="flow" id="input_flow" class="form-control">
                            <option value="">Selecione</option>
                            @foreach(\App\ConectaWhats\SideDish\Domain\Models\Order\Flow::all() as $flow)
                                <option value="{{ $flow }}" {{ request()->flow == $flow ? 'selected' : '' }}>@lang('flow.' . $flow)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="filter_date_in">De</label>
                        <input value="{{ request()->date_init ? request()->date_init : '' }}" type="date" class="form-control" name="date_init" id="filter_date_in"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="filter_date_in">Até</label>
                        <input value="{{ request()->date_final ? request()->date_final : '' }}" type="date" class="form-control" name="date_final" id="filter_date_out"/>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <button class="btn btn-primary btn-lg" style="margin-top: 28px;"><i class="fa fa-filter"></i> Filtrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
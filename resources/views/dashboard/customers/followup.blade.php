@component('dashboard.components.customer', ['items' => $items])

    @slot('title', $title)

    @slot('tableHeader')
        <tr>
            <th>
                <div class="btn-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"
                                   @click="checkAll({{ $items->pluck('id') }}, $event)">
                            <span class="form-check-sign"></span>
                        </label>
                    </div>
                    <template v-if="ids.length > 0">
                        <button class="btn btn-primary btn-border dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="true">Ação
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" @click.prevent
                               onclick="return confirm('Tem certeza?') ? document.getElementById('delete-all').submit() : false;">Remover</a>
                        </div>
                    </template>
                </div>
            </th>
            <template v-if="ids.length > 0">
                <th>
                    <form id="delete-all" action="{{ route('customer.destroyMany')  }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </th>
            </template>
            <template v-else>

                <th scope="col"><i class="fa fa-send" aria-hidden="true"></i></th>
                <th scope="col">Contactar Em</th>
                <th scope="col">Fluxo</th>
                <th scope="col">Produtos</th>
                <th scope="col" style="width: 200px;">Cliente</th>
                <th style="width: 200px;">Observação</th>
                <th colspan="3">Acões</th>

            </template>
        </tr>
    @endslot

    @slot('tableBody')
        @foreach($items as $item)
            <tr>
                <td>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input name="ids[]" v-model="ids" form="delete-all" class="form-check-input" type="checkbox"
                                   value="{{ $item->id }}">
                            <span class="form-check-sign"></span>
                        </label>
                    </div>
                </td>
                <td>
                    <a href="#"
                       @click.prevent="showSendMessage({{$item}}, '{{route('customer.contacted', [$item->id])}}')">
                        <i class="fa fa-whatsapp fa-2x {{ $item->customer->phone->isValid() ? 'text-success' : 'text-danger' }}"
                           aria-hidden="true"></i>
                    </a>
                </td>
                <td><strong>{{ $item->followup_at->format('d/m/Y') }}</strong></td>
                <td>
                    <span class="badge badge-{{$item->flow}}">@lang('flow.' . $item->flow)</span>
                </td>
                <td>
                    <a href="{{ route('redirect_shopify', [$item->id]) }}"
                       target="_blank"><strong>#{{ $item->number ? $item->number : $item->id }}</strong></a><br>
                    @foreach($item->products as $product)
                        <span class="badge badge-info">{{ $product->title }}</span>
                    @endforeach
                </td>
                <td>{{ $item->customer->name }}<br><span class="badge badge-success"><i class="fa fa-whatsapp"></i> ({{ $item->customer->province_code }}){{ $item->customer->phone }}</span>
                </td>
                <td>
                    {{ $item->note ? $item->note : '--' }}
                </td>
                <td class="text-center">
                    <button class="btn btn-link px-0" data-toggle="modal"
                            data-target="#modalVisualizacao{{ $item->id }}">
                        <i class="fa fa-edit fa-2x text-warning" aria-hidden="true"></i>
                    </button>
                </td>
                <td class="text-center">
                    <form class="pb-1" action="{{ route('customer.destroy', [$item->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Tem certeza?')" class="btn btn-link px-0"><i
                                    class="fa fa-trash fa-2x text-danger" aria-hidden="true"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    @endslot


@endcomponent
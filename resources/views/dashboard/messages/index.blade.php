@extends('layouts.myapp')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Configurações</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ url()->current() }}">Mensagens</a>
                </li>                
            </ul>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    Aqui você irá configurar as mensagens de acordo com o fluxo do pedido, por exemplo, na aba "Checkout Abandonado" você irá criar mensagens destinadas à clientes que por algum motivo não completaram seu pedido. 
                    Na aba de "Pagamento Pendente" você irá criar mensagens destinadas à clientes que geraram o boleto e não realizaram o pagamento. Na aba "Pago", você criará mensagens destinadas à clientes que efetuaram o pagamento.
                </div>     
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                    @php $mainType = !empty($types) ? $types[0] : ''; @endphp
                    @foreach($types as $key => $type)

                    <li class="nav-item">
                        <a @click="tabMessage('{{$type}}')" class="nav-link {{ $key == 0 ? 'active show' : '' }}" id="pills-{{ $type }}-tab" data-toggle="pill" href="#pills-{{ $type }}" role="tab" aria-controls="pills-{{ $type }}" aria-selected="false">@lang('type.message.' . $type )</a>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalCadastro">
                                <i class="fa fa-plus-circle"></i> Criar Mensagem
                            </button>
                        </div>
                    </div>
                    @foreach($typesMessages as $type => $messagesType)
                    <div class="tab-pane fade {{ $type == $mainType ? 'active show' : '' }}" id="pills-{{ $type }}" role="tabpanel" aria-labelledby="pills-{{ $type }}-tab">
                        @foreach($messagesType as $message)
                        <div class="row">                         
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <form action="{{ route('messages.destroy', [$message->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-link text-danger"><i class="fa fa-trash"></i></button>
                                            <strong>{{ $message->title }}</strong>
                                        </form>

                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('messages.update', [$message->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <textarea rows="5" name="content" class="form-control message">{{ $message->content }}</textarea>                                    
                                            <button class="btn btn-success float-right mt-2">
                                                <i class="fa fa-refresh"></i> Atualizar
                                            </button>
                                        </form>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>                
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <i class="fa fa-info-circle"></i> Instruções para customização
                    </div>
                    <!--                    style="background-color: #e8e8e8;"-->
                    <div class="card-body">
                        <p>Para customizar suas mensagens substitua o correspendente pela sua variável. <strong>Ex.: Olá [customer], tudo bem?</strong></p>
                        <table class="table table-bordered">
                            <thead>                            
                            <th>Correspondente</th>
                            <th>Variável</th>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Nome do cliente</td>
                                    <td>[customer]</td>                                
                                </tr>
                                <tr>
                                    <td>Produtos (Todos os produtos separados por vírgula)</td>
                                    <td>[products]</td>                                
                                </tr>                                
                                <tr>
                                    <td>Link do checkout</td>
                                    <td>[link_checkout]</td>                                  
                                </tr>
                                <tr>
                                    <td>Link do boleto</td>
                                    <td>[link_boleto]</td>                                  
                                </tr> 
                                <tr>
                                    <td>Número do Pedido</td>
                                    <td>[number_order]</td>                                  
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        Você pode querer configurar o singular/plural, pois pode haver pedidos com mais de um produto. Para isso você deve usar 
                                        <strong>[singular|plural]</strong>, <span class="text-warning">(sem espaços dentro dos colchetes)</span>. Onde há 
                                        <strong>singular</strong> você deve inserir uma palavra no singular e onde há <strong>plural</strong> você deve inserir a mesma 
                                        palavra no plural. <strong>Ex.: [o|os]</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <!-- Modal -->
                <div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle text-primary" aria-hidden="true"></i> Cadastrar Mensagem <strong>(Checkout Abandonado)</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card" style="background-color: #f7f7f7;">
                                            <div class="card-body">
                                                <p>Para customizar usas mensagens substitua o correspendente pela sua variável. <strong>Ex.: Olá [customer], tudo bem?</strong></p>
                                                <table class="table table-bordered">
                                                    <thead>                            
                                                    <th>Correspondente</th>
                                                    <th>Variável</th>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td>Nome do cliente</td>
                                                            <td>[customer]</td>                                
                                                        </tr>
                                                        <tr>
                                                            <td>Produtos (Todos os produtos separados por vírgula)</td>
                                                            <td>[products]</td>                                
                                                        </tr>                                
                                                        <tr>
                                                            <td>Link do checkout</td>
                                                            <td>[link_checkout]</td>                                  
                                                        </tr>
                                                        <tr>
                                                            <td>Link do boleto</td>
                                                            <td>[link_boleto]</td>                                  
                                                        </tr> 
                                                        <tr>
                                                            <td>Número do Pedido</td>
                                                            <td>[number_order]</td>                                  
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                Você pode querer configurar o singular/plural, pois pode haver pedidos com mais de um produto. Para isso você deve usar 
                                                                <strong>[singular|plural]</strong>, <span class="text-warning">(sem espaços dentro dos colchetes)</span>. Onde há 
                                                                <strong>singular</strong> você deve inserir uma palavra no singular e onde há <strong>plural</strong> você deve inserir a mesma 
                                                                palavra no plural. <strong>Ex.: [o|os]</strong>
                                                            </td>
                                                        </tr>                              
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <form id="formCadastro" action="{{ route('messages.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" v-model="typeMessage" name="flow"/>
                                                    <div class="form-group">
                                                        <label for="input-titulo">Título</label>
                                                        <input name="title" placeholder="Insira o título aqui.." type="text" class="form-control" id="input-titulo"/>
                                                    </div>                                                
                                                    <div class="form-group">
                                                        <label for="input-mensagem">Mensagem</label>
                                                        <textarea name="content" placeholder="Escreva aqui sua mensagem.." rows="12" class="form-control message" id="input-mensagem"></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>                                        
                                    </div>                                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button form="formCadastro" class="btn btn-success">Cadastrar</button>
                            </div>
                        </div>
                    </div>
                </div>               
            </div> 
        </div>
    </div>
</div>
@endsection
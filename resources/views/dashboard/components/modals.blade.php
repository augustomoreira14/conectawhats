<div class="row">
    <div class="col-sm-12">
        <!-- Modal -->
        <div class="modal fade" id="modalEnvio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-whatsapp text-success" aria-hidden="true"></i> Envio de mensagem</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div v-if="!loading" class="modal-body">
                        <div class="row" v-if="messages">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="sendMessageWhats" :action="urlAction" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="select-msg">Selecione sua mensagem</label>
                                                <select name="message" v-model="message" class="custom-select" id="select-msg">
                                                    <option :value="i" v-for="i in messages">@{{ i.title }}</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card" v-if="customer">
                                    <div class="card-body">
                                        <p>Copie uma das imagens abaixo antes de enviar a mensagem para poder inseri-la na mensagem no WhatsApp:</p>
                                        <div class="row">
                                            <div v-for="i in order.products" class="col-sm-4">
                                                <img :src="i.image" style="width: 100%;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-else>
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body" v-if="customer">
                                        <h3>Você não possui nenhuma mensagem configurada para <strong>@{{ 'flow.' + typeMessage | trans }}</strong>!</h3>
                                        <p><a href="{{ route('messages.index') }}" class="btn btn-block btn-primary"><i class="fa fa-cog"></i> Configurar Agora</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="message" class="card" style="background-color: #e4e4e4; box-shadow: 15px 16px 15px -10px rgba(69,65,78,.08);">
                            <div class="card-body">
                                <p class="text-info"><i class="fa fa-info-circle"></i> O formato da mensagem estará de acordo com o que foi cadastrado.</p>
                                <p style="font-size: 1rem;">
                                    @{{ message.message }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div v-else class="modal-body">
                        <p>Carregando..</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button form="sendMessageWhats" @click="sendMessage()" class="btn btn-success" :disabled="!messages">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach($items as $item)
        <div class="col-sm-12">
            <!-- Modal -->
            <div class="modal fade" id="modalVisualizacao{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit text-warning" aria-hidden="true"></i> Informações do Cliente <strong>({{ $title }})</strong></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formUpdate{{$item->id}}" action="{{ route('customer.update', [$item->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card" style="height: auto;">
                                            <div class="card-body">
                                                <p style="font-size: 1rem;"><strong>Nome:</strong> {{ $item->customer->name }}</p>
                                                <p style="font-size: 1rem;"><strong>Data:</strong> {{ $item->created_at->format('d/m/Y H:i:s') }}</p>
                                                <p style="font-size: 1rem;"><strong>Fluxo:</strong> @lang('flow.'.$item->flow)</p>
                                                <p style="font-size: 1rem;"><strong>WhatsApp:</strong> <a href="https://api.whatsapp.com/send?{{ http_build_query(['phone' => $item->customer->phone->phoneStringFormated()]) }}" target="_blank">({{ $item->customer->province_code }}) {{ $item->customer->phone }}</a></p>
                                                <p style="font-size: 1rem;"><strong>Produtos:</strong> {{ $item->products->implode('title', ',') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="input-phone">WhatsApp</label>
                                                    <input class="form-control" name="phone" value="{{ $item->customer->phone }}" id="input-phone"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input-observacoes">Observações</label>
                                                    <textarea name="note" placeholder="Anote aqui as observações do seu contato com o cliente.." rows="4" class="form-control" id="input-observacoes">{{ $item->note }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="input-data">Contactar novamente em:</label>
                                                    <input name="date" value="{{ $item->followup_at ? $item->followup_at->toDateString() : '' }}" type="date" class="form-control" id="input-data"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button form="formUpdate{{$item->id}}" type="submit" class="btn btn-success">Atualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
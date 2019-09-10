<template>
    <div class="modal fade" id="modalVisualizacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit text-warning" aria-hidden="true"></i> Informações do Cliente <strong>(Aguardando Contato)</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form :action="url" method="POST">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card" style="height: 205px;">
                                    <div class="card-body">
                                        <p style="font-size: 1rem;"><strong>Nome:</strong> João Silva</p>
                                        <p style="font-size: 1rem;"><strong>Data:</strong> 10/11/2018 16:40</p>
                                        <p style="font-size: 1rem;"><strong>Produto:</strong> Produto 1</p>
                                        <p style="font-size: 1rem;"><strong>Objeção:</strong> Boleto</p>

                                    </div>
                                </div>                                        
                            </div>
                            <div class="col-sm-6">
                                <div class="card" style="height: 205px;">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="input-observacoes">Observações</label>
                                            <textarea name="note" placeholder="Anote aqui as observações do seu contato com o cliente.." rows="5" class="form-control" id="input-observacoes"></textarea>
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
                                            <input name="date" type="date" class="form-control" id="input-data"/>
                                        </div>                                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success">Atualizar</button>
                </div>
            </div>
        </div>
    </div> 
</template>

<script>
    export default {
        props: {
            url: String
        },
        mounted() {
            console.log('Component mounted.')
        },
        data(){
          return {
              
          }  
        }
    }
</script>

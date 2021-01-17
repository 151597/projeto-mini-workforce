@extends('home')
@section('title', 'Relatório de Tipos de Ativos')
@section('title2', 'Relatório de Tipos de Ativos')
@section('content')
<div class="form-group">
    <div class="row">
      <div class="col-md-4">
        
        <label for="idSetor">Setor:</label>
        <select class="form-control" onChange="atualizaTabela()" name="idSetor" id="idSetor">
          <option value="-1">
            -- SELECIONE --
          </option>
          @if(!empty($setor))
            @foreach($setor as $key => $value)
                <option value="{{$value['id_setor']}}">
                    {{$value['nome']}}
                </option>
            @endforeach
          @endif
          <option value="0">
            Desconhecido
          </option>
        </select>
    
      </div>
    </div>
</div>

<div class="panel-white col-md-2" >
    <h4  id="total">Total: </h4>
</div>

<br><br><br>
<table class="display" id="tableRelatorios" style="width:100%;"> <!-- TABELA -->
  <thead>
    <tr>
      <th scope="col" class="col-sm-2">Tipo de Ativo</th>
      <th scope="col" class="col-sm-2">Quantidade</th>
    </tr>
  </thead>
  <tbody>       
  </tbody>
</table><!-- FIM TABELA -->

<script>

$(window).load(function () {


  $('#tableRelatorios').DataTable({
        dom: 'Bfrtip',
            buttons: [
                'csvHtml5',
                'excelHtml5'
	],
	"pageLength": 50, 
        "searching": true,
        "paging": false,
        "info": false,
        "scrollX": true,
        "ajax": {
          data: {
                    idSetor: function(){ if($("#idSetor").val() != null){ return $("#idSetor").val()}else{ return 0;}; },
                    "_token": "{{ csrf_token() }}" 
                },
          method: "get",
          url: '/load/relatorios/tipo/ativos',
          dataType: "json"
    	},
        
	"language":{
    	   url:"/assets/plugins/datatables/js/Portuguese-Brasil.json"
    	},
      	"columns": [
            {
                mRender: function (data, type, row) {
                    return row.nome ;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.quantidade ;
                }
            },
          ]
    });   
    quantidadeTotal();
});   

function atualizaTabela(){
  quantidadeTotal();
  $('#tableRelatorios').DataTable().ajax.reload();
    
}

function quantidadeTotal(){
  $.ajax({
      data: {
                idSetor: function(){ if($("#idSetor").val() != null){ return $("#idSetor").val()}else{ return -1;}; },
                "_token": "{{ csrf_token() }}" 
            },
      method: "get",
      url: '/load/relatorios/tipo/ativos',
      dataType: "json",
      success: function(result) {
        $("#total").html("Total: "+result.total);
      }
  });
}

</script>
@stop

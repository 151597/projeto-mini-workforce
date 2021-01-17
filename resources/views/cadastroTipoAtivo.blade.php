@extends('home')
@section('title', 'Cadastro de Tipos de Ativo')
@section('title2', 'Cadastro de Tipos de Ativo')
@section('content')
<style>
/*.dataTables_wrapper .dataTables_length{
  float:right;
}*/

</style>
<!-- FORMULÀRIO -->
<form id="frmAtivo" class="form-inline" action="">
  <input type="hidden" name="id_ativo" id="id_ativo">
  <div class="form-group">
    <label for="cadastroAtivo">Nome:&nbsp</label>
    <input type="text" class="form-control" name="cadastroAtivo" id="cadastroAtivo" style="border: 1px solid #ced4da;" required placeholder="Nome">
  </div>
  &nbsp
  <button type="submit" id="saveAtivo" class="btn btn-success"><span class="fa fa-floppy-o"> SALVAR</span></button>
</form><!-- FIM FORMULÀRIO -->
<br>
<table class="display" id="tableAtivo" style="width:100%;"> <!-- TABELA -->
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col" id="tableAction">Ações</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>CPU</td>
      <td>
            <a><span class="glyphicon glyphicon-edit"></span></a>
            <a><span style="position:relative;left:10px;" class="glyphicon glyphicon-trash"></span></a>
      </td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Monitor</td>
      <td>
            <a><span class="glyphicon glyphicon-edit"></span></a>
            <a><span style="position:relative;left:10px;" class="glyphicon glyphicon-trash"></span></a>
      </td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Cabo QD</td>
      <td>
            <a><span class="glyphicon glyphicon-edit"></span></a>
            <a><span style="position:relative;left:10px;" class="glyphicon glyphicon-trash"></span></a>
      </td>
    </tr>
  </tbody>
</table><!-- FIM TABELA -->

<script>

$(window).load(function () {
    $('#tableAtivo').DataTable({
        "searching": true,
        "paging": true,
        "info": false,
        "scrollX": true,
        "ajax": {
          data: { "_token": "{{ csrf_token() }}" },
          method: "get",
          url: '/' + 'load' + '/' + 'tipo'+ '/' + 'ativo',
          dataType: "json"
	},
	"language":{
	  url: "/assets/plugins/datatables/js/Portuguese-Brasil.json"
	},
      "columnDefs":[
                { "orderable": false, "targets": 2}
               
             ],
      "columns": [
            {
                mRender: function (data, type, row) {
                    return row.id_ativo ;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.nome ;
                }
            },
            {
                mRender: function (data, type, row) {
                  return '<a onClick="edicao(\''+row.id_ativo+'\', \''+row.nome+'\')"><span class="glyphicon glyphicon-edit"></span></a>&nbsp&nbsp<a class="table-check"><input type="checkbox" class="form-check-input" name="check" id="' + row.id_ativo + '"></a>'
                }
            },
          ],
          "order":[[1,"asc"]]
    });

    $('#tableAtivo').on('click', '.table-check', function () {
      var check = [];
          $("input[name='check']").each(function() {
            if ($(this).prop("checked")) {
                check.push($(this).prop("id"));
            }
        });
        console.log(check);
        if(check.length > 0){
          $("#tableAction").html('<a class="table-delete btn btn-danger" style="position:relative; right:10px;"><span style="cursor:pointer;" class="glyphicon glyphicon-trash" title="DELETAR"></span>&nbsp;&nbsp;Remover Ítens</a>');
        }else{
          $("#tableAction").html('Ações');
        }
    });

    $('#tableAction').on('click', '.table-delete', function () {
        var check = [];
            $("input[name='check']").each(function() {
              if ($(this).prop("checked")) {
                  check.push($(this).prop("id"));
              }
          });

        if(confirm("Tem certeza que deseja Excluir?") === true){
          $.ajax({
            data: {
                data: check,
                "_token": "{{ csrf_token() }}"
            },
            method: "delete",
            url: '/' + 'delete' + '/' + 'tipo' + '/' + 'ativo' + '/' + check,
            success: function(result) {
                alert("EXCLUIDO COM SUCESSO!");
                $('#tableAtivo').DataTable().ajax.reload();
                $("#tableAction").html('Ações');
            },
            error: function(result){
              alert("ERRO!");
            }
          });
        }
    });      
});

$(document).on("submit", "#frmAtivo", function(event) {
    event.preventDefault();

    var data = $('#cadastroAtivo').val();
    var id_ativo = $('#id_ativo').val();

      $.ajax({
        data: {
            id_ativo:id_ativo,
            data: data,
            "_token": "{{ csrf_token() }}"
        },
        method: "post",
        url: '/' + 'salvar' + '/' + 'tipo'+ '/' + 'ativo',
        success: function(result) {
            alert("SALVO COM SUCESSO!");
            $('#tableAtivo').DataTable().ajax.reload();
            clearFields();
        },
        error: function(result){
          alert("ERRO!");
        }
      });
});  

function edicao(id, nome){
  $("#id_ativo").val(id);
  $("#cadastroAtivo").val(nome);
  $("#saveAtivo").html('');
  $("#saveAtivo").html('<span class="fa fa-floppy-o"></span>  ATUALIZAR');
  document.documentElement.scrollTop = 0;
}

function clearFields(){
  $("#id_ativo").val('');
  $("#cadastroAtivo").val('');
  $("#saveAtivo").html('');
  $("#saveAtivo").html('<span class="fa fa-floppy-o"></span>  SALVAR');
}

</script>
@stop

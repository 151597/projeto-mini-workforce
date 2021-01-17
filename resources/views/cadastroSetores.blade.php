@extends('home')
@section('title', 'Cadastro de Setores')
@section('title2', 'Cadastro de Setores')
@section('content')

<style>
.dataTables_wrapper .dataTables_length{
  float:right;
}

</style>

<!-- FORMULÀRIO -->
<form id="frmSetores" class="form-inline" action="">
  <input type="hidden" name="id_setor" id="id_setor">
  <div class="form-group">
    <label for="cadastroSetores">Nome:&nbsp</label>
    <input type="text" class="form-control" name="cadastroSetores" id="cadastroSetores" style="border: 1px solid #ced4da;" required placeholder="Nome">
  </div>
  &nbsp
  <button type="submit" id="saveSetores" class="btn btn-success"><span class="fa fa-floppy-o"></span> SALVAR</button>
</form><!-- FIM FORMULÀRIO -->
<br><br>
<table class="display" id="tableSetores" style="width:100%;"> <!-- TABELA -->
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
      <td>Operação</td>
      <td>
            <a><span class="glyphicon glyphicon-edit" style="cursor:pointer;"></span></a>
            <a><span style="position:relative;left:10px;cursor:pointer;" class="glyphicon glyphicon-trash"></span></a>
      </td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>RH</td>
      <td>
            <a><span class="glyphicon glyphicon-edit" style="cursor:pointer;"></span></a>
            <a><span style="position:relative;left:10px;cursor:pointer;" class="glyphicon glyphicon-trash"></span></a>
      </td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>TI</td>
      <td>
            <a><span class="glyphicon glyphicon-edit"></span></a>
            <a><span style="position:relative;left:10px;cursor:pointer;" class="glyphicon glyphicon-trash"></span></a>
      </td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>Qualidade</td>
      <td>
            <a><span class="glyphicon glyphicon-edit" style="cursor:pointer;"></span></a>
            <a><span style="position:relative;left:10px;cursor:pointer;" class="glyphicon glyphicon-trash"></span></a>
      </td>
    </tr>
    <tr>
      <th scope="row">5</th>
      <td>Treinamento</td>
      <td>
            <a><span class="glyphicon glyphicon-edit" style="cursor:pointer;"></span></a>
            <a><span style="position:relative;left:10px;cursor:pointer;" class="glyphicon glyphicon-trash"></span></a>
      </td>
    </tr>
  </tbody>
</table><!-- FIM TABELA -->

<script>

$(window).load(function () {
    $('#tableSetores').DataTable({
        "searching": false,
        "paging": true,
        "info": false,
        "scrollX": true,
        "ajax": {
          data: { "_token": "{{ csrf_token() }}" },
          method: "get",
          url: '/' + 'load' + '/' + 'setores',
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
                    return row.id_setor ;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.nome ;
                }
            },
            {
                mRender: function (data, type, row) {
                  return '<a onClick="edicao(\''+row.id_setor+'\', \''+row.nome+'\')"><span class="glyphicon glyphicon-edit" style="cursor:pointer;"></span></a>&nbsp&nbsp<a class="table-check"><input type="checkbox" class="form-check-input" name="check" id="' + row.id_setor + '"></a>'
                }
            },
	],
        "order": [[1,"asc"]]
    });

    $('#tableSetores').on('click', '.table-check', function () {
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
            url: '/' + 'delete' + '/' + 'setores' + '/' + check,
            success: function(result) {
                alert("EXCLUIDO COM SUCESSO!");
                $('#tableSetores').DataTable().ajax.reload();
                $("#tableAction").html('Ações');
            },
            error: function(result){
              alert("ERRO!");
            }
          });
        }
    });
});

$(document).on("submit", "#frmSetores", function(event) {
    event.preventDefault();

    var data = $('#cadastroSetores').val();
    var id_setor = $("#id_setor").val();

      $.ajax({
        data: {
          id_setor:id_setor,
            data: data,
            "_token": "{{ csrf_token() }}"
        },
        method: "post",
        url: '/' + 'salvar' + '/' + 'setores',
        success: function(result) {
            alert("SALVO COM SUCESSO!");
            $('#tableSetores').DataTable().ajax.reload();
            clearFields();
        },
        error: function(result){
          alert("ERRO!");
        }
      });
});  

function edicao(id, nome){
  $("#id_setor").val(id);
  $("#cadastroSetores").val(nome);
  $("#saveSetores").html('');
  $("#saveSetores").html('<span class="fa fa-floppy-o"></span>  ATUALIZAR');
  document.documentElement.scrollTop = 0;
}

function clearFields(){
  $("#id_setor").val('');
  $("#cadastroSetores").val('');
  $("#saveSetores").html('');
  $("#saveSetores").html('<span class="fa fa-floppy-o"></span>  SALVAR');
}
</script>
@stop

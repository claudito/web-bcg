<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Plantilla</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>

<!-- Datatables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>


	  
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>

</head>
<body>

<div class="container-fluid">
	
<div class="row">
	
<div class="col-md-12">

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-code"></i> Plantillas de Correo</h3>
	</div>
	<div class="panel-body">

   <div class="table-responsive">
   	<table id="consulta"  class="table table-hover table-condensed">
   		<thead>
   			<tr>
   				<th>Plantilla</th>
   				<th>Acciones</th>
   			</tr>
   		</thead>
   	</table>
   </div>



	</div>
</div>



</div>


</div>


</div>

<!-- Modal Actualizar -->
<form id="actualizar" autocomplete="off">

	<div class="modal fade" id="modal-actualizar">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Modal title</h4>
				</div>
				<div class="modal-body">

                <input type="hidden" name="id"     class="id">


      <div class="form-group">
      <textarea name="cuerpo" class="cuerpo" required ></textarea>
      </div>
      <script>
      $(document).ready(function() {
      $('.cuerpo').summernote({

      height:300,
      placeholder: 'Ingrese el texto.'


      });
      });
      </script>


					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Actualizar</button>
				</div>
			</div>
		</div>
	</div>	


</form>



<!-- Modal Enviar Correo -->
<form id="envio" autocomplete="off">
<div class="modal fade" id="modal-envio">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">

      <input type="hidden" name="id" class="id">

      <input type="email" name="email" class="email form-control" required>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-info"><i class="fa fa-envelope"></i> Enviar Correo</button>
      </div>
    </div>
  </div>
</div>
</form>

<script>
function load()
{

$(document).ready(function() {
    $('#consulta').DataTable( {
        "destroy":true,
        "bAutoWidth":false,
        "language":{
        
         "url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"

        },
        "ajax": "source/plantilla.php?op=1",
        "columns": [
            { "data": "nombre" },
            { "data": null,render:function(data){

              acciones = '<button  class="btn btn-primary btn-edit" data-id="'+data.id+'" data-nombre="'+data.nombre+'"><i class="fa fa-edit"></i></button> <button  class="btn btn-info btn-envio" data-id="'+data.id+'" data-nombre="'+data.nombre+'"><i class="fa fa-envelope"></i></button>';


              return acciones;


            } }
        ]
    } );
} );



}


load();

//Cargar Modal Actualizar
$(document).on('click','.btn-edit',function(){

id     = $(this).data('id');
nombre = $(this).data('nombre');

$('.id').val(id);

url    = "source/plantilla.php?op=2";

$.getJSON(url,{'id':id},function(data){


 $('.cuerpo').summernote('code',data.cuerpo);

});


$('.modal-title').html(nombre);
$('#modal-actualizar').modal('show');


});

//Actualizar
$('#actualizar').on('submit',function(e){

parametros = $(this).serialize();

$.ajax({

url:"source/plantilla.php?op=3",
type:"POST",
data:parametros,
beforeSend:function(){

swal({
 
  title:"Cargando",
  text: "Espere un momento no cierre la ventana",
  imageUrl: 'img/loader2.gif',
  showConfirmButton:false

});

},
success:function(){


swal({
 
  title:"Buen Trabajo",
  text: "Registro Actualizado",
  type: 'success',
  timer: 3000,
  showConfirmButton:false

});




}



});



e.preventDefault();
});

//Cargar Modal Envío
$(document).on('click','.btn-envio',function(){

id     = $(this).data('id');
nombre = $(this).data('nombre');

$('.id').val(id);
$('.email').val('comercial@bcgconsultora.com');

$('.modal-title').html(nombre);
$('#modal-envio').modal('show');


});

//Enviar
$('#envio').on('submit',function(e){

parametros = $(this).serialize();

$.ajax({

url:"source/plantilla.php?op=4",
type:"POST",
data:parametros,
beforeSend:function(){

swal({
 
  title:"Cargando",
  text: "Espere un momento no cierre la ventana",
  imageUrl: 'img/loader2.gif',
  showConfirmButton:false

});

},
success:function(){


swal({
 
  title:"Buen Trabajo",
  text: "Mensaje Enviado",
  type: 'success',
  timer: 3000,
  showConfirmButton:false

});




}



});



e.preventDefault();
});


</script>
</body>
</html>
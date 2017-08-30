<?php @session_start();
include ("conexion.php");
include("common.php");

$option_tipo_archivo	= add_options(get_tipo_archivo($pdo));
$option_provincias	= add_options(get_provincias($pdo));
$option_obras_sociales	= add_options(get_obras_sociales($pdo));



?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />

        </title>

<style>
	#dvLoading
	{
	 position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('imagenes/page-loader.gif') 50% 50% no-repeat rgb(249,249,249);
}
</style>
        <link rel="stylesheet" href="css/style.css" />

        <link rel="stylesheet" href="css/tabla.css" />
       <link rel="stylesheet" href="css/jquery.mobile-1.3.1.min.css" />

		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
       	       <script>

$(window).load(function() {
	$("#dvLoading").fadeOut("slow");
})
5	</script>
		<!-- Demo stuff -->
	<link rel="stylesheet" href="pager/docs/css/jq.css">
	<link href="pager/docs/css/prettify.css" rel="stylesheet">
	<script src="pager/docs/js/prettify.js"></script>
	<script src="pager/docs/js/docs.js"></script>

    <!-- Tablesorter: required -->
    <link rel="stylesheet" href="pager/css/theme.blue.css">
    <script src="pager/js/jquery.tablesorter.js"></script>
    <script src="pager/js/parsers/parser-input-select.js"></script>
    <script src="pager/js/jquery.tablesorter.widgets.js"></script>
    <script src="pager/js/widgets/widget-editable.js"></script>


	<!-- Tablesorter: optional -->
	<link rel="stylesheet" href="pager/addons/pager/jquery.tablesorter.pager.css">
	<style>
	.left { float: left; }
	.right {
		float: right;
		-webkit-user-select: none;
		-moz-user-select: none;
		-khtml-user-select: none;
		-ms-user-select: none;
	}
	.pager .prev, .pager .next, .pagecount { cursor: pointer; }
	.pager a {
		text-decoration: none;
		color: black;
	}
	.pager a.current {
		color: #0080ff;
	}
	</style>
	<script src="pager/addons/pager/jquery.tablesorter.pager.js"></script>
	<script src="pager/js/pager-custom-controls.js"></script>

	<script id="js">$(function(){
            function onSuccess(data, status)
            {

                var $table = $('table');

                $.tablesorter.clearTableBody( $table[0] );
                $table
                    .trigger('update');


                window.location.href = 'download_registro.php?p=' + data.message;
               // alert('Se inserateron ');
            }

            function onError(data, status)
            {
                alert('error:'+data.statusText);
            }


            $("#save").click(function(){

               var data=[];

                $('tbody').find('tr').each(function(){
                     var count = this.childElementCount;
                     var indexed_array = {};
                     for(var i=0;i<count;i++){
                         indexed_array[i] =   this.children[i].textContent;
                     }
                     data.push(indexed_array);

                });
                $.ajax({
                    type: "POST",
                    url: "guardar_registros.php",
                    cache: false,
                    data: {datos:data},
                    success: onSuccess,
                    error: onError
                });

            });

            $("#clean").click(function() {
                var $table = $('table');

                $.tablesorter.clearTableBody( $table[0] );
                $table
                    .trigger('update');
                return false;
            });
			$("#createLine").click(function() {
				var cantidadReg = $("#cantidadReg").val();

				var countInt = parseInt(cantidadReg);

                var tipo_archivo = $('#tipo_archivo option:selected').val();
                var provincia = $('#provincia option:selected').val();
                var obras_sociales =$('#obras_sociales option:selected').val();

                if(tipo_archivo=='n/c'  || provincia=='n/c' || obras_sociales=='n/c'){

                     alert('Todos los campos obligatorios tienen que tener valores !');  return false;
                }


                var row='';
				for(var i=0;i<countInt;i++){


					 row += '<tr>'+
                            '<td tipo>'+tipo_archivo+'</td>'+
                            '<td obras>'+obras_sociales+'</td>' +
                            '<td cuil>20-11111111-0</td>'+ /*cuil*/
                            '<td certificado contenteditable="true"></td>'+/*codigo certificado*/
                            '<td vencimiento contenteditable="true"></td>'+/*vencimiento certificado*/
                            '<td contenteditable="true"></td>'+/*periodo prestacion*/
							'<td contenteditable="true"></td>'+/*CUIT prestador*/
                            '<td contenteditable="true"></td>'+/*tipo de comprobante*/
                            '<td contenteditable="true"></td>'+/*tipo emision*/
                            '<td contenteditable="true"></td>'+/*fecha de emision */
                            '<td contenteditable="true"></td>'+/*numero CAE o CAI*/
                            '<td contenteditable="true"></td>'+/*punto de venta*/
							'<td>12345677</td>'+ /*numero comprobante*/
                            '<td contenteditable="true"></td>'+/*importe de comprobante*/
                            '<td contenteditable="true"></td>'+/*importe solicitado*/
                            '<td>123</td>'+/*codigo de practica*/
                            '<td contenteditable="true"></td>'+/*cantidad*/
                            '<td>'+provincia+'</td>'+
                            '<td contenteditable="true"></td>'+/*dependencia*/
                            '</tr>',
						 $row = $(row),
						resort = true;

				}
				$('table')
					.find('tbody').append($row)
					.trigger('addRows', [$row, resort]);

                $('table')
                    .trigger('update');


				return false;
			});


	// initialize custom pager script BEFORE initializing tablesorter/tablesorter pager
	// custom pager looks like this:
	// 1 | 2 … 5 | 6 | 7 … 99 | 100
	//   _       _   _        _     adjacentSpacer
	//       _           _          distanceSpacer
	// _____               ________ ends (2 default)
	//         _________            aroundCurrent (1 default)

	var $table = $('table'),
		$pager = $('.pager');

	$.tablesorter.customPagerControls({
		table          : $table,                   // point at correct table (string or jQuery object)
		pager          : $pager,                   // pager wrapper (string or jQuery object)
		pageSize       : '.left a',                // container for page sizes
		currentPage    : '.right a',               // container for page selectors
		ends           : 2,                        // number of pages to show of either end
		aroundCurrent  : 1,                        // number of pages surrounding the current page
		link           : '<a href="#">{page}</a>', // page element; use {page} to include the page number
		currentClass   : 'current',                // current page class name
		adjacentSpacer : ' | ',                    // spacer for page numbers next to each other
		distanceSpacer : ' \u2026 ',               // spacer for page numbers away from each other (ellipsis &amp;hellip;)
		addKeyboard    : true                      // add left/right keyboard arrows to change current page
	});

	// initialize tablesorter & pager
	$table
		.tablesorter({
			theme: 'blue',
			headers: {
				0: {resizable: true, filter: false, sorter: false},
				1: {resizable: true, filter: false, sorter: false},
				2: {resizable: true, filter: false, sorter: false},
				3: {resizable: true, filter: false, sorter: false},
				4: {resizable: true, filter: false, sorter: false},
				5: {resizable: true, filter: false, sorter: false},
				6: {resizable: true, filter: false, sorter: false},
				7: {resizable: true, filter: false, sorter: false},
				8: {resizable: true, filter: false, sorter: false},
				9: {resizable: true, filter: false, sorter: false},
				10: {resizable: true, filter: false, sorter: false},
				11: {resizable: true, filter: false, sorter: false},
				12: {resizable: true, filter: false, sorter: false},
				13: {resizable: true, filter: false, sorter: false}, // image
				14: {resizable: true, filter: false, sorter: false}, // video
				15: {resizable: true, filter: false, sorter: false},
				16: {resizable: true, filter: false, sorter: false},
				17: {resizable: true, filter: false, sorter: false},
				18: {resizable: true, filter: false, sorter: false},
				19: {resizable: true, filter: false, sorter: false}
			},
			widgets: ['zebra', 'columns','editable','filter'],
			widgetOptions: {
				editable_columns       : [4,5,6],       // or "0-2" (v2.14.2); point to the columns to make editable (zero-based index)
				editable_enterToAccept : true,          // press enter to accept content, or click outside if false
				editable_autoAccept    : true,          // accepts any changes made to the table cell automatically (v2.17.6)
				editable_autoResort    : false,         // auto resort after the content has changed.
				editable_validate      : null,          // return a valid string: function(text, original, columnIndex){ return text; }
				editable_focused       : function(txt, columnIndex, $element) {
					// $element is the div, not the td
					// to get the td, use $element.closest('td')
					$element.addClass('focused');
				},
				editable_blur          : function(txt, columnIndex, $element) {
					// $element is the div, not the td
					// to get the td, use $element.closest('td')
					$element.removeClass('focused');
				},
				editable_selectAll     : function(txt, columnIndex, $element){
					// note $element is the div inside of the table cell, so use $element.closest('td') to get the cell
					// only select everthing within the element when the content starts with the letter "B"
					return /^b/i.test(txt) && columnIndex === 0;
				},
				editable_wrapContent   : '<div>',       // wrap all editable cell content... makes this widget work in IE, and with autocomplete
				editable_trimContent   : true,          // trim content ( removes outer tabs & carriage returns )
				editable_noEdit        : 'no-edit',     // class name of cell that is not editable
				editable_editComplete  : 'editComplete' // event fired after the table content has been edited
			}
		})
		.tablesorterPager({
			// target the pager markup - see the HTML block below
			container: $pager,
			size: 10,
			output: 'showing: {startRow} to {endRow} ({totalRows})'
		});

});
</script>
    </head>
    <body>
	<div id="dvLoading"></div>
        <!-- Home -->
        <div data-role="page" id="consulta">
			 <?  include "header.php"; ?>
            <div data-role="content">
			<?
				$listado .= "";
		   ?>


        <div class="pager" style="padding-left: 20px; padding-top: 20px;">
            <span class="pagedisplay"></span>
            <button id="clean" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >Borrar</button>
            <button id="save" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >Guardar</button>
        </div>
		<!--div align="right">
             <button id="clean" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >Borrar</button>
             <button id="save" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >Guardar</button>
        </div-->
		<div class="ui-grid-c ui-responsive">
			<div class="ui-block-a" style="width: 25%">
				<div data-role="fieldcontain">
					<fieldset data-role="controlgroup" data-mini="true">
						<label for="textinput1" id="margen_icono">
							Tipo de archivo
						</label>
						<select name="tipo_archivo" id="tipo_archivo">
							<option value="n/c">select</option>
							<? echo $option_tipo_archivo; ?>
						</select>
					</fieldset>
				</div>

				<div data-role="fieldcontain">
					<fieldset data-role="controlgroup" data-mini="true">
						<label for="textinput1" id="margen_icono">
							Número de Comprobante
						</label>
						<select name="numero_comprobante">
							<option value="n/c"><? echo $lang_seleccionar ?></option>
							<? echo $option_prefijos; ?>
						</select>
					</fieldset>
				</div>
			</div>
			<div class="ui-block-b" style="width: 30%">
				<div data-role="fieldcontain">
					<fieldset data-role="controlgroup" data-mini="true">
						<label for="textinput1" id="margen_icono">
							Código ObraSocial
						</label>
						<select name="obras_sociales" id="obras_sociales">
							<option value="n/c">select</option>
							<? echo $option_obras_sociales; ?>
						</select>
					</fieldset>
				</div>

				<div data-role="fieldcontain">
					<fieldset data-role="controlgroup" data-mini="true">
						<label for="textinput1" id="margen_icono">
							Código de Practica
						</label>
						<select name="codigo_practica">
							<option value="n/c"><? echo $lang_seleccionar ?></option>
							<? echo $option_prefijos; ?>
						</select>
					</fieldset>
				</div>
			</div>
			<div class="ui-block-c" style="width: 30%">
				<div data-role="fieldcontain">
					<fieldset data-role="controlgroup" data-mini="true">
						<label for="textinput1" id="margen_icono">
							CUIL
						</label>
						<select name="prefijo">
							<option value="n/c"><? echo $lang_seleccionar ?></option>
							<? echo $option_prefijos; ?>
						</select>
					</fieldset>
				</div>

				<div data-role="fieldcontain">
					<fieldset data-role="controlgroup" data-mini="true">
						<label for="textinput1" id="margen_icono">
							Provincia
						</label>
						<select name="provincia" id="provincia">
							<option value="n/c">select</option>
							<? echo $option_provincias; ?>
						</select>
					</fieldset>
				</div>
			</div>
			<div class="ui-block-d" style="width: 10%">
				<div data-role="fieldcontain">
					<fieldset data-role="controlgroup" data-mini="true">
						<label for="textinput1" id="margen_icono">
							Cant.registros
						</label>
						<input align="left" type="text" name="cantidadReg" id="cantidadReg" value="" style="width: 100px;"	 data-theme="a"/>
					</fieldset>
				</div>

				<div><button id="createLine" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >Crear Lineas</button></div>
			</div>
		</div>
    <form name="myForm" id="registros" action="guardar-regiistros.php" method="post" enctype="multipart/form-data">
			<table class="tablesorter" style="width: 100%; float: left;">
				<thead>
						<tr>
						 
						  <th>Tipo</th>
						  <th>Cod.Obra</th>
						  <th>CUIL</th>
						  <th>Cod.cert</th>
						  <th>Venc.cert</th>
						  <th>Per.prest</th>
						  <th>cuit.prest</th>
						  <th>T.compob</th>
						  <th>T.emicion</th>
						  <th>F.emicion</th>
						  <th>Num.CAE</th>
							<th>PuntoVenta</th>
							<th>Num.Comp</th>
							<th>ImportComp</th>
							<th>ImportSolic</th>
							<th>CodigoPrac</th>
							<th>Cantid</th>
							<th>Provincia</th>
							<th>Dependen</th>
						 
						  
						</tr>
		    </thead>
			<tfoot>
						<tr>

							<th>Tipo</th>
							<th>Cod.Obra</th>
							<th>CUIL</th>
							<th>Cod.cert</th>
							<th>Venc.cert</th>
							<th>Per.prest</th>
							<th>cuit.prest</th>
							<th>T.compob</th>
							<th>T.emicion</th>
							<th>F.emicion</th>
							<th>Num.CAE</th>
							<th>PuntoVenta</th>
							<th>Num.Comp</th>
							<th>ImportComp</th>
							<th>ImportSolic</th>
							<th>CodigoPrac</th>
							<th>Cantid</th>
							<th>Provincia</th>
							<th>Dependen</th>

						</tr>

			<td colspan="19">
				<div class="pager"> <span class="left">
					# per page:
					<a href="#" class="current">10</a> |
					<a href="#">25</a> |
					<a href="#">50</a> |
					<a href="#">100</a> |
					<a href="#">200</a>
				</span>
				<span class="right">
					<span class="prev">
						<img src="http://mottie.github.com/tablesorter/addons/pager/icons/prev.png" /> Prev&nbsp;
					</span>
					<span class="pagecount"></span>
					&nbsp;<span class="next">Next
						<img src="http://mottie.github.com/tablesorter/addons/pager/icons/next.png" />
					</span>
				</span>
				</div>
			</td>

		</tfoot>
	   <tbody>
	      <? echo $listado; ?>
	   </tbody>
	  </table>
	</form>


            </div>
        </div>
    </body>
</html>

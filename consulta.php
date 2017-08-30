<?php @session_start();
include ("conexion.php");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <title><? echo $titulo_pagina; ?>
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
    <link id="theme" rel="stylesheet" href="css/theme_<?=($_SESSION['color'])? $_SESSION['color']:'default';?>.css" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
       	       <script>

$(window).load(function() {
	$("#dvLoading").fadeOut("slow");
})
	</script>
		<!-- Demo stuff -->
	<link rel="stylesheet" href="pager/docs/css/jq.css">
	<link href="pager/docs/css/prettify.css" rel="stylesheet">
	<script src="pager/docs/js/prettify.js"></script>
	<script src="pager/docs/js/docs.js"></script>

	<!-- Tablesorter: required -->
	<link rel="stylesheet" href="pager/css/theme.blue.css">
	<script src="pager/js/jquery.tablesorter.js"></script>

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
	<script src="pager-custom-controls.js"></script>

	<script id="js">$(function(){

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
			widgets: ['editable'],
			widgetOptions: {
				editable_columns       : [0,1,2],       // or "0-2" (v2.14.2); point to the columns to make editable (zero-based index)
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
			size: 20,
			output: 'showing: {startRow} to {endRow} ({totalRows})'
		});

});
</script>
    </head>
    <body>
	<div id="dvLoading"></div>
        <!-- Home -->
        <div data-role="page" id="consulta">

            <div data-role="content">
                
                <div id="logo_consulta">
                    <img src="imagenes/logo.gif" />
                </div>
				
<?if ($_SESSION['usuario']!='')  {
			$seleccionar = mysql_query("SELECT nombre,sexo,pelo,camada,madre,padre,ubicacion,id_producto,grupo,rp,estado FROM productos WHERE 1 AND activo=1 AND estado<>'$origin_estado' AND originario <> 'Y' AND estado <> '$muerto_estado'");
			$totalFilas  = mysql_num_rows($seleccionar);  
				
						while ($row=mysql_fetch_array($seleccionar)) {
															$nombre = ($row[nombre]);
																$sexo = ($row[sexo]);
																$pelo = ($row[pelo]);
																$camada = ($row[camada]);
																$camada = substr($camada, 0, 4);
																$madre = ($row[madre]);
																$padre = ($row[padre]);
																$rp = ($row[rp]);
																$ubicacion = ($row[ubicacion]);
																$id_producto	= ($row[id_producto]);
																$id_caballo	= ($row[id_producto]);
																$grupo = ($row[grupo]);
																$estado = ($row[estado]);
																
				$listado .= "
				<tr>
				<td><div class=\"check_center\"><input id=$id_producto\" name=\"$id_producto\" type=\"checkbox\" value=\"$id_producto\"  /></div></td>
				 <td><a href=\"detalle_caballos.php?id=$id_producto\" data-rel=\"external\" rel=\"external\">$nombre</a></td>
				  <td>$padre</td>
				  <td>$madre</td>
				  <td>$rp</td>
				  <td>$sexo</td>
				  <td>$pelo</td>
				  <td>$camada</td>
				  <td>$ubicacion</td>
				  <td>$grupo</td>
				  <td>$estado</td>
				 
				  </tr>
				  ";
				  }
?>				

<!-- pager -->
<div class="pager">
	<span class="pagedisplay"></span> 
</div>

<form name="myForm" action="mostrar_tabla.php" method="post" enctype="multipart/form-data">
<div class="botones_check"><button data-theme="b" data-mini="true" type="submit" data-icon="arrow-r"><? echo $lang_cambios_masivos ?></button></div>

<table class="tablesorter" style="width: 100%; float: left;">
	<thead>
						<tr>
						  <th></th>
						  <th><? echo $lang_nombre ?></th>
						  <th><? echo $lang_padre; ?></th>
						  <th><? echo $lang_madre; ?></th>
						  <th>RP</th>
						  <th><? echo $lang_sexo; ?></th>
						  <th><? echo $lang_pelaje; ?></th>
						  <th><? echo $lang_camada; ?></th>
						  <th><? echo $lang_ubicacion; ?></th>
						  <th><? echo $lang_grupo; ?></th>
						   <th><? echo $lang_estado; ?></th>
						 
						  
						</tr>
					  </thead>
	<tfoot>
		<tr>
						  <th></th>
						  <th><? echo $lang_nombre ?></th>
						  <th><? echo $lang_padre; ?></th>
						  <th><? echo $lang_madre; ?></th>
						  <th>RP</th>
						  <th><? echo $lang_sexo; ?></th>
						  <th><? echo $lang_pelaje; ?></th>
						  <th><? echo $lang_camada; ?></th>
						  <th><? echo $lang_ubicacion; ?></th>
						  <th><? echo $lang_grupo; ?></th>
						  <th><? echo $lang_estado; ?></th>
						  
						</tr>
		<tr>
			<td colspan="11">
				<div class="pager"> <span class="left">
					# per page:
					<a href="#" class="current">20</a> |
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
		</tr>
	</tfoot>
	<tbody>
	<? echo $listado; ?>
	</tbody>
</table>

</form>
<div class="float_left"><p>Haciendo click en el simbolo <img src="imagenes/flechas_ordenamiento.gif" alt=""/> puede ordenar ascendente o descendente dicho campo, con la tecla "Ctrl" y haciendo click en el titulo de cada campo se puede concatenar ordenamietos.</p></div>
<?
			} else {
					echo $lang_error_mensaje1;
				}	?>
            </div>
        </div>
    </body>
</html>

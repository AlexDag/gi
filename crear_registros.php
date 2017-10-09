<?php session_start();
include ("conexion.php");
include("common.php");
//error_reporting( error_reporting() & ~E_NOTICE );


$option_tipo_archivo	= add_options(get_tipo_archivo($pdo));
$option_provincias	= add_options(get_provincias($pdo));
$option_obras_sociales	= add_options(get_obras_sociales($pdo));
$option_dependencias	= add_options(get_dependencias($pdo));
$option_practicas	= add_options(get_practicas($pdo));

$listado="";

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
		<script src="js/common.js"></script>

<script>


    function copyFirstCell(celId)
    {
        $allRows = $('tbody').find('tr');
        rlength = $allRows.length;
        val = $allRows.eq(0).find('td').eq(celId).text();

        for (var i=1;i<rlength;i++){
            if($allRows.eq(i).find('td').eq(celId).text()==='') {
                $allRows.eq(i).find('td').eq(celId).find('[contenteditable]').text(val);
            }
        }

        $allRows.eq(0).find('td').eq(celId).find('[contenteditable]').focus();
    }

$(window).load(function() {
	$("#dvLoading").fadeOut("slow");
})
	</script>


    <!-- Tablesorter: required -->
    <!--link rel="stylesheet" href="pager/css/theme.blue.css">
    <script src="pager/js/jquery.tablesorter.js"></script>
    <script src="pager/js/parsers/parser-input-select.js"></script>
    <script src="pager/js/jquery.tablesorter.widgets.js"></script>
    <script src="pager/js/widgets/widget-editable.js"></script-->
    <link rel="stylesheet" href="https://mottie.github.io/tablesorter/css/theme.blue.css">
    <script src="https://mottie.github.io/tablesorter/js/jquery.tablesorter.js"></script>
    <script src="https://mottie.github.io/tablesorter/js/jquery.tablesorter.widgets.js"></script>
    <script src="https://mottie.github.io/tablesorter/js/widgets/widget-editable.js"></script>





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
	<script src="pager/js/pager-custom-controls.js"></script
        >

	<script id="js">$(function(){




			$("input[type='radio']").bind( "change", function(event, ui) {
				console.log(ui);

				$("input[type='radio']").attr("checked",false).checkboxradio("refresh");
				event.currentTarget.checked = true;
				//$("input[type='radio']").checkboxradio("refresh");
			});

            /*$(document).on("keydown", function(e) {
                console.log(e.type, e.target);
                //alert(e.type+' ... '+ e.target);
                //e.keyCode==9  tab
                //e.currentTarget.activeElement.attributes[1].firstChild ==

                if(e.ctrlKey && e.keyCode == 68){

                }
            })*/


			$(document).on('change', '.targetSelected', function(e) {
				//console.log(this.options[e.target.selectedIndex].text);
				//console.log(e.target.id);  // field name
				//console.log(e.target.parentElement.parentElement.id); // id producto
				//console.log('select value:'+this.options[e.target.selectedIndex].value);
				//$("#select_id").val("val2").change();
				//e.target.setAttribute('val',this.options[e.target.selectedIndex].value);

			});

            function editComplete(el) {
                var $el = $(el),
                    newContent = $el.text(),
                // there shouldn't be any colspans in the tbody
                    cellIndex = el.cellIndex,
                // data-row-index stored in row id
                    rowIndex = $el.closest('tr').attr('id');

            };


            function moveCells(el, dir) {
                var $el = $(el),
                    changed = false,
                // there shouldn't be any colspans in the tbody
                    cellIndex = el.cellIndex,
                    $allRows = $el.closest('tbody').find('tr'),
                    rowIndex = $allRows.index($el.closest('tr'));
                if (dir === "ArrowUp" && rowIndex - 1 >= 0) {
                    rowIndex--;
                    changed = true;
                } else if (dir === "ArrowDown" && rowIndex + 1 < $allRows.length) {
                    rowIndex++;
                    changed = true;
                }
                if (changed) {
                    $el.blur();
                    $allRows.eq(rowIndex).find('td').eq(cellIndex).find('[contenteditable]').focus();
                }
            };


            function onSuccess(data, status)
            {

                var $table = $('table');

                $.tablesorter.clearTableBody( $table[0] );
                $table
                    .trigger('update');

				window.location.href = 'download_registro.php?p=' + data.message;

		    };

            function onError(data, status)
            {
                alert('error:'+data.statusText);
            };



            $('body').on('click','.rowclick',function(){
                var idrow =   this.parentElement.id;
                $('#'+idrow).remove();
                $table
                    .trigger('update');
            });

            $("#save").click(function(){

               var data=[];
                var register =  makeidAlfaNumber(20);
                $('tbody').find('tr').each(function(){
                     var count = this.childElementCount;
                     var indexed_array = {};

                     for(var i=0;i<count;i++){
							 indexed_array[i] =   this.children[i].textContent;

                     }

                    indexed_array[count] = register;
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
			$(".createLine").click(function() {
				//var cantidadReg = $("#cantidadReg").val();
                //console.log(this);
                var countInt =  0;
                if(this.id==='l1')
				  var countInt =  1;
                else
                if(this.id==='l2')
                    var countInt =  2;
                if(this.id==='l3')
                    var countInt =  3;

                var tipo_archivo = $("#tipoarchivo :radio:checked").val();

                var practicas = $('#practicas option:selected').val();


                var row='';
				for(var i=0;i<countInt;i++){


					    row += '<tr r="R" id='+makeidAlfaNumber(5)+'>'+
							'<td class="no-edit rowclick"><img src="css/images/none_thumb.jpg" style="width: 10px;"></td>'+
                            '<td class="no-edit">'+tipo_archivo+'</td>'+
                            '<td t="C"></td>' + /*obras*/
                            '<td t="C"></td>'+ /*cuil*/
                            '<td t="C"></td>'+/*codigo certificado*/
                            '<td t="C" ></td>'+/*vencimiento certificado*/
                            '<td t="C" ></td>'+/*periodo prestacion*/
							'<td t="C" ></td>'+/*CUIT prestador*/
                            '<td t="C" ></td>'+/*tipo de comprobante*/
                            '<td t="C" ></td>'+/*tipo emision*/
                            '<td t="C" ></td>'+/*fecha de emision */
                            '<td t="C" ></td>'+/*numero CAE o CAI*/
                            '<td t="C" ></td>'+/*punto de venta*/
							'<td t="C" ></td>'+ /*numero comprobante*/
                            '<td t="C" ></td>'+/*importe de comprobante*/
                            '<td t="C" ></td>'+/*importe solicitado*/
                            '<td t="C" >'+practicas+'</td>'+/*codigo de practica*/
                            '<td t="C" ></td>'+/*cantidad*/
                            '<td t="C" ></td>'+/*provincia*/

                            '</tr>',
						 $row = $(row),
						resort = true;

				}
				$('table')
					.find('tbody').append($row)
					.trigger('addRows', [$row, resort]);

                $('table')
                    .trigger('update');


                var allRows = $("[r=R]");
                numOfRows = $("[r=R]").length;
               rowObj = $("[r=R]");
                 oneColLength = rowObj[0].children.length-1;// menos celda de delete image
                 //colObj = document.getElementsByTagName('td');
                colObj = $("[t=C]");
                 totalData = rowObj.length * colObj.length;
                 dataCounter = 0;
                 matrixObj = new Array(rowObj.length);

                for(var i = 0; i < matrixObj.length; i++){
                    matrixObj[i] = new Array(oneColLength);
                }

                for(var i = 0; i < numOfRows; i++){
                    for(var j = 0; j < oneColLength; j++){
                        matrixObj[i][j] = colObj[dataCounter++];
                    }
                }

               // $allRows.eq(rowIndex).find('td').eq(cellIndex).find('[contenteditable]').focus();
                $(matrixObj[0][0]).find('[contenteditable]').focus();

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
				0: {resizable: false, filter: false, sorter: false},
				1: {resizable: true, filter: true, sorter: true},
				2: {resizable: true, filter: true, sorter: false},
				3: {resizable: true, filter: true, sorter: false},
				4: {resizable: true, filter: false, sorter: false},
				5: {resizable: true, filter: false, sorter: false},
				6: {resizable: true, filter: false, sorter: false},
				7: {resizable: true, filter: false, sorter: false},
				8: {resizable: true, filter: false, sorter: false},
				9: {resizable: true, filter: false, sorter: false},
				10: {resizable: true, filter: false, sorter: false},
				11: {resizable: true, filter: false, sorter: false},
				12: {resizable: true, filter: false, sorter: false},
				13: {resizable: true, filter: false, sorter: false},
				14: {resizable: true, filter: false, sorter: false},
				15: {resizable: true, filter: false, sorter: false},
				16: {resizable: true, filter: false, sorter: false},
				17: {resizable: true, filter: false, sorter: false},
                18: {resizable: true, filter: false, sorter: false},

			},
			widgets: ['zebra', 'columns','editable','filter'],
			widgetOptions: {
				editable_columns       : [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18],       // or "0-2" (v2.14.2); point to the columns to make editable (zero-based index)
				editable_enterToAccept : false,          // press enter to accept content, or click outside if false
				editable_autoAccept    : true,          // accepts any changes made to the table cell automatically (v2.17.6)
				editable_autoResort    : false,         // auto resort after the content has changed.
				editable_validate      : null,
                editable_focused: function(txt, columnIndex, $element) {
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
		})

        .children('tbody').on('editComplete keyup', 'td', function(event, config) {
            if (event.type === 'editComplete') {
                editComplete(this);
            } else if (event.key.indexOf('Arrow') === 0) {
                moveCells(this, event.key);
            }
        });


});
</script>
    </head>
    <body>
	<div id="dvLoading"></div>
        <!-- Home -->
        <div data-role="page" id="consulta">
			 <?php  include "header.php"; ?>
            <div data-role="content">
			<?php
				$listado .= "";
		   ?>
        <div class="pager" style="padding-left: 20px; padding-top: -20px; margin: 0px; " >



            <div class="ui-grid-c">
                <div class="ui-block-a" style="width:20%;">

                            <!--span class="pagedisplay"></span-->

					<fieldset id="tipoarchivo" class="reducewidth" data-role="controlgroup" data-type="horizontal">

						<input type="radio" name="checkbox-h-2a" id="checkbox-h-2a" value="DC" checked="checked">
						<label for="checkbox-h-2a">DC</label>
						<input type="radio" name="checkbox-h-2b" id="checkbox-h-2b" value="DB">
						<label for="checkbox-h-2b">DB</label>
						<input type="radio" name="checkbox-h-2c" id="checkbox-h-2c" value="DS">
						<label for="checkbox-h-2c">DS</label>
					</fieldset>



                            <!--button tabindex="-1" id="clean" data-theme="b" type="button" href="" data-mini="false" data-inline="true" >Borrar</button-->



                </div>
                <div class="ui-block-b" style="width:30%;">

                    <div data-role="fieldcontain">
                        <label class="labelpractica">
                            Código practica
                        </label>
                        <fieldset data-role="controlgroup" data-mini="true">

                            <select name="practicas" id="practicas"class="selectPractica" >
                                <option value="n/c">SELECT</option>
                                <?php echo $option_practicas; ?>
                            </select>
                        </fieldset>
                    </div>

                </div>
                <div class="ui-block-c" style="width:30%;">

					<button tabindex="-1" class="createLine" id="l1" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >1 Linea</button>
                    <button tabindex="-1" class="createLine" id="l2" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >2 Lineas</button>
                    <button tabindex="-1" class="createLine" id="l3" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >3 Lineas</button>
                </div>
                <div class="ui-block-d" style="width:10%;">
                    <button tabindex="-1" id="save" data-theme="b" type="button" href="" data-mini="false" data-inline="true" >Guardar</button>
                </div>
            </div>
        </div>

		<!--div align="right">
             <button id="clean" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >Borrar</button>
             <button id="save" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >Guardar</button>
        </div-->

    <form name="myForm" id="registros" action="" method="post" enctype="multipart/form-data">

<!--
 <th>First Name<a href="#" onClick="showDiv(2);"><img src="https://cdn0.iconfinder.com/data/icons/ie_Bright/512/plus_add_green.png" style="float:right;width:20px;" /></a></th>
 -->


			<table id="table" class="tablesorter" style="width: 100%; float: left;">
				<thead>
						<tr>
                          <th></th>
						  <th>Tipo</th>
						  <th>Cod.Obra<a href="#" onClick="copyFirstCell(2);"><img src="css/images/plus_add_green.png" style="float:right;width:12px;"/></a></th>
						  <th>CUIL<a href="#" onClick="copyFirstCell(3);"><img src="css/images/plus_add_green.png" style="float:right;width:12px;"/></a></th>
						  <th>Cod.cert<a href="#" onClick="copyFirstCell(4);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
						  <th>Venc.cert<a href="#" onClick="copyFirstCell(5);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
						  <th>Per.prest<a href="#" onClick="copyFirstCell(6);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
						  <th>cuit.prest<a href="#" onClick="copyFirstCell(7);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
						  <th>T.comprob<a href="#" onClick="copyFirstCell(8);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
						  <th>T.emicion<a href="#" onClick="copyFirstCell(9);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
						  <th>F.emicion<a href="#" onClick="copyFirstCell(10);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
						  <th>Num.CAE<a href="#" onClick="copyFirstCell(11);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
							<th>PuntoVenta<a href="#" onClick="copyFirstCell(12);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
							<th>Num.Comp<a href="#" onClick="copyFirstCell(13);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
							<th>ImportComp<a href="#" onClick="copyFirstCell(14);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
							<th>ImportSolic<a href="#" onClick="copyFirstCell(15);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
							<th>CodigoPrac<a href="#" onClick="copyFirstCell(16);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
							<th>Cantid<a href="#" onClick="copyFirstCell(17);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>
							<th>Provincia<a href="#" onClick="copyFirstCell(18);"><img src="css/images/plus_add_green.png" style="float:right;width:10px;"/></a></th>

						 
						  
						</tr>
		    </thead>
                <tbody>
                <?php echo $listado; ?>

                </tbody>


			<tfoot>
						<tr>
							<th></th>
							<th>Tipo</th>
							<th>Cod.Obra</th>
							<th>CUIL</th>
							<th>Cod.cert</th>
							<th>Venc.cert</th>
							<th>Per.prest</th>
							<th>cuit.prest</th>
							<th>T.comprob</th>
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

	  </table>
	</form>


            </div>
        </div>
    </body>

<script>




</script>
</html>

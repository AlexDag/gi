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


    <script src="datepicker/ui/jquery.ui.core.js"></script>
    <script src="datepicker/ui/jquery.ui.widget.js"></script>
    <script src="datepicker/ui/jquery.ui.datepicker.js"></script>


    <link rel="stylesheet" href="datepicker/themes/base/jquery.ui.datepicker.css">
    <link rel="stylesheet" href="datepicker/themes/base/jquery.ui.theme.css">



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

            $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy',
                yearRange: '2010:2017'
            });
            $('.datepicker').datepicker()
                .on("input change", function (e) {
                    console.log("Date changed: ", e.target.value);
                    // founded_regisdters
                    $.ajax({
                        type: "POST",
                        url: "load_registrosByDate.php",
                        cache: false,
                        data: {datos:e.target.value},
                        success: onSuccessGetRegistersByDate,
                        error: onError
                    });



                });
            $(document).on("keydown", function(e) {
                console.log(e.type, e.target);
                //alert(e.type+' ... '+ e.target);
                //e.keyCode==9  tab
                //e.currentTarget.activeElement.attributes[1].firstChild ==

                //  td.focus();
            })

            $(document).ready(function()
            {

            });

            $(document).on('change', '.targetSelected', function(e) {
                //console.log(this.options[e.target.selectedIndex].text);
                //console.log(e.target.id);  // field name
                //console.log(e.target.parentElement.parentElement.id); // id producto
                //console.log('select value:'+this.options[e.target.selectedIndex].value);
                //$("#select_id").val("val2").change();
                //e.target.setAttribute('val',this.options[e.target.selectedIndex].value);

            });

            $('.register_founded').on('click', 'li', function () {
                // call to get registers
                //console.log(this);
                //this.attributes.reg.value
                $.ajax({
                    type: "POST",
                    url: "load_registrosByValue.php",
                    cache: false,
                    data: {datos:this.attributes.reg.value},
                    success: onSuccessGetRegistersById,
                    error: onError
                });
            });
            function onSuccessGetRegistersById(data, status)
            { //add row to table....


                var $table = $('table');

                $.tablesorter.clearTableBody( $table[0] );
                $table
                    .trigger('update');

                var row='';
                for (var i=0;i<data.data.length;i++){

                    row += '<tr>'+
                        '<td tipo>'+data.data[i].tipo_archivo+'</td>'+
                        '<td obras>'+data.data[i].obras_socilales+'</td>' +
                        '<td cuil>'+data.data[i].cuil+'</td>'+ /*cuil*/
                        '<td certificado tabindex="1">'+data.data[i].codigo_certificado+'</td>'+/*codigo certificado*/
                        '<td vencimiento tabindex="2" >'+data.data[i].vencim_certificado+'</td>'+/*vencimiento certificado*/
                        '<td tabindex="3">'+data.data[i].periodo_prestacion+'</td>'+/*periodo prestacion*/
                        '<td tabindex="4" >'+data.data[i].cuit_prestador+'</td>'+/*CUIT prestador*/
                        '<td tabindex="5" >'+data.data[i].tipo_comprobante+'</td>'+/*tipo de comprobante*/
                        '<td tabindex="5" >'+data.data[i].tipo_emision+'</td>'+/*tipo emision*/
                        '<td tabindex="7" >'+data.data[i].fecha_emision+'</td>'+/*fecha de emision */
                        '<td tabindex="8" '+data.data[i].nro_cae+'</td>'+/*numero CAE o CAI*/
                        '<td tabindex="9" >'+data.data[i].punto_venta+'</td>'+/*punto de venta*/
                        '<td tabindex="10">'+data.data[i].nro_comprobante+'</td>'+ /*numero comprobante*/
                        '<td tabindex="11">'+data.data[i].importe_comprobante+'</td>'+/*importe de comprobante*/
                        '<td tabindex="12">'+data.data[i].importe_solicitado+'</td>'+/*importe solicitado*/
                        '<td tabindex="13">'+data.data[i].codigo_practica+'</td>'+/*codigo de practica*/
                        '<td tabindex="14">'+data.data[i].cantidad+'</td>'+/*cantidad*/
                        '<td>'+data.data[i].provincia+'</td>'+
                        '<td>'+data.data[i].dependencia+'</td>'+/*dependencia*/
                        '</tr>',
                        $row = $(row),
                        resort = true;
                }
                $('table')
                    .find('tbody').append($row)
                    .trigger('addRows', [$row, resort]);

                $('table')
                    .trigger('update');
            };
            function onSuccessGetRegistersByDate(data, status)
            {    // add item to list
                var lis = '';
                for(var i= 0;i<data.data.length;i++){
                    lis+="<li  reg="+data.data[i].registro_unico+"><a href=''>"+data.data[i].fecha_creacion+"</a></li>";
                }

                console.log('fecha:'+lis);
                $('.register_founded').html(lis);
            };

            function onError(data, status)
            {
                alert('error:'+data.statusText);
            };


            $("#save").click(function(){
                // bajar los regitros a un archivo
                var data=[];

                $('tbody.registros').find('tr').each(function(){
                    var count = this.childElementCount;
                    var indexed_array = {};

                    for(var i=0;i<count;i++){
                            indexed_array[i] =   this.children[i].textContent;
                    }

                    data.push(indexed_array);


                });
                if(data.length===0){
                    alert('NO hay registros para re-crear los archivos...');
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "crear_archivos.php",
                    cache: false,
                    data: {datos:data},
                    success: onSuccessCrearArchivos,
                    error: onError
                });
            });
            function onSuccessCrearArchivos(data, status)
            {
                window.location.href = 'download_registro.php?p=' + data.message;

            };

            $("#clean").click(function() {
                var $table = $('table');

                $.tablesorter.clearTableBody( $table[0] );
                $table
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
                        0: {resizable: true, filter: true, sorter: true},
                        1: {resizable: true, filter: true, sorter: true},
                        2: {resizable: true, filter: true, sorter: true},
                        3: {resizable: true, filter: true, sorter: true},
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
                        18: {resizable: true, filter: true, sorter: true}

                    },
                    widgets: ['zebra', 'columns','filter'],
                    widgetOptions: {
                        editable_columns       : [],       // or "0-2" (v2.14.2); point to the columns to make editable (zero-based index)
                        editable_enterToAccept : false,          // press enter to accept content, or click outside if false
                        editable_autoAccept    : false,          // accepts any changes made to the table cell automatically (v2.17.6)
                        editable_autoResort    : false,         // auto resort after the content has changed.
                        editable_validate      : null,          // return a valid string: function(text, original, columnIndex){ return text; }

                        editable_wrapContent   : '<div>',       // wrap all editable cell content... makes this widget work in IE, and with autocomplete
                        editable_trimContent   : true,          // trim content ( removes outer tabs & carriage returns )
                        editable_noEdit        : 'no-edit',     // class name of cell that is not editable

                    }
                })
                .tablesorterPager({
                    // target the pager markup - see the HTML block below
                    container: $pager,
                    size: 10,
                    output: 'showing: {startRow} to {endRow} ({totalRows})'
                })

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
        <div class="pager" style="padding-left: 20px; padding-top: -20px; margin: 0px; " >
            <div class="ui-grid-b">
                <div class="ui-block-a" style="width:30%;">

                    <span class="pagedisplay"></span>
                    <button tabindex="-1" id="save" data-theme="b" type="button" href="" data-mini="false" data-inline="true" >Bajar archivo</button>

                </div>
                <div class="ui-block-b" style="width:20%;">
                    <div data-role="fieldcontain">
                        <fieldset>
                            <legend for="datepicker">
                                Fecha
                            </legend>
                            <input name="fecha_busqueda" class="datepicker" placeholder="" value="" data-type="date"/>
                        </fieldset>
                    </div>



                </div>
                <div class="ui-block-c" style="width:50%;">
                    <div id="founded_regisdters">
                        <ul class="register_founded">

                        </ul>

                    </div>
                </div>

            </div>
        </div>

        <!--div align="right">
             <button id="clean" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >Borrar</button>
             <button id="save" data-theme="b" type="button" href="home.html" data-mini="false" data-inline="true" >Guardar</button>
        </div-->





        <form name="myForm" id="registros" action="" method="post" enctype="multipart/form-data">
            <table id="idtable" class="tablesorter" style="width: 100%; float: left;">
                <thead>
                <tr>

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
                    <th>Depend</th>


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
                    <th>Depend</th>
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
                <tbody class="registros">
                <? echo $listado; ?>
                </tbody>
            </table>
        </form>


    </div>
</div>
</body>
</html>

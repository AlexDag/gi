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

        }
    </style>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/tabla.css" />
    <link rel="stylesheet" href="css/jquery.mobile-1.3.1.min.css" />
    <link rel="stylesheet" href="datepicker/themes/base/jquery.ui.theme.css">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
    <script src="js/config.js"></script>
    <script>

        $(window).load(function() {
            $("#dvLoading").fadeOut("slow");
        })
    </script>
    <!-- Demo stuff -->
    <!--link rel="stylesheet" href="pager/docs/css/jq.css"-->
    <!--link href="pager/docs/css/prettify.css" rel="stylesheet"-->
    <!--script src="pager/docs/js/prettify.js"></script-->
    <!--script-- src="pager/docs/js/docs.js"></script-->

    <!-- Tablesorter: required -->
    <link rel="stylesheet" href="pager/css/theme.blue.css">
    <script src="pager/js/jquery.tablesorter.js"></script>
    <script src="pager/js/parsers/parser-input-select.js"></script>
    <script src="pager/js/jquery.tablesorter.widgets.js"></script>
    <script src="pager/js/widgets/widget-editable.js"></script>


    <!-- Tablesorter: optional -->
    <!--link rel="stylesheet" href="pager/addons/pager/jquery.tablesorter.pager.css"-->
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
    <script src="js/scriptConsulta4.js"></script>
    <link rel="stylesheet" href="pager/docs/css/jq.css">
    <script id="js">$(function(){

            String.format = function() {
                // The string containing the format items (e.g. "{0}")
                // will and always has to be the first argument.
                var theString = arguments[0];

                // start with the second argument (i = 1)
                for (var i = 1; i < arguments.length; i++) {
                    // "gm" = RegEx options for Global search (more than one instance)
                    // and for Multiline search
                    var regEx = new RegExp("\\{" + (i - 1) + "\\}", "gm");
                    theString = theString.replace(regEx, arguments[i]);
                }

                return theString;
            }


            $.mobile.loading( 'show', {
                text: '',
                textVisible: false,
                theme: 'z',
                html: ""
            });


            $(".showmodal").click(function() {
                $("#myModal").show();

            });
            $("#btnOK").click(function() {
                $("#myModal").hide();
            });

            $(document).on('change', '.targetSelected', function(e) {
                //console.log(this.options[e.target.selectedIndex].text);
                //console.log(e.target.id);  // field name
                //console.log(e.target.parentElement.parentElement.id); // id producto
                ///\console.log(this.options[e.target.selectedIndex].value);

                $.ajax({
                    type: "POST",
                    url: 'updateFromTablesorter.php?id='+e.target.parentElement.parentElement.id+'&field='+e.target.id+'&value='+this.options[e.target.selectedIndex].value,
                    data: null,
                    cache: false,
                    dataType: "text"

                });
            });

            $("#checkboxCheckAll").click(function(e){
                if($(this).is(':checked')) {
                    $('.tablesorter input[type=checkbox]').prop('checked', true);
                   // $('.tablesorter input[type=checkbox]').trigger('change');
                }
                else{
                    $('.tablesorter input[type=checkbox]').prop('checked', false);
                    //$('.tablesorter input[type=checkbox]').trigger('change');
                }

               // $(table).trigger("update");
            });


            $("#EditableClick").click(function(e){
                if($(this).is(':checked')) {
                    var editable_elements = document.querySelectorAll(".targetSelected");
                    for(var i=0; i<editable_elements.length; i++) {
                        editable_elements[i].removeAttribute("disabled" );
                    }
                    var editable_elements = document.querySelectorAll("[contenteditable=false]");
                    for(var i=0; i<editable_elements.length; i++)
                        editable_elements[i].setAttribute("contentEditable", true);
                }
                else{
                    var editable_elements = document.querySelectorAll(".targetSelected");
                    for(var i=0; i<editable_elements.length; i++)
                        editable_elements[i].setAttribute("disabled", true);

                    var editable_elements = document.querySelectorAll("[contenteditable=true]");
                    for(var i=0; i<editable_elements.length; i++)
                        editable_elements[i].setAttribute("contentEditable", false);
                }
            });

            $("#pdfClick").click(function(e){
                $('#formConsulta4').attr("target","_blank");  // "_blanks");
                $('#formConsulta4').attr('action', "reportes/pdf_tabla.php");//.submit();
            });

            $("#masivoClick").click(function(e){

                $("#checkboxCheckAll").attr("checked",false).checkboxradio("refresh");
                $('#formConsulta4').attr("target","_blank");

                $('#formConsulta4').attr('action', "mostrar_tabla-2.php");//.submit();
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
                    headers:{

                        0: { resizable: true ,filter: false , sorter:false},
                        3: { sorter: "select" },
                        11: { resizable: true ,filter: false , sorter:false},
                        12: { resizable: true ,filter: false , sorter:false},
                        13: { resizable: true ,filter: false , sorter:false}, // image
                        14: { resizable: true ,filter: false , sorter:false}, // video
                        15: { resizable: true ,filter: false , sorter:false},
                        16: { resizable: true ,filter: false , sorter:false}

                    },
                    sortMultiSortKey: 'ctrlKey',
                    checkboxClass : 'checked',
                    widgets: ["filter","zebra","columns","editable"],
                    widgetOptions : {

                        editable_columns       : [2-4],       // or "0-2" (v2.14.2); point to the columns to make editable (zero-based index)
                        editable_enterToAccept : true,          // press enter to accept content, or click outside if false
                        editable_autoAccept    : false,          // accepts any changes made to the table cell automatically (v2.17.6)
                        editable_autoResort    : false,         // auto resort after the content has changed.
                        editable_validate      : null,


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
                        editable_editComplete  : 'editComplete' ,// event fired after the table content has been edited



                        filter_columnFilters : true,
                        // if true, server-side filtering should be performed because client-side filtering will be disabled, but
                        // the ui and events will still be used.
                        filter_serversideFiltering : true,
                        //filter_external : '.search',
                        // add a default type search to the first name column
                        //filter_defaultFilter: { 1 : '~{query}' },
                        // include column filters
                        filter_columnFilters: true,
                        filter_searchDelay : 300,
                        //filter_searchFiltered: true,
                        //filter_placeholder: { search : 'Search...' },
                        //filter_saveFilters : true,
                        filter_reset: '.reset'
                    }



                })


                .tablesorterPager({
                    // target the pager markup - see the HTML block belowcontainer: $pager,
                    container: $(".pager"),
                    size: 20,
                    output: 'showing: {startRow} to {endRow} ({totalRows})',
                    ajaxUrl : 'consulta_2sql.php?&page={page}&size={size}&{filterList:filter}&{sortList:column}',
                    //ajaxUrl : 'acciones4_sql.php?page={page}&size={size}&{filterList:filter}&{sortList:column}',
                    processAjaxOnInit: true,
                    // starting page of the pager (zero based index)
                    page: 0,
                    ajaxObject: {
                        dataType: 'json'
                    },
                    ajaxProcessing: function(result){

                        if (result && result.hasOwnProperty('data')) {
                            var len =result.data.length;
                            //stop process.!!!!!
                            if(len==0) {
                                $.mobile.loading( 'hide');
                                return 0;
                            }

                            var rows='';
                            var popup='';
                            var optPadres =result.data[0].options.opadres;
                            var optMadres=result.data[0].options.omadres;
                            var optPelo=result.data[0].options.opelo;
                            var optCamada=result.data[0].options.ocamada;
                            var optUbicacion=result.data[0].options.oubic;
                            var optGrupo=result.data[0].options.ogrupo;
                            var optEstado=result.data[0].options.oestado;
                            for (i = 1; i < len; i++) {
                                var row =    result.data[i][i-1];

                                var id = "<tr id='"+row.id_caballo+"' title='" +row.titulo+ "' class='" +row.rowcolor+ "'><td><div class='checkboxClass'> <input id=" +row.id_producto+ " name='" +
                                    row.id_producto +"' type='checkbox' value='"+ row.id_producto + "'></div></div></td>";
                                var nombreRow =  "<td><a href='detalle_caballos.php?id=" +row.id_producto+ "' data-rel='external' rel='external'>"+row.nombre+"</a></td>";

                                var option_productos_padres = add_options(getOptions(optPadres),row.padre);
                                var padreRow = '<td>'+getSelectMainPart('padre',row.padre)+ option_productos_padres + '</select></td>';

                                var option_productos_madres = add_options(getOptions(optMadres),row.madre);
                                var madreRow = '<td>'+getSelectMainPart('madre',row.madre)+ option_productos_madres + '</select></td>';

                                var rpRow = '<td contenteditable=\"false\" ><div contenteditable=\"false\">'+row.rp+'</div></td>';
                                var lang = "<? echo $lang?>";
                                var sexoRow= '<td>'+getSelectMainPart('sexo',row.sexo)+getSexoOption(row.sexo,lang)+'</select></td>';

                                var option_pelo =add_options(getOptions(optPelo), row.pelo);
                                var option_pelo =  option_pelo.replace('"', '\"');
                                var peloRow= '<td>'+getSelectMainPart('pelo',row.pelo)+option_pelo+ '</select></td>';

                                var option_camadas	= add_options(getOptions(optCamada), row.camada);
                                var option_camadas =  option_camadas.replace('"', '\"');
                                var camadaRow= '<td>'+getSelectMainPart('camada',row.camada)+option_camadas +'</select></td>';

                                var option_ubicacion	= add_options(getOptions(optUbicacion),row.ubic);
                                var option_ubicacion = option_ubicacion.replace('"', '\"');
                                var ubicacionRow = '<td>'+getSelectMainPart('ubicacion',row.ubic)+option_ubicacion +'</select></td>';

                                var option_grupos = add_options(getOptions(optGrupo),  row.grupo);
                                var option_grupos = option_grupos.replace('"', '\"');
                                var grupoRow = '<td style=\\"max-width: 150px;\\">'+getSelectMainPart('grupo',row.grupo)+ option_grupos +'</select></td>';

                                var option_estados	= add_options(getOptions(optEstado),row.estado);
                                var option_estados =  option_estados.replace('"', '\"');
                                var estadoRow = '<td>'+getSelectMainPart('estado',row.estado)+option_estados + '</select></td>';


//row.id_caballo+"
                                var camera = ver_imagen_btn(row.id_caballo,row.path_imagen);

                                var video = ver_video( row.vurl==='T'?row.id_caballo:"");
                                var hisImage = String.format( "historia1.php?id_producto={0}&tipo=producto",row.id_caballo); // "'&tipo='producto' target='_blank'";
                                var  historiaImg= "<td><div><a href='"+hisImage+"' target=&quot;_blank&quot;><img src='imagenes/registro_vet.png' class='reduceImg' border='0'/></a></div></td>";



                                var pdf_producto ="<td><a href='reportes/pdf_producto.php?id_producto="+row.id_producto+"' data-role='button'  data-inline='true' data-theme='a' target='_blank'>"+
                                "<img src='imagenes/planilla_trabajo.jpg' class='reduceImg' border='0' alt='' /></a></td>";


                                var images="<td><div><a rel='external' href='modificar_p_admin.php?id_producto="+row.id_caballo+
                                    "'><img src='imagenes/edit.png' class='reduceImg' border='0' alt=''>"+
                                    "</a></div></td><td><div><a href='producto_a_eliminar.php?id_producto="+row.id_caballo+
                                    "'><img src='imagenes/delete.png' class='reduceImg' border='0' alt=''></a></div></td>"+
                                    camera+video+historiaImg+pdf_producto;

                                rows +=id+nombreRow+padreRow+madreRow+rpRow +sexoRow+ peloRow+camadaRow+ubicacionRow+grupoRow+estadoRow+images+"</tr>";

                                //var popup =ver_imagen_popup(row.id_caballo,row.path_imagen);






                            }

                            $('.tablesorter').find('tbody').html( rows );

                           // $('.ui-grid-d  input[type=checkbox]').prop('checked', false).checkboxradio('refresh');

                            $.mobile.loading( 'hide');

                            return [ result.total_rows];
                        }else
                            $.mobile.loading( 'hide');
                    }
                })

                .children('tbody').on('editComplete', 'td', function(event, config) {
                    var $this = $(this),
                        newContent = $this.text(),
                        cellIndex = this.cellIndex, // there shouldn't be any colspans in the tbody
                        rowIndex = $this.closest('tr').attr('id'); // data-row-index stored in row id
                        //alert('new value:'+newContent);
                    $.ajax({
                        type: "POST",
                        url: "updateFromTablesorter.php?id="+rowIndex+'&field=rp&value='+newContent,
                        data: null,
                        cache: false,
                        dataType: "text"

                    });
                        // alert(' event:'+  event +  'id:'+rowIndex+'  new value:'+newContent);

                    // Do whatever you want here to indicate
                    // that the content was updated
                })

        });
    </script>
</head>
<body>
<div id="dvLoading"></div>
<!-- Home -->
<div data-role="page" id="consulta">
    <?  include "header.php"; ?>




    <?if ($_SESSION['usuario']=='administrador' || $_SESSION['usuario']=='veterinario')  {
        ?>



        <form id="formConsulta4" name="myForm" action="mostrar_tabla-2.php" method="post" enctype="multipart/form-data">


            <div class="ui-grid-d ui-responsive">


                <div class="ui-block-a">
                    <div class="pager" style="padding-left: 20px; padding-top: 20px;">
                        <span class="pagedisplay"></span>
                    </div>
                </div>
                <div id="image1" class="ui-block-b">
                    <div class="ui-field-contain ui-body ui-br" data-role="fieldcontain" data-theme="b" >
                        <fieldset class="fullwidth" data-role="controlgroup"  data-type="horizontal" data-mini="true" >
                              <legend data-mini="true" for="checkboxCheckAll" style="padding-left:20% ">CheckAll</legend>
                            <div style="width:200px !important;padding-left:0%; padding-top: 10px;">
                                <input data-mini="true" type="checkbox" name="checkboxCheckAll" id="checkboxCheckAll" />
                            </div>
                        </fieldset>

                    </div>
                    <!--div  class="botones_check"><button type="button" onclick="$('.tablesorter input[type=checkbox]').prop('checked', true).checkboxradio('refresh');" data-theme="b" data-mini="true" data-icon="check">check all</button></div-->

                </div>
                <div class="ui-block-c">
                    <div class="ui-field-contain ui-body ui-br" data-role="fieldcontain">
                        <fieldset class="fullwidth" data-role="controlgroup"  data-type="horizontal" data-mini="true" >
                            <legend data-mini="true" for="Edit" style="padding-left: 80%;">Edit</legend>
                            <div style="width:200px !important;padding-left:0%; padding-top: 10px;">
                                <input data-mini="true" type="checkbox" name="Edit" id="EditableClick" class="customCheck" />
                            </div>
                        </fieldset>
                    </div>


                    <!--div class="botones_check"><button type="button"  onclick="$('.tablesorter input[type=checkbox]').prop('checked',false).checkboxradio('refresh'); " data-theme="b" data-mini="true" data-icon="delete">uncheck all</button></div-->
                    <!--div id="EditableClick" class="botones_check"><button type="button"  data-theme="b" data-mini="true" data-icon="check">Edit</button></div-->
                </div>
                <div class="ui-block-d">
                    <div id="masivoClick" class="botones_check"><button data-theme="b" data-mini="true" type="submit" data-icon="arrow-r">
                            <? echo $lang_cambios_masivos ?></button>
                    </div>
                </div>
                <div class="ui-block-e">
                    <div><button id="pdfClick" type="submit"  data-theme="b" data-mini="true">PDF</button></div>
                </div>
            </div>




            <div data-role="content">
            <table class="tablesorter" style="width: 100%; float: left;">
                <thead>
                <tr>
                    <th class="input.disabled"></th>
                    <th><? echo $lang_nombre ?></th>
                    <th><? echo $lang_padre; ?></th>
                    <th><? echo $lang_madre; ?></th>
                    <th id="rpColumn">RP</th>
                    <th><? echo $lang_sexo; ?></th>
                    <th><? echo $lang_pelaje; ?></th>
                    <th><? echo $lang_camada; ?></th>
                    <th><? echo $lang_ubicacion; ?></th>
                    <th><? echo $lang_grupo; ?></th>
                    <th><? echo $lang_estado; ?></th>
                    <th class="input.disabled"></th>
                    <th class="input.disabled"></th>
                    <th class="input.disabled"></th>
                    <th class="input.disabled"></th>
                    <th class="input.disabled"></th>
                    <th class="input.disabled"></th>

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
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>

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
						<img src="https://mottie.github.com/tablesorter/addons/pager/icons/prev.png" /> Prev&nbsp;
					</span>
					<span class="pagecount"></span>
					&nbsp;<span class="next">Next
						<img src="https://mottie.github.com/tablesorter/addons/pager/icons/next.png" />
					</span>
				</span>
                        </div>
                    </td>
                </tr>

                </tfoot>
                <tbody>
                </tbody>
            </table>
			</div>
        </form>
        <?
    } else {
        echo $lang_error_mensaje1;
    }	?>
</div>
</div>

<div  class="modalForm2" id="myModal">
    <div class="ui-grid-a ui-responsive">
        <div class="ui-block-a" style="width: 90%">
        </div>
        <div class="ui-block-b" style="width: 10%">
            <button   id="btnOK" style="border-radius: 5px; background: blue; color: white;" ><? echo $lang_cerrar; ?></button>
        </div>
    </div>
    <iframe  style="width=400px; height=200px;" name="iiFrame" class="modal_frame2" "></iframe>
</div>


</body>
</html>

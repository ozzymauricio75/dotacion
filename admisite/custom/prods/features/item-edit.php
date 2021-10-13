<?php require_once '../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../cxconfig/config.inc.php'; ?>
<?php require_once '../cxconfig/global-settings.php'; ?>
<?php require_once '../appweb/inc/sessionvars.php'; ?>
<?php require_once '../appweb/lib/gump.class.php'; ?>
<?php require_once '../appweb/inc/site-tools.php'; ?>
<?php require_once '../appweb/inc/query-stores.php'; ?>
<?php require_once '../i18n-textsite.php'; ?>
<?php 

//***********
//DEFINE CANCEL - TRASH EVENT
//***********
$statusCancel = "";
if(isset($_GET['trash']) && $_GET['trash'] == "ok"){ 
    
    if(isset($_GET['coditemget'])){
        
        $itemVarGET = (int)$_GET['coditemget'];
        $itemVarGET = $db->escape($itemVarGET);

       /* //ELIMINAR ESPECIFICACIONES COLOR    
        $fieldColorTBL = "id_producto";  
        $tblColorTBL = "especifica_product_tipo_color";      
        $trashColorItem = deleteFieldDB($itemVarGET, $fieldColorTBL, $tblColorTBL);

        //ELIMINAR ESPECIFICACIONES TALLAS    
        $fieldTallaTBL = "id_producto";  
        $tblTallaTBL = "especifica_grupo_talla";      
        $trashTallaItem = deleteFieldDB($itemVarGET, $fieldTallaTBL, $tblTallaTBL);

        //ELIMINAR ESPECIFICACIONES MATERIALES    
        $fieldMaterTBL = "id_producto";  
        $tblMaterTBL = "especifica_prod_material";     
        $trashMaterItem = deleteFieldDB($itemVarGET, $fieldMaterTBL, $tblMaterTBL);*/

        //ELIMINAR ITEM
        $fieldItemTBL = "id_account_empre";  
        $tblItemTBL = "account_empresa";
        $trashItem = deleteFieldDB($itemVarGET, $fieldItemTBL, $tblItemTBL);
    }
    
    $statusCancel = 1;
                
}


//***********
//ESPECIFICACIONES ITEM REFERENCIA
//***********
$itemVarGET = "";
if(isset($_GET['coditemget'])){

    $itemVarGET = (int)$_GET['coditemget'];
    $itemVarGET = $db->escape($itemVarGET);
            
}

//***********
//INFO ITEM
//***********
$detallesItem = array();
$detallesItem = queryStoresEdit($itemVarGET);

if(is_array($detallesItem)){
    foreach($detallesItem as $diKey){
                             
        $idItem = $diKey['id_account_empre'];
        $statusItem = $diKey['id_estado'];
        $refItem = $diKey['ref_account_empre'];        
        $nameItem = $diKey['nombre_account_empre'];
        $nitItem = $diKey['nit_empresa'];
        $fotoItem = $diKey['logo_account_empre'];
        $emailItem = $diKey['mail_account_empre'];
        $tel1Item = $diKey['tel_account_empre1'];
        $tel2Item = $diKey['tel_account_empre2'];
        $dirItem  = $diKey['dir_account_empre'];
        $cityItem  = $diKey['ciudad_account_empre'];
        $commentItem  = $diKey['comentarios_empresa'];    
        
        $dateRegisItem  = $diKey['fecha_alta_empresa'];
        
        $userItem  = $diKey['pseudo_user_empresa'];
        $passItem  = $diKey['pass_human'];
        
        $nameRepreItem  = $diKey['nome_representante'];
        $cargoRepreItem  = $diKey['cargo_repre_empresa'];
        
        
    }
    //PATH FOTO DEFAULT
    $pathFileDefault = $pathmm."img/nopicture.png";
    //PORTADA
    $pathPortada = "../../appweb/files-display/stores/".$fotoItem;

    if (file_exists($pathPortada)) {
    $portadaFile = $pathPortada;
        } else {
    $portadaFile = $pathFileDefault;
    }    
    
}

//echo "<pre>";
//print_r($dataTL);

//***********
//SITE MAP
//***********

$rootLevel = "empresas";
$sectionLevel = "item";
$subSectionLevel = "edit";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo METATITLE ?></title>    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="author" content="massin">
    <?php echo _CSSFILESLAYOUT_ ?>        
    <?php echo _FAVICON_TOUCH_ ?>    
    
    <link rel="stylesheet" href="../appweb/plugins/fileimput/fileimput.css">
    <style>
        .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
            margin: 0 auto;            
            padding: 0;
            border: none;
            box-shadow: none;
                       
        }
        .kv-avatar .file-input {
            display: table;
            max-width: 160px;            
            margin: 0 auto;
            border: 1px dashed #c4c4c4;
            text-align: center;
            padding-bottom: 7px;
        }
        .kv-avatar .file-input .file-preview,
        .kv-avatar .file-input .file-drop-zone{
            border: 0px solid transparent;
            
        }
    </style>
    
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../appweb/plugins/iCheck/all.css">            
</head>
    
<?php echo LAYOUTOPTION ?><!---//print body tag--->    

    
<div class="wrapper">            
    <?php
    /*
    /
    ////HEADER
    /
    */
    ?>
    <?php include '../appweb/tmplt/header.php';  ?>           
    <?php
    /*
    /
    ////SIDEBAR
    /
    */
    ?>
    <?php include '../appweb/tmplt/side-mm.php';  ?>
    <?php
    /*
    /
    ////WRAP CONTENT
    /
    */
    ?>        
    <div class="content-wrapper">
        <?php
        /*
        /*****************************//*****************************
        /HEADER CONTENT
        /*****************************//*****************************
        */
        ?>
        <section class="content-header bg-content-header">
                                    
            <h1>
            <small>Empresas </small> / Detalles
            </h1>
            <a href="<?php echo $pathmm.$admiDir."/company/"; ?>" class="ch-backbtn">
                <i class="fa fa-arrow-left"></i>
                Lista de empresas
            </a>                                    
        </section>

        <?php
        /*
        /*****************************//*****************************
        /MAIN WRAPPER CONTEN
        /*****************************//*****************************
        */
        ?>
        
        <?php if(!$statusCancel){ ?>
        <section class="content ">

            <div class="box75 padd-bottom-lg">
                                                               
                <div class="row wrapdivsection">
                    <?php
                    /*
                    /*
                    /*REPRESENTANTE
                    /*
                    */
                    ?>
                    <div class="col-xs-12 col-sm-4">
                        <h4>Representante</h4>
                        <p class="help-block">Detalles de la persona contacto de esta empresa</p>
                    </div>
                    
                    <div class="col-xs-12 col-sm-8 ">
                        <?php
                        /*
                        /*
                        /*NOMBRE REPRESENTANTE
                        /*
                        */
                        ?>
                        <div id="namerepreitemform" class="form-group">
                            <input type="text" name="nomerepre" class="form-control" value ="<?php echo $nameRepreItem; ?>" placeholder="Nombre del contacto" data-post="<?php echo $itemVarGET; ?>" data-field="namerepreitemform">
                        </div>
                        <div id="errnamerepreitemform"></div>
                        
                        <?php
                        /*
                        /*
                        /*CARGO REPRESENTANTE
                        /*
                        */
                        ?>
                        <div id="cargorepreitemform" class="form-group">
                            <input type="text" name="cargorepre" class="form-control" value ="<?php echo $cargoRepreItem; ?>" placeholder="Cargo u ocupación en la empresa" data-post="<?php echo $itemVarGET; ?>" data-field="cargorepreitemform">
                        </div>
                        <div id="errcargorepreitemform"></div>
                                                                                                                     
                    </div>  
                    <hr class="linesection"/>
                </div>
                                
                <?php
                /*
                /*
                /*INFORMACION COMERCIAL
                /*
                */
                ?>
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Información comercial</h4>
                        <p class="help-block">Escribe los datos comerciales para esta empresa</p>
                    </div>                                           
                    <div class="col-xs-12 col-sm-8">
                        <div id="refitemform" class="form-group">                        
                            <label>Referencia</label>
                            <input type="text" name="refcompany" value="<?php echo $refItem; ?>" class="form-control" placeholder="ID / COD / REF Empresa" data-post="<?php echo $itemVarGET; ?>" data-field="refitemform" />
                        </div> 
                        <div id="errrefitemform"></div>

                        <div id="nameitemform" class="form-group">                        
                            <label>Nombre</label>
                            <input type="text" name="namestore" value="<?php echo $nameItem; ?>" class="form-control" placeholder="Nombre comercial / Razon social" data-post="<?php echo $itemVarGET; ?>" data-field="nameitemform" />
                        </div> 
                        <div id="errnameitemform"></div>                    

                        <div id="nititemform" class="form-group">                        
                            <label>Nit</label>
                            <input type="text" name="nitstore" value="<?php echo $nitItem; ?>" class="form-control" placeholder="NIT" data-post="<?php echo $itemVarGET; ?>" data-field="nititemform" />
                        </div> 
                        <div id="errnititemform"></div>

                        <div id="tel1itemform" class="form-group">                        
                            <label>Teléfono</label>
                            <input type="text" name="landlinestore" value="<?php echo $tel1Item; ?>" class="form-control" placeholder="Número teléfono fijo" data-post="<?php echo $itemVarGET; ?>" data-field="tel1itemform" />
                        </div> 
                        <div id="errtel1itemform"></div>

                        <div id="tel2temform" class="form-group">                        
                            <label>Celular</label>
                            <input type="text" name="cellstore" value="<?php echo $tel2Item; ?>" class="form-control" placeholder="Número teléfono celular" data-post="<?php echo $itemVarGET; ?>" data-field="tel2itemform" />
                        </div> 
                        <div id="errtel2temform"></div>

                        <div id="emailitemform" class="form-group">                        
                            <label>Email</label>
                            <input type="text" name="emailstore" value="<?php echo $emailItem; ?>" class="form-control" placeholder="Cuenta Email" data-post="<?php echo $itemVarGET; ?>" data-field="emailitemform" />
                        </div> 
                        <div id="erremailitemform"></div>

                        <div class="form-group">                        
                            <label>Establecimiento</label>
                            <div id="diritemform">
                                <input type="text" name="addressstore" value="<?php echo $dirItem; ?>" class="form-control" placeholder="Dirección comercial" data-post="<?php echo $itemVarGET; ?>" data-field="diritemform" />
                            </div>
                            <div id="cityitemform">
                                <input type="text" name="citystore" value="<?php echo $cityItem; ?>" class="form-control" placeholder="Ciudad - Departamento" data-post="<?php echo $itemVarGET; ?>" data-field="cityitemform" />
                            </div>
                        </div> 
                        <div id="errdiritemform"></div>
                        <div id="errcityitemform"></div>

                        <div id="commentitemform" class="form-group">                                                
                            <textarea name="commentrepre" value="" class="form-control" placeholder="Comentarios..." style="resize:none; width:100%; height:80px;" data-post="<?php echo $itemVarGET; ?>" data-field="commentitemform" /><?php echo $commentItem; ?></textarea>                        
                        </div> 
                        <div id="errcommentitemform"></div>
                    </div>      
                    <hr class="linesection"/>
                </div>
                                
                                                                                                
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Información de cuenta</h4>
                        <p class="help-block"></p>
                    </div>
                    <div class="col-xs-12 col-sm-8  padd-bottom-xs">
                        <div id="useritemform" class="input-group">
                            <span class="input-group-addon" ><i class="fa fa-user"></i></span>
                            <input type="text" name="userstore" value="<?php echo $userItem; ?>" class="form-control" placeholder="Nombre de usuario" maxlength="12" data-post="<?php echo $itemVarGET; ?>" data-field="useritemform" />                        
                        </div>
                        <div id="erruseritemform"></div>

                        <div id="passitemform" class="input-group">
                            <span class="input-group-addon" ><i class="fa fa-lock"></i></span>
                            <input type="text" name="passstore" value="<?php echo $passItem; ?>" class="form-control" placeholder="Contraseña" maxlength="12" data-post="<?php echo $itemVarGET; ?>" data-field="passitemform"  />                        
                        </div>
                        <div id="errpassitemform"></div>
                    </div>
                    <hr class="linesection"/>
                </div>
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Status</h4>                        
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div id="statusitemform" class="form-group">
                            <select class="form-control " name="categoitem" data-post="<?php echo $itemVarGET; ?>" data-field="statusitemform">
                                    <option value="" selected>Selecciona una opcion</option> 
                        <?php 
                                
                        $statusLayaout = "";
                        
                        $db->where ('id_estado_contrato', '3', '!=');
                        $db->where ('id_estado_contrato', '4', '!=');
                        $db->where ('id_estado_contrato', '6', '!=');
                        $db->orderBy("nome_estado_contrato","Asc");			
                        $statusQuedy = $db->get('estado_contrato');                        
                        if(is_array($statusQuedy)) {
                            foreach($statusQuedy as $sqKey){
                                $idStatusTbl = $sqKey['id_estado_contrato'];
                                $nameStatusTbl = $sqKey['nome_estado_contrato'];                                
                                
                                $actiStatus = "";
                                if($idStatusTbl === $statusItem)
                                    $actiStatus = "selected";
                                
                                //$statusLayaout .= "<p>";
                                //$statusLayaout .= "<label>";
                                $statusLayaout .= "<option value='".$idStatusTbl."' class='flat-red statusprod' ".$actiStatus."> ";
                                //$statusLayaout .= "<span class=' margin-left-md'>".$nameStatusTbl."</span>";
                                $statusLayaout .= $nameStatusTbl;
                                $statusLayaout .= "</option>";
                                //$statusLayaout .= "</p>";                                                                
                            }                                                    
                        }   
                        echo $statusLayaout;
                        
                        ?>                                                               
                        </div>  
                        <div id="errstatusitemform"></div>
                    </div>
                    <hr class="linesection"/>
                </div>

                <div class="row wrapdivsection">                        
                    <input name="newprod" type="hidden" value="ok">
                    <input type="hidden" name="codeitemform" id="codeitemform" value="<?php echo $itemVarGET; ?>">
                    <input type="hidden" name="labelitemform" id="labelitemform" value="<?php echo $fotoItem; ?>">
                    
                </div>
                            
            </div>

        </section>    
                        
        <?php
        /*
        /*****************************//*****************************
        /FOOTER CONTENT - BOTTOM NAV
        /*****************************//*****************************
        */
        ?>
        <section class="main-footer navbar-fixed-bottom bottonnav">
            <div id="wrapadditem"></div>
            <div id="erradditem"></div>       
            <nav class="">
                <div id="left-barbtn" class="nav navbar-nav margin-left-md padd-verti-xs">
                    <a href="<?php echo $pathmm.$admiDir."/company/"; ?>" type="button" class="btn btn-default">
                        <i class='fa fa-th-list fa-lg'></i>
                        <span>lista de empresas</span>                        
                    </a>                                         
                </div>
                <div id="right-bartbtn" class="nav navbar-nav navbar-right margin-right-md padd-verti-xs">                    
                    <a href="<?php echo $pathmm.$admiDir."/company/item-edit.php?trash=ok&coditemget=".$itemVarGET; ?>" class="btn btn-default trashtobtn" name="" title="Eliminar item" data-msj="Perderás toda la información para esta empresa, incluyendo usuarios registrados y pedidos realizados. Deseas continuar?" data-remsj="">
                        <i class='fa fa-trash fa-lg'></i>
                        <span>Eliminar</span>                        
                    </a>                                                                                                       
                </div>
            </nav>
        </section>
        
        
        <?php }else{ ?>
            
        <section class="content ">                    
            <div class="box50  padd-verti-lg">
                <div class="alert alert-dismissible bg-gray">
                    <div class="media">
                        <div class=" media-left">
                            <i class="fa fa-bell-o fa-4x text-blue"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="no-padmarg">Hola!</h3>
                            <p style="font-size:1.232em; line-height:1;">
                                Este item fue eliminado correctamente, que deseas hacer ahora?
                            </p>                            
                        </div>

                    </div>                    
                </div>
                <div class="margin-verti-xs">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group text-center">
                            <a href="<?php echo $pathmm.$admiDir."/company/"; ?>" type="button" class="btn btn-default">
                                <i class='fa fa-th-list fa-lg'></i>
                                <span>lista de empresas</span>                        
                            </a> 
                        </div>
                    
                        <div class="btn-group text-center">                            
                            <a href="<?php echo $pathmm.$admiDir."/company/"; ?>" type="button" class="btn btn-info ">
                                <i class='fa fa-plus fa-lg'></i>
                                <span>Nuevo empresa</span>                     
                            </a>                                                               
                        </div>
                    </div>

                </div>
            </div>
        </section>
        
        
        <?php } ?>
        
    </div>
    <?php
    /*
    /
    ////FOOTER
    /
    */
    ?>
    <?php //include 'appweb/tmplt/footer.php';  ?>
    
            
    <?php
    /*
    /
    ////RIGHT BAR
    /
    */
    ?>
    <?php include '../appweb/tmplt/right-side.php';  ?>
    <?php echo "<input id='pathfile' type='hidden' value='".$pathmm."'/>"; ?>
    <?php echo "<input id='pathdir' type='hidden' value='".$admiDir."'/>"; ?>
    
</div>

<?php echo _JSFILESLAYOUT_ ?>
<script type="text/javascript" src="edit-item-functions.js"></script>    

<!-- InputMask -->
<script src="../appweb/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../appweb/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../appweb/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../appweb/plugins/iCheck/icheck.min.js"></script>
    
<script src="../appweb/plugins/fileimput/fileinput.js" type="text/javascript"></script>        
<script src="../appweb/plugins/fileimput/themes/fa/theme.js"></script>    
<script src="../appweb/plugins/fileimput/locales/es.js"></script> 
<script type="text/javascript">
$(document).ready(function() {   
    /*var editlabel = $("#editlabel").hide();
    var wraplabel = $("#wraplabel").show();    
    
    $("#editlabelbtn").click(function(){
        wraplabel.hide();
        editlabel.show();        
    });
    
    $("#canceleditlabelbtn").click(function(){
        wraplabel.show();
        editlabel.hide();        
    });*/
    
    $(".wefield").hide();
    
    $('button.editfieldbtn').each(function(){
        var field = $(this).attr("data-this");  
        //var parent = field.parent().attr("id");
        
        
        var wrapprint = $("#wp"+field).show(); 
        var wrapedit = $("#we"+field).hide();
        
        $(this).click(function(){
            wrapprint.hide();
            wrapedit.show();
        });
        
        
    });
    
    $('button.canceleditfieldbtn').each(function(){
        var field = $(this).attr("data-this");  
        //var parent = field.parent().attr("id");
        
        
        var wrapprint = $("#wp"+field).show(); 
        var wrapedit = $("#we"+field).hide();
        
        $(this).click(function(){
            wrapprint.show();
            wrapedit.hide();
        });
        
        
    });
    
                        
    $inputSingleImg = $(".fileimg");
    $inputSingleImg.fileinput({        
        theme: "fa",
        language: 'es',
        fileTypeSettings: 'image',        
        maxFileSize: 1700,
        maxImageWidth: 1600,
        maxImageHeight: 1600,            
        maxFilesNum: 1,        
        //overwriteInitial: true,   
        showUpload: false, // hide upload button
        showRemove: false, // hide remove button
        showClose: false,
        showCaption: false,
        showBrowse: false,
        browseOnZoneClick: true,
        removeLabel: '',        
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-2',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="../../img/camera-icon.png" style="width:80px; margin-bottom:4px;">',        
        allowedFileExtensions: ["jpg", "png", "png"],                                 
        uploadAsync: false,
        uploadUrl: "../appweb/inc/upload-imgfile.php",
        uploadExtraData: function() {
            return {
                codeitem: $("#codeitemform").val(),                
                nameportadaitem: $("#labelitemform").val()                
            };
        }
    }).on("filebatchselected", function(event, files) {        
        $inputSingleImg.fileinput("upload");
    });
    
    /*$(".fileimg").on('filebatchuploadsuccess', function(event, data, previewId, index) {
        var form = data.form, files = data.files, extra = data.extra,
            response = data.response, reader = data.reader;
        //console.log(response);
        $("#successupload").html(response);
    });*/
    
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    
    //CARGA SELECTS
    
    $(".generopz").change(function(){
        var id=$(this).val();
        var dataString = 'idgpz='+ id+'&fieldq=gpz';
        //alert(dataString);
        $.ajax({
            type: "POST",
            url: "../appweb/inc/query-selects.php",
            data: dataString,
            cache: false,
            success: function(html){
                $(".grupotallalist").html(html);                
            } 
        });
    });
    $(".tallaitemnew").hide();
    $("#savenewtalla").hide(); 
    
    $(".grupotallalist").change(function(){        
        var id=$(this).val();
        
        $('.tallaitemnew').each(function(k,v1) { 
            var tallaitem = $(v1).attr("datatallaitem");
            
            if(id === tallaitem){                
                $('.tallaitemnew').fadeOut(function(){
                    $("#wti"+tallaitem).show();    
                    $("#savenewtalla").show();    
                    
                });
                    
            }                       
         });
                
    });    
});                                    
</script>     
</body>
</html>

<?php require_once '../../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../../cxconfig/config.inc.php'; ?>
<?php require_once '../../cxconfig/global-settings.php'; ?>
<?php require_once '../../appweb/inc/sessionvars.php'; ?>
<?php require_once '../../appweb/lib/gump.class.php'; ?>
<?php require_once '../../appweb/inc/site-tools.php'; ?>
<?php require_once '../../i18n-textsite.php'; ?>
<?php 

/*
 *==================================
 *QUERY INFO ACCOUNT
 *==================================
*/
//SELECT `id_manager`, `nome_manager`, `apellido_manager`, `usuario_manager`, `clave_manager`, `id_estado`, `name_company_account` FROM `manager_account` WHERE 1
//$idSSUser = "4";
function queryManager() {
    global $db;
    global $idSSUser;
    
    $dataQuery = array();
    
    $db->where("id_manager",$idSSUser);	     
    $queryTbl = $db->get("manager_account", 1, 'id_manager, nome_manager, apellido_manager, usuario_manager, name_company_account, img_manager_account, id_estado');
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
         $dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
            
}

$datasUser = array();
$datasUser = queryManager();
//print_r($datasUser);
if(is_array($datasUser)){
    foreach($datasUser as $userKey){        
        $nameUser = $userKey['nome_manager'];
        $lastnameUser = $userKey['apellido_manager'];
        $companyUser = $userKey['name_company_account'];
        $pseudoUser = $userKey['usuario_manager'];
        $fileUser = $userKey['img_manager_account'];                
        $statusUser = $userKey['id_estado'];  
    }
    
    //PATH FOTO DEFAULT
    $pathFileDefault = $pathmm."img/nopicture.png";
    //PORTADA
    $pathPortada = "../../../files-display/manager/".$fileUser;

    if (file_exists($pathPortada)) {
    $portadaFile = $pathPortada;
        } else {
    $portadaFile = $pathFileDefault;
    }
}

//***********
//SITE MAP
//***********

$rootLevel = "especificaciones";
$sectionLevel = "account";
$subSectionLevel = "";
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
    <link rel="stylesheet" href="../../appweb/plugins/fileimput/fileimput.css">
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
    <link rel="stylesheet" href="../../appweb/plugins/iCheck/all.css">  
                    
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
    <?php include '../../appweb/tmplt/header.php';  ?>           
    <?php
    /*
    /
    ////SIDEBAR
    /
    */
    ?>
    <?php include '../../appweb/tmplt/side-mm.php';  ?>
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
            <small>Cuenta administrador</small> / Perfil
            </h1>                        
        </section>

        <?php
        /*
        /*****************************//*****************************
        /MAIN WRAPPER CONTEN
        /*****************************//*****************************
        */
        ?>
                
        <section class="content ">

            <div class="box75 padd-bottom-lg">
                                                               
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">                        
                        
                        <div class="form-group " id="wplabelfield">
                            <button type="button" class="btn btn-default pull-right btn-sm editfieldbtn" data-this="labelfield"> 
                                <i class="fa fa-pencil"></i>
                            </button>                            
                            <img src="<?php echo $portadaFile; ?>" class="img-thumbnail img-redounded center-block" style="height:150px;">
                        </div>
                        <div class="form-group wefield" id="welabelfield" >
                            <button type="button" class="btn btn-default pull-right btn-sm canceleditfieldbtn" data-this="labelfield"> 
                                <i class="fa fa-times"></i> Cerrar
                            </button>
                            <div class="kv-avatar " >
                                <input id="valida-upload" name="fotoprod" type="file" class="fileimg" ><!--class=file-loading -->
                            </div>
                            <div id="kv-avatar-errors-2" class="center-block" style="width:90%; margin:5px auto; display:none"></div>
                            <div id="successupload" class="center-block" style="width:90%; margin:5px auto;"></div>
                        </div>
                        
                    </div>
                    <div class="col-xs-12 col-sm-8 ">
                        <div class="form-group">
                            <input type="text" name="companyuser" class="form-control" value ="<?php echo $companyUser; ?>" placeholder="Nombre de la empresa">
                        </div>                                     
                    </div>  
                    <hr class="linesection"/>
                </div>
                
                <div class="row wrapdivsection"><!---representante--->   
                    <div class="col-xs-12 col-sm-4">
                        <h4>Información personal</h4>
                        <p class="help-block">Administra tu información básica de usuario</p>
                    </div>
                    <div class="col-xs-12 col-sm-8">                                            
                        <div class="form-group">                        
                            <label>Nombre</label>
                            <input type="text" name="nameuser" value ="<?php echo $nameUser; ?>" class="form-control" placeholder="Tu Nombre"  />
                        </div> 

                        <div class="form-group">                        
                            <label>Apellidos</label>
                            <input type="text" name="lastnameuser" value ="<?php echo $lastnameUser; ?>" class="form-control" placeholder="Tus Apellidos" />
                        </div> 

                    </div>  
                    <hr class="linesection"/>
                </div><!---representante---> 
                
                
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>LogIn</h4>
                        <p class="help-block">Define la información para validar el acceso a la plataforma de administración</p>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div class="box100 padd-bottom-xs">
                            <div class="form-group " id="wpaliasuser">
                                <button id="editaliasuser" type="button" class="btn btn-default pull-right btn-sm editfieldbtn" data-this="aliasuser"> 
                                    <i class="fa fa-pencil margin-right-xs"></i>
                                    Editar Alias
                                </button>                            
                                <strong class="fa-lg ">
                                    <span class="img-circle img-thumbnail margin-right-xs">
                                        <i class="fa fa-user fa-lg  padd-verti-xs padd-hori-xs"></i>
                                    </span>
                                    <?php echo $pseudoUser; ?>
                                </strong>
                            </div>
                            <div class="form-group wefield" id="wealiasuser" >
                                <button type="button" class="btn btn-default pull-right btn-sm canceleditfieldbtn" data-this="aliasuser"> 
                                    <i class="fa fa-times"></i> Cerrar
                                </button>
                                <div class="input-group">
                                    <span class="input-group-addon" ><i class="fa fa-user"></i></span>
                                    <input type="text" name="pseudouser" value="<?php echo $pseudoUser; ?>" class="form-control" placeholder="Nombre de usuario" maxlength="12" >                                    
                                </div>
                            </div>
                        </div>                      
                        <div class="form-group padd-top-xs">
                            <div class="row">
                                <div class=" col-xs-12 col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon" ><i class="fa fa-lock"></i></span>
                                        <input type="text" name="passuser" class="form-control" placeholder="Contraseña nueva" maxlength="12">                        
                                    </div>
                                </div>
                                <div class=" col-xs-12 col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon" ><i class="fa fa-lock"></i></span>
                                        <input type="text" name="replypassuser" class="form-control" placeholder="Confirmar contraseña" maxlength="12" data-pass='editpass'>                        
                                    </div>
                                </div>
                            </div>                                                                                
                        </div>
                    </div>
                    <hr class="linesection"/>
                </div>
                
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Status</h4>
                        <p class="help-block">Indica el estado de tu cuenta de usuario </p>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div id="statusitemform" class="form-group">
                            
                        <?php 
                        $statusLayaout = "";
                            
                        $db->where ('id_estado_contrato', $statusUser);
                        $statusQuedy = $db->get('estado_contrato');                        
                        if(is_array($statusQuedy)) {
                            foreach($statusQuedy as $sqKey){
                                $idStatusTbl = $sqKey['id_estado_contrato'];
                                $nameStatusTbl = $sqKey['nome_estado_contrato'];                                
                                
                                $actiStatus = "";
                                if($idStatusTbl === $statusUser)
                                    $actiStatus = "checked";
                                
                                $statusLayaout .= "<p>";
                                $statusLayaout .= "<label>";
                                $statusLayaout .= "<input type='radio' name='' value='".$idStatusTbl."' class='flat-red statusprod' ".$actiStatus." > ";
                                //$statusLayaout .= "<span class=' margin-left-md'>".$nameStatusTbl."</span>";
                                $statusLayaout .= "&nbsp;&nbsp;".$nameStatusTbl;
                                $statusLayaout .= "</label>";
                                $statusLayaout .= "</p>";                                                                
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
                    <input type="hidden" name="codeitemform" id="codeitemform" value="<?php echo $idSSUser; ?>">  
                    <input type="hidden" name="labelitemform" id="labelitemform" value="<?php echo $fileUser; ?>">  
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
                
                <div id="right-bartbtn" class="nav navbar-nav navbar-right margin-right-md padd-verti-xs">
                    
                    <button type="button" class="btn btn-info margin-hori-xs " id="edititembtn">
                        <i class='fa fa-save fa-lg'></i>
                        <span>Guardar</span>                     
                    </button>                                                               
                </div>
            </nav>
        </section>
                                
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
    <?php include '../../appweb/tmplt/right-side.php';  ?>
    <?php echo "<input id='pathfile' type='hidden' value='".$pathmm."'/>"; ?>
    <?php echo "<input id='pathdir' type='hidden' value='".$admiDir."'/>"; ?>
    
</div>

<?php echo _JSFILESLAYOUT_ ?>
<script type="text/javascript" src="account-functions.js"></script>    

<!-- iCheck 1.0.1 -->
<script src="../../appweb/plugins/iCheck/icheck.min.js"></script>
    
<script src="../../appweb/plugins/fileimput/fileinput.js" type="text/javascript"></script>        
<script src="../../appweb/plugins/fileimput/themes/fa/theme.js"></script>    
<script src="../../appweb/plugins/fileimput/locales/es.js"></script> 
<script type="text/javascript">
$(document).ready(function() { 
    
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

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
        defaultPreviewContent: '<img src="../../../img/camera-icon.png" style="width:80px; margin-bottom:4px;">',        
        allowedFileExtensions: ["jpg", "jpeg", "png"],                                 
        uploadAsync: false,
        uploadUrl: "../../appweb/inc/upload-img-manager.php",
        uploadExtraData: function() {
            return {
                codeitem: $("#codeitemform").val(),                
                nameportadaitem: $("#labelitemform").val()
                
            };
        }
    }).on("filebatchselected", function(event, files) {        
        $inputSingleImg.fileinput("upload");
    });
                
});                                    
</script>     
</body>
</html>

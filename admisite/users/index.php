<?php require_once '../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../cxconfig/config.inc.php'; ?>
<?php require_once '../cxconfig/global-settings.php'; ?>
<?php require_once '../appweb/inc/sessionvars.php'; ?>
<?php require_once '../appweb/lib/gump.class.php'; ?>
<?php require_once '../appweb/inc/site-tools.php'; ?>
<?php require_once '../appweb/inc/query-users.php'; ?>
<?php require_once '../i18n-textsite.php'; ?>
<?php 

//***********
//DEFINE CANCEL - TRASH EVENT
//***********
$statusCancel = "";
if(isset($_GET['trash']) && $_GET['trash'] == "ok"){ 
    
    if(isset($_GET['coditemrefget'])){
        
        $itemVarGET = (int)$_GET['coditemrefget'];
        $itemVarGET = $db->escape($itemVarGET);
        
        //ELIMINAR ITEM
        $fieldItemTBL = "id_account_user";  
        $tblItemTBL = "account_user";
        $trashItem = deleteFieldDB($itemVarGET, $fieldItemTBL, $tblItemTBL);
    }
    
    $statusCancel = 1;
            
}

//ITEMS REFERENCIA
$dataQueryTbl = array();
$dataQueryTbl = queryUsers();//30
//echo "<pre>";
//print_r($dataQueryTbl);

//***********
//SITE MAP
//***********

$rootLevel = "usuarios";
$sectionLevel = "lista";
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
    <link rel="stylesheet" href="../appweb/plugins/datatables/dataTables.bootstrap.css">
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
            <div class="nav navbar-nav navbar-right margin-right-xs">                
                <a href="new.php"  type="button" class="btn btn-info">
                    <i class="fa fa-plus margin-right-xs"></i>
                    Nuevo usuario
                </a>                
            </div>                    
            <h1>
            Usuarios
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
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Usuarios publicados</h3>
                </div>                
                <div class="box-body ">
                    <table id="printdatatbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cedula</th>
                                <th>Contacto</th>
                                <th>Status</th>
                                <th style='width:80px;'>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(is_array($dataQueryTbl)){
                            foreach($dataQueryTbl as $dqKey){
                                //id_account_user, estado_cuenta, cedula_user, account_pseudo_user, pass_account_user, foto_user, mail_account_user, tel_account_user2, tel_account_user2, dir_account_user, ciudad_account_user, fecha_alta_account_user
                                                                
                                $idItem = $dqKey['id_account_user'];
                                $nameItem = $dqKey['nombre_account_user'];
                                $nitItem = $dqKey['cedula_user'];
                                $mailItem = $dqKey['mail_account_user'];
                                $telItem = $dqKey['tel_account_user'];
                                $tel2Item = $dqKey['tel_account_user2'];
                                $dirItem = $dqKey['dir_account_user'];
                                $ciudadItem = $dqKey['ciudad_account_user'];
                                $dataAltaItem = $dqKey['fecha_alta_account_user'];
                                $statusItem = $dqKey['estado_cuenta'];
                                
                                
                                /*//PATH FOTO DEFAULT
                                $pathFileDefault = $pathmm."img/nopicture.png";
                                //PORTADA
                                $pathPortada = "../../appweb/files-display/stores/".$labelItem;

                                if (file_exists($pathPortada)) {
                                    $portadaFile = $pathPortada;
                                } else {
                                    $portadaFile = $pathFileDefault;
                                }*/


                                //STAUTS PRODUCTO (ACTIVO = SUSPENDIDO)
                                switch($statusItem){
                                    case "1":
                                        $printStatusItem = "<span class='label label-success'>Activado</span>";
                                        break;
                                    case "2":
                                        $printStatusItem = "<span class='label label-warning'>Suspendido</span>";
                                        break;
                                    case "4":
                                        $printStatusItem = "<span class='label label-default'>Desactivado</span>";
                                    break;																		
                                    case "5":
                                        $printStatusItem = "<span class='label label-info'>Revisión</span>";
                                    break;
                                    case "6":
                                        $printStatusItem = "<span class='label label-danger'>Agotado</span>";
                                    break;																	
                                }

                                

                                //LAYOUT TABLE ITEM                                    
                                $layoutDataItem = "";
                                $layoutDataItem .= "<tr>";
                                $layoutDataItem .= "<td>".$nameItem."</td>";
                                $layoutDataItem .= "<td>".$nitItem."</td>";

                                $layoutDataItem .= "<td>";//contacto                                  
                                $layoutDataItem .= "<p><span class='margin-right-xs'>Tel:</span>";
                                $layoutDataItem .= "<strong style='display:inline-block;'>".$telItem."</strong>"; 
                                $layoutDataItem .= "</p>";
                                $layoutDataItem .= "<p><span class='margin-right-xs'>Email:</span>";
                                $layoutDataItem .= "<strong style='display:inline-block;'>".$mailItem."</strong>"; 
                                $layoutDataItem .= "</p>";
                                $layoutDataItem .= "<p><span class='margin-right-xs'>Dir:</span>";
                                $layoutDataItem .= "<strong style='display:inline-block;'>".$dirItem."</strong>"; 
                                $layoutDataItem .= "</p>";
                                $layoutDataItem .= "<p><span class='margin-right-xs'>Ciudad:</span>";
                                $layoutDataItem .= "<strong style='display:inline-block;'>".$ciudadItem."</strong>"; 
                                $layoutDataItem .= "</p>";
                                $layoutDataItem .= "</td>";//fin contacto
                                $layoutDataItem .= "<td>";//status
                                $layoutDataItem .= "<p>Estado: ".$printStatusItem."</p>";                                
                                $layoutDataItem .= "</td>";//fin stratus
                                
                                $layoutDataItem .= "<td>";//opciones

                                $layoutDataItem .= "<div class='btn-group'>";
                                $layoutDataItem .= "<a href='item-edit.php?coditemget=".$idItem."' type='button' class='btn btn-info'>Editar</a>";
                                $layoutDataItem .= "<button type='button' class='btn btn-info dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                                $layoutDataItem .= "<span class='caret'></span>";
                                $layoutDataItem .= "<span class='sr-only'>edititem</span>";
                                $layoutDataItem .= "</button>";
                                $layoutDataItem .= "<ul class='dropdown-menu pull-right'>";
                                //$layoutDataItem .= "<li><a href='#'>Detalles</a></li>";
                                //$layoutDataItem .= "<li><a href='newrefitem.php?coditemget=".$idItem."'>Referencias</a></li>";  

                                //$layoutDataItem .= "<li role='separator' class='divider'></li>";
                                $layoutDataItem .= "<li><a href='".$pathmm.$admiDir."/users/?trash=ok&coditemget=".$idItem."&coditemrefget=".$idItem."' class='trashtobtn' name='".$nameItem."' title='Eliminar item' data-msj='Perderás toda la información para esta empresa, incluyendo usuarios registrados y pedidos realizados. Deseas continuar?' data-remsj=''><i class='fa fa-trash margin-right-xs'></i>Eliminar</a></li>";
                                $layoutDataItem .= "</ul>";
                                $layoutDataItem .= "</div>";

                                $layoutDataItem .= "</td>";//fin opciones
                                $layoutDataItem .= "</td>";
                                $layoutDataItem .= "</tr>";

                                echo $layoutDataItem;
                                   
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->   
                
            </div>        
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
    <?php //include '../appweb/tmplt/right-side.php';  ?>
    <aside class="control-sidebar control-sidebar-light" style="max-height: calc(100% - 50px); overflow-y: auto; margin-bottom:2%;">        
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">          
            <li>
                <a href="!#" data-toggle="control-sidebar">
                    <i class="fa fa-times margin0right-xs"></i> Cerrar                    
                </a>
            </li>            
        </ul>
        
        <div class="box100 "  >
            <form id="newitem" method="POST" enctype="text/plain" autocomplete="off">                                                   
            <!--<div class="row wrapdivsection">
                <div class="col-xs-12">
                    <h4>Foto portada</h4>
                    <div class="form-group ">
                        <div class="kv-avatar " >
                            <input id="valida-upload" name="fotoprod" type="file" class="fileimg" >
                        </div>
                        <div id="kv-avatar-errors-2" class="center-block" style="width:90%; margin:5px auto; display:none"></div>
                        <div id="successupload" class="center-block" style="width:90%; margin:5px auto;"></div>
                    </div>                    
                </div>
            </div>-->
            
            <div class="row wrapdivsection"><!---representante--->   
                <div class="col-xs-12 ">
                    <h4>Representante</h4>
                    <div class="form-group">                        
                        <label>Nombre</label>
                        <input type="text" name="nomerepre" class="form-control" placeholder="Nombre del representante"  />
                    </div> 
                                        
                    <div class="form-group">                        
                        <label>Cargo</label>
                        <input type="text" name="cargorepre" class="form-control" placeholder="Cargo en la empresa" />
                    </div> 
                                      
                </div>  
                <hr class="linesection"/>
            </div><!---representante---> 
                
            <div class="row wrapdivsection"><!---Info comercial--->   
                <div class="col-xs-12 ">
                    <h4>Información comercial</h4>
                    <div class="form-group">                        
                        <label>Referencia</label>
                        <input type="text" name="refcompany" class="form-control" placeholder="ID / COD / REF Empresa" />
                    </div> 
                                        
                    <div class="form-group">                        
                        <label>Nombre</label>
                        <input type="text" name="namestore" class="form-control" placeholder="Nombre comercial / Razon social" />
                    </div> 
                                                          
                    <div class="form-group">                        
                        <label>Nit</label>
                        <input type="text" name="nitstore" class="form-control" placeholder="NIT" />
                    </div> 
                                        
                    <div class="form-group">                        
                        <label>Teléfono</label>
                        <input type="text" name="landlinestore" class="form-control" placeholder="Número teléfono fijo" />
                    </div> 
                                    
                    <div class="form-group">                        
                        <label>Celular</label>
                        <input type="text" name="cellstore" class="form-control" placeholder="Número teléfono celular" />
                    </div> 
                                        
                    <div class="form-group">                        
                        <label>Email</label>
                        <input type="text" name="emailstore" class="form-control" placeholder="Cuenta Email" />
                    </div> 
                                        
                    <div class="form-group">                        
                        <label>Establecimiento</label>
                        <input type="text" name="addressstore" value="" class="form-control" placeholder="Dirección comercial" />
                        <input type="text" name="citystore" value="" class="form-control" placeholder="Ciudad - Departamento" />
                    </div> 
                                        
                    <div class="form-group">                                                
                        <textarea name="commentrepre" value="" class="form-control" placeholder="Comentarios..." style="resize:none; width:100%; height:80px;" /></textarea>                        
                    </div>                     
                </div>  
                <hr class="linesection"/>
            </div><!---info comercial---> 
            
            <div class="row wrapdivsection"><!---Info cuenta--->   
                <div class="col-xs-12 ">
                    <h4>Información de cuenta</h4>                                                            
                    <div class="input-group">
                        <span class="input-group-addon" ><i class="fa fa-user"></i></span>
                        <input type="text" name="userstore" class="form-control" placeholder="Nombre de usuario" maxlength="12" >                        
                    </div>
                                        
                    <div class="input-group">
                        <span class="input-group-addon" ><i class="fa fa-lock"></i></span>
                        <input type="text" name="passstore" class="form-control" placeholder="Contraseña" maxlength="12">                        
                    </div>
                   
                </div>
            </div><!---Info cuenta--->  
            
            
            <div class="row wrapdivsection">                        
                <input name="newprod" type="hidden" value="ok">
                <input type="hidden" name="codeitemform" id="codeitemform" value="<?php echo $itemVarGET; ?>">                         
            </div>


            <?php
            /*
            /*****************************//*****************************
            /FOOTER CONTENT - BOTTOM NAV
            /*****************************//*****************************
            */
            ?>
            <section class="bottonnav bottomtools" style="position:fixed; top:auto; bottom:0px; z-index:999; width:100%;"><!---/main-footer navbar-fixed-bottom-->
                <div id="wrapadditem"></div>
                <div id="erradditem"></div>       
                <nav class="">
                    <div id="left-barbtn" class="nav navbar-nav margin-left-md padd-verti-xs" style="display:none;"></div>
                    <div id="right-bartbtn" class="nav navbar-nav navbar-left padd-verti-xs">                        
                        <button type="button" class="btn btn-info margin-hori-xs " id="additembtn">
                            <i class='fa fa-save fa-lg margin-right-xs'></i>
                            <span>Guardar</span>                     
                        </button>                                                               
                    </div>
                </nav>
            </section>

            </form>
        </div>
        
    </aside>    
    <div class="control-sidebar-bg"></div>
    
            
    
    <?php echo "<input id='pathfile' type='hidden' value='".$pathmm."'/>"; ?>
    <?php echo "<input id='pathdir' type='hidden' value='".$admiDir."'/>"; ?>
    
</div>

<?php echo _JSFILESLAYOUT_ ?>
<!-- InputMask -->
<script src="../appweb/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../appweb/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../appweb/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../appweb/plugins/iCheck/icheck.min.js"></script>
<!-- DataTables -->
<script src="../appweb/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../appweb/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script src="../appweb/plugins/fileimput/plugins/sortable.js" type="text/javascript"></script>        
<script src="../appweb/plugins/fileimput/fileinput.js" type="text/javascript"></script>        
<script src="../appweb/plugins/fileimput/themes/fa/theme.js"></script>    
<script src="../appweb/plugins/fileimput/locales/es.js"></script>      

<script type="text/javascript" src="crud-newitem.js"></script>  
    
<script type="text/javascript">
$(document).ready(function() {   
        
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    
       
});                                    
</script> 
<script>
  $(function () {
    
    $('#printdatatbl').DataTable({        
        "scrollX": false,
        "ordering": false,
        "autoWidth": true
    });
  });
</script>    
</body>
</html>

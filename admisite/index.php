<?php require_once 'appweb/lib/MysqliDb.php'; ?>
<?php require_once 'cxconfig/config.inc.php'; ?>
<?php require_once 'cxconfig/global-settings.php'; ?>
<?php require_once 'appweb/lib/gump.class.php'; ?>
<?php require_once 'appweb/inc/site-tools.php'; ?>
<?php require_once "appweb/lib/password.php"; ?>
<?php require_once 'login/login.inc.php'; ?>

<!DOCTYPE html>
<html class="bg-login" lang="<?php echo LANG ?>">
<head>
    <meta charset="utf-8">
    <title>QUEST - LogIn</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="author" content="massin">    
    
    <?php echo _CSSFILESLAYOUT_ ?> 

    <!--<link href="appweb/css/bootstrap.css" rel="stylesheet">       
    <link href="appweb/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="appweb/css/layout-styles.css" rel="stylesheet">-->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <![endif]-->

</head>
<body class="bgdark">
    
    <div class="container-fluid wraplogin" >
        <div class="box25 padd-verti-md text-center">
            <img src="appweb/img/logo-quest.png" class="img-responsive center-block"/>
            <!--<span class="cbp-ig-icon "><i class="fa fa-file-text-o"></i></span>-->
            <span class="cbp-ig-title">Sistema de administración</span>
        </div>
        
        <div class=" wrapform padd-hori-md padd-verti-md" >
            <?php 
            /*
                *
                *---------------------------
                *IMPRIME ERRORES VALIDACION
                *---------------------------
                *    
            */            
            if(isset($errValidaTmpl) && $errValidaTmpl != ""){ echo $errValidaTmpl; }            
            ?>
            <form action="<?php echo $pathFile; ?>/" method="post" id="to_loginform"> 
                <div class="form-group">                    
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon" id="userinput"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" name="username" placeholder="Usuario" aria-describedby="userinput">
                    </div>
                </div>
                <div class="form-group">                    
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon" id="passinput"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" name="passuser" aria-describedby="passinput" placeholder="Contrataseña">
                    </div>
                </div>                                
                <button type="submit" class="btn btnform btn-lg btn-block">Entrar</button>
                <input name="tologin" value="ok" type="hidden"/>
            </form>
            
        </div>
        
    </div>
    <?php echo _JSFILESLAYOUT_ ?>   
    <script type="text/javascript" src="appweb/plugins/form-validator/jquery.form-validator.min.js"></script>            
    <script type="text/javascript" src="appweb/js/to-loginform.js"></script>
    
    
</body>
</html> 
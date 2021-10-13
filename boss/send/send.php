<?php 
//LISTA PEDIDO
$pedido = array();
$pedidoII = array();
$pedido = queryOrderTmpOne($otNOW);//$otNOW
$pedidoII= queryOrderTmpOne($otNOW);

//LISTA PRODUCTOS
function printListOrder($idOrderTmp_){
    global $db;
    $prodList = array();
    
    $prodList = queryListProdOrder($idOrderTmp_);//
    $prodListTmpl = "";
        
    foreach($prodList as $iplotemKey){
                       
        /*$idOrderTmpItem = $iplotemKey['id_espci_prod_pedido'];
        $idProdItem = $iplotemKey['id_producto'];
        $SKUProdItem = $iplotemKey['cod_venta_prod_filing'];
        $nomeProdItem = $iplotemKey['nome_producto_filing'];
        //$costoProdItem = $iplotemKey['precio_producto'];
        //$labelProdItem = $iplotemKey['foto_producto_filing'];
        $descriRefProdItem = $iplotemKey['cod_venta_descri_filing'];*/
        
        
        
        
        $idOrderTmpItem = $iplotemKey['id_espci_kit_pedido'];
        $idProdItem = $iplotemKey['id_subcatego_producto'];
        //$SKUProdItem = $iplotemKey['cod_venta_prod_filing'];
        $nomeProdItem = $iplotemKey['nome_subcatego_producto'];
        //$costoProdItem = $iplotemKey['precio_producto'];
        $labelProdItem = $iplotemKey['img_subcate_prod'];
        $descriRefProdItem = $iplotemKey['descri_subcatego_prod'];
        
        $idcateTmpItem = $iplotemKey['id_catego_product'];
                
        $idColorItem = $iplotemKey['id_color'];
        $tipoPrendaItem = $iplotemKey['tipo_prenda'];
        $idTallaItem = $iplotemKey['id_talla'];
        
        $cantProdItem = $iplotemKey['cant_pedido'];
        
                        
        //COLOR   
     
        $db->where ("id_color", $idColorItem);    
        $colorQ = $db->getOne ("tipo_color", "id_color, nome_color, color_hexa");
        $nameColor = $colorQ['nome_color'];
        $hexaColor = $colorQ['color_hexa'];
        
        //TALLA   

        if($tipoPrendaItem == "tl"){
            $db->where ("id_talla_letras", $idTallaItem);    
            $tallaQ = $db->getOne ("talla_letras", "nome_talla_letras");
            $nameTalla = $tallaQ['nome_talla_letras'];            
        }elseif($tipoPrendaItem == "tn"){
            $db->where ("id_talla_numer", $idTallaItem);    
            $tallaQ = $db->getOne ("talla_numerico", "talla_numer");
            $nameTalla = $tallaQ['talla_numer'];
        }
        
        //CATEGORIA - KIT
        $db->where ("id_catego_product", $idcateTmpItem);    
        $kitQ = $db->getOne ("categorias_productos", "id_catego_product, nome_catego_product, descri_catego_prod, tipo_kit_4user, tags_depatament_produsts");
        $nameKit = $kitQ['nome_catego_product'];  
        $descriKit = $kitQ['descri_catego_prod'];  
        $tipoKit = $kitQ['tipo_kit_4user']; 
        $tagCateTmpItem = $kitQ['tags_depatament_produsts']; 
        $tagKitFormat = "<span style='text-transform: uppercase;'>".$tagCateTmpItem."</span>"; 
        $tipoKitFormat = "<span style='text-transform: capitalize;'>".$tipoKit."</span>";
        

        
        $prodListTmpl .="<tr style='background-color:#e0e0e0;'>";
        $prodListTmpl .="<td>".$cantProdItem."</td>";
        $prodListTmpl .="<td>".$tagKitFormat."&nbsp;".$tipoKitFormat."</td>";
        $prodListTmpl .="<td>".$nameKit."&nbsp;".$nomeProdItem."&nbsp;Talla: ".$nameTalla."&nbsp;Color: ".$nameColor."</td>";
        $prodListTmpl .="</tr>";
        $prodListTmpl .="<tr><td colspan='3' style='margin-bottom: 6px;'></td></tr>";
           
    }

    return $prodListTmpl;                            
        
}// fin function printOrderListTmp()

//INFO EMPRESA
function infoCompany($varCompany_){
    global $db;
    $datasReturn = array();
    //SELECT `id_account_empre`, `id_estado`, `ref_account_empre`, `nombre_account_empre`, `nit_empresa`, `logo_account_empre`, `mail_account_empre`, `pseudo_user_empresa`, `pass_account_empre`, `tel_account_empre1`, `tel_account_empre2`, `url_empre`, `dir_account_empre`, `ciudad_account_empre`, `pais_account_empre`, `nome_representante`, `cargo_repre_empresa`, `comentarios_empresa`, `recibe_order`, `cargo_recibe_order`, `fecha_alta_empresa` FROM `account_empresa` WHERE 1    
    $db->where ("id_account_empre", $varCompany_);    								
    $sqlVar = $db->get('account_empresa', null, 'id_account_empre, nombre_account_empre, nit_empresa, mail_account_empre, tel_account_empre1, dir_account_empre, ciudad_account_empre, nome_representante, cargo_repre_empresa, recibe_order, cargo_recibe_order');    
    $resuSql = count($sqlVar);
    if ($resuSql > 0){
        foreach ($sqlVar as $sqlkey) { 
            $datasReturn[] = $sqlkey;
        }    
        return $datasReturn;
    } 
}

//INFO EMPLEADO
/*function infoUser($varUser_){
    global $db;
    $datasReturn = array();
    //SELECT `id_account_user`, `id_account_empre`, `account_pseudo_user`, `cedula_user`, `nombre_account_user`, `mail_account_user`, `pass_account_user`, `tel_account_user`, `tel_account_user2`, `dir_account_user`, `ciudad_account_user`, `estado_account_user`, `pais_account_user`, `fecha_alta_account_user`, `foto_user`, `coleccion_user`, `tipo_kit_user`, `estado_cuenta` FROM `account_user` WHERE 1
    $db->where ("id_account_user", $varUser_);    								
    $sqlVar = $db->get('account_user', null, 'id_account_user, nombre_account_user, cedula_user, mail_account_user, tel_account_user, dir_account_user, ciudad_account_user');    
    $resuSql = count($sqlVar);
    if ($resuSql > 0){
        foreach ($sqlVar as $sqlkey) { 
            $datasReturn[] = $sqlkey;
        }    
        return $datasReturn;
    } 
}*/


//INFO EMPRESA Y EMPLEADO
foreach($pedidoII as $pIIKEy){
    $varEmpresa = $pIIKEy['id_account_empre'];
    $varBene = $pIIKEy['id_account_user'];
    $codePedidoSend = $pIIKEy['cod_orden_compra'];
    $fechaPedidoSend = $pIIKEy['fecha_solicitud'];
    
    //PRINT INFO EMPRESA 
    $getDataCompany = array();
    $getDataCompany = infoCompany($varEmpresa);
    foreach($getDataCompany as $gdcKey){
        $nameCompanySend = $gdcKey['nombre_account_empre'];
        $nitCompanySend = $gdcKey['nit_empresa'];
        $mailCompanySend = $gdcKey['mail_account_empre'];
        $telCompanySend = $gdcKey['tel_account_empre1'];
        $dirCompanySend = $gdcKey['dir_account_empre'];
        $cityCompanySend = $gdcKey['ciudad_account_empre'];
    }
    
    //PRINT INFO USER
    /*$getDataUser = array();
    $getDataUser = infoUser($varBene);
    foreach($getDataUser as $gduKey){
        $nameBeneSend = $gduKey['nombre_account_user'];
        $deculaBeneSend = $gduKey['cedula_user'];
        $mailBeneSend = $gduKey['mail_account_user'];
        $telBeneSend = $gduKey['tel_account_user'];
        $dirBeneSend = $gduKey['dir_account_user'];
        $cityBeneSend = $gduKey['ciudad_account_user'];
        
    }*/
}

//INFO CIUDAD ENVIO 
/*function citySend(){
    global $db;
    global $cityGETSSUser;
    //SELECT `id_ciudad_user`, `name_ciudad_user`, `name_estado_user`, `id_estado_rel` FROM `ciudades_user` WHERE 1
    $db->where ("id_ciudad_user", $cityGETSSUser);    								
    $sqlVar = $db->get('ciudades_user', 1, 'name_ciudad_user, name_estado_user');    
    $resuSql = count($sqlVar);
    if ($resuSql > 0){
        foreach ($sqlVar as $sqlkey) { 
            $datasReturn[] = $sqlkey;
        }    
        return $datasReturn;
    }
}

//CIUDAD DE ENVIO DOTACION
$cityUserSendArr = array();
$cityUserSendArr = citySend();

foreach($cityUserSendArr as $cusKey){
    $nameCity = $cusKey['name_ciudad_user'];
    $estateCity = $cusKey['name_estado_user'];    
}*/

//LAYOUT EMAIL SEND
$tmplatesend='
    <table cellpadding="5" cellspacing="0" width="700" align="center" border="0">
    <tbody>
    
    <!--
    /////////////////////////////////////////////////////
    INFO PEDIDO
    --->        
    <tr>
    <td> 
    <table cellpadding="1" cellspacing="0" width="700" border="0">
    <tbody>
            
    <tr>
    <td style="text-align:center;" colspan="2" rowspan="3">
    <img src="'.$pathmm.'appweb/img/logo_final3.png" style="height:55px; margin:0 auto;" />        
    </td>
    </tr>
    <tr><td colspam="2" ><span>QUEST S.A.S</span> </td> </tr>
    <tr >
    <td>
    <span style="display:block;  text-align:right; font-size:12px; margin-bottom:3px; margin-right:4px;">NIT:</span>    
    <span style="display:block;  text-align:right; font-size:12px; margin-bottom:3px; margin-right:4px;">Tel:</span>
    <span style="display:block;  text-align:right; font-size:12px; margin-bottom:3px; margin-right:4px;">Dir:</span>
    <span style="display:block;  text-align:right; font-size:12px; margin-bottom:3px; margin-right:4px;">&nbsp;</span>
    <span style="display:block;  text-align:right; font-size:12px; margin-bottom:3px; margin-right:4px;">Email:</span>
    </td>
    
    <td>
    <span style="display:block;  text-align:left; font-size:12px; margin-bottom:3px;">805022296-8</span>    
    <span style="display:block;  text-align:left; font-size:12px; margin-bottom:3px;">(2) 489 5000</span>
    <span style="display:block;  text-align:left; font-size:12px; margin-bottom:3px;">Calle 24N No. 5AN-30 </span>
    <span style="display:block;  text-align:left; font-size:12px; margin-bottom:3px;"> Cali, Colombia</span>
    <span style="display:block;  text-align:left; font-size:12px; margin-bottom:3px;">licitaciones@quest.com.co</span>
    </td>  
    </tr> 
    
    
    
    <tr><td style="padding-top:24px;" colspan="4"></td> </tr>
    <tr>
    
    <tr>    
    <td style="padding:15px 0px; text-align:center; background-color:#e42727; color:#fff;" colspan="4">Pedido: <span style="font-size:20px; font-weight:bold;">'.$codePedidoSend.'<span></td>        
    </tr>
    <tr><td style="padding-top:24px;" colspan="4"></td> </tr>
    <tr>
    <td width="150px">Fecha de emición:</td>
    <td width="200px"><strong>'.$fechaPedidoSend.'</strong></td>
    <td width="150px" >Ciudad envio:</td>
    <td width="200px"><strong>'.$cityCompanySend.'</strong></td>
    </tr>
    <!----<tr>
    <td width="150px">Fecha:</td>
    <td width="500px"><strong>12/12/12</strong></td>
    <td width="150px">Código de pedido:</td>
    <td width="200px"><strong></strong></td>
    </tr>
    <tr>
    <td width="150px">Ciudad:</td>
    <td width="500px"><strong>cali</strong></td>
    <td width="150px">Codigo de pedido:</td>
    <td width="200px"><strong>dasdas312312</strong></td>
    </tr>--->
    <tr><td style="padding-bottom:24px;" colspan="4"></td></tr>
    <tr>
    <td style="padding:7px 0px; text-align:center; background-color:#111111; color:#fff;" colspan="2">Entidad compradora</td>    
    <td style="padding:7px 0px; text-align:center; background-color:#111111; color:#fff;" colspan="2">Beneficiario</td> 
    </tr>
    <tr><td style="padding-bottom:24px;" colspan="2"></td></tr>
    
    <tr><!--INICIA ITEM-->
    <td width="150px"><span>Razon social:</span></td>
    <td width="500px"><strong>'.$nameCompanySend.'</strong> </td>
    
    <td width="150px">Nombre:</td> 
    <td width="200px"><strong>'.$nameCompanySend.'</strong></td>    
    </tr>
    <tr>
    <td width="150px">N.I.T</td>
    <td width="500px"><strong>'.$nitCompanySend.'</strong></td>
    
    <td width="150px">Nit:</td>
    <td width="200px"><strong>'.$nitCompanySend.'</strong></td>
    </tr>
    
    <tr><!--INICIA ITEM-->
    <td width="150px"><span>Tel:</span></td>
    <td width="500px"><strong>'.$telCompanySend.'</strong> </td>
    
    <td width="150px">Tel:</td> 
    <td width="200px"><strong>'.$telCompanySend.'</strong></td>    
    </tr>
    <tr>
    <td width="150px">Email:</td>
    <td width="500px"><strong>'.$mailCompanySend.'</strong></td>
    
    <td width="150px">Email:</td>
    <td width="200px"><strong>'.$mailCompanySend.'</strong></td>
    </tr>
    
    <tr><!--INICIA ITEM-->
    <td width="150px"><span>Dirección:</span></td>
    <td width="500px"><strong>'.$dirCompanySend.'</strong> </td>
    
    <td width="150px">Dirección:</td> 
    <td width="200px"><strong>'.$dirCompanySend.'</strong></td>    
    </tr>
    
    <tr>
    <td width="150px">Ciudad:</td>
    <td width="500px"><strong>'.$cityCompanySend.'</strong></td>
    
    <td width="150px">Ciudad:</td>
    <td width="200px"><strong>'.$cityCompanySend.'</strong></td>
    </tr>
    <tr><td style="padding-bottom:24px;" colspan="2"></td></tr>
    </tbody>
    </table>
    </td>    
    </tr>	
    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
    
    <!--
    /////////////////////////////////////////////////////
    ITEMS PRODUCTOS
    --->
    
    <tr>
    <td>    
    <table cellpadding="4" cellspacing="0" width="700" align="center" border="0" >
    <thead>
    <tr style="text-align:left;">
    <th width="100px">Cant:</th>    
    <th width="100px">Kit</th>        
    <th width="500px">Descripción</th>        
    </tr>    
    </thead>';
    
$tmplatesend.='<tbody>';
//CONTENEODR DE PRODUCTOS
    foreach($pedido as $elemOrder){
        $idTEMPOrder = $elemOrder['id_subcatego_producto'];
        $tmplatesend .= printListOrder($idTEMPOrder);       
    }
    /*<tr style="background-color:#e0e0e0;">
    <td>76567567</td>
    <td>Calido Formal</td>
    <td>Camisa manga larga blanca Talla L</td>    
    </tr>
    <tr><td colspan="3" style=" margin-bottom: 6px;"></td></tr>
    <tr style="background-color: #e0e0e0; ">
    <td>7650000</td>
    <td>Calido Formal</td>
    <td>Pantalon Gris Talla 32</td>    
    </tr>
    <tr><td colspan="3" style=" margin-bottom: 6px;"></td></tr>
    <tr style="background-color: #e0e0e0;">
    <td>7650111100</td>
    <td>Zapatos</td>
    <td>Zapato calle talla 38</td>    
    </tr>*/
        
//fin CONTENEODR DE PRODUCTOS    
$tmplatesend.='</tbody>
    </table>
    </td>
    </tr>	
    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
    
    <!--
    /////////////////////////////////////////////////////
    FOOTER
    --->
    <tr><td style=" height:48px;"></td></tr>
    <tr>
    <td>
    <table cellpadding="2" cellspacing="0" width="700" align="center" border="0" >
    <tbody>
    <tr>
    <td width="400px;">
    <strong style="display:block; text-align:left; font-size:14px;">Terminos y Condiciones</strong>    
    <p style="display:block; text-align:left; font-size:12px;">Por favor lea cuidadosamente el contenido de los siguientes textos. Por el uso de este Sitio, acepta los Términos de Uso, Términos del Contrato y Políticas de Privacidad aquí contenidos.&nbsp;&nbsp;&nbsp;<a href="http://www.quest.com.co/terminos-condiciones" target="_blank">Ir a Terminos y Condiciones</a></p>
    </td>
    <td width="300px;"></td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr><td style=" height:18px;"></td></tr>
    <tr>
    <td height="2px;">
    <table cellpadding="0" cellspacing="2" width="700" align="center" border="0" >
    <tbody>
    <tr>
    <td width="600px;" style="height:2px; background-color:#111111;"></td>
    <td width="100px;" style="height:2px; background-color:#e42727;"></td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    
    <tr><td style=" height:28px;"></td></tr>
    <tr>
    <td>
    <table cellpadding="0" cellspacing="2" width="700" align="center" border="0" >
    <tbody>
    <tr>
    <td width="600px;">
    <h2>Agrademos tu confianza en Quest</h2>
    </td>
    <td width="100px;" >
    <img src="'.$pathmm.'appweb/img/logo_final4.png" style="height:105px; margin:0 auto;" />     
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr><td style=" height:28px;"></td></tr>
    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
    
    </tbody>
    </table>		
    ';

//echo $tmplatesend;

//ENVIAR CONFIRMACION PEDIDO AL USUARIO
function mailSendOrder($emailSSUser_, $tmplatesend_){
	//$msjMail = html_entity_decode($msjValue_, ENT_COMPAT, 'utf-8');
	$destinatario = $emailSSUser_; 
	$asunto = "Confirmación orden de pedido - No responda este mensaje"; 
    
    $cuerpo ='<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <style>
    #wrapemail{ font-family:Tahoma; font-size:12px; color:#343434; font-weight:normal; text-align:justify; line-height:10px;}
    </style>
    </head>
    <body id="wrapemail">';
	$cuerpo .= $tmplatesend_;
    $cuerpo .= '</body>
    </html>\r\n';
    
	//para el env�o en formato HTML 
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=utf-8\r\n"; 

	//direcci�n del remitente 
	$headers .= "From: Dotaciones QUEST <licitaciones@quest.com.co>\r\n";

	//direcci�n de respuesta, si queremos que sea distinta que la del remitente 
	//$headers .= "Reply-To: tucuenta@my-bo.com\r\n"; 
	
	//ruta del mensaje desde origen a destino 
	//$headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 
	
	//direcciones que recibi�n copia 
	$headers .= "Cc: ccedotacionesdevestuario@gmail.com\r\n"; 
	
	//direcciones que recibir�n copia oculta 
	//$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

	//En localhost el env�o de e-mail a veces no funciona, hay que configurar algunas cosas.
    if(mail($destinatario,$asunto,$cuerpo,$headers)){
        return true;
    }else{
        return false;
    }
	/*mail($destinatario,$asunto,$cuerpo,$headers);
	global $statusmail;
	$statusmail = 1;*/
	
}

$statusmail = "";
//if(isset($statusSendOrder) && $statusSendOrder == "readysend"){
    if(mailSendOrder($emailSSUser, $tmplatesend)){
        $statusmail = 1;    
    }else{
        $statusmail = 2;    
    }
//}

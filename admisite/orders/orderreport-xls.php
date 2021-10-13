<?php
function infoDown($filename_){
	$delay = 0;
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'dl/index.php?file='.$filename_;
	$url = "http://$host$uri/$extra";
	try {
		if (!headers_sent() && $delay == 0) {
			
			header("Location: " . $url);
            ob_end_clean();
		}
		// Performs a redirect once headers have been sent
		echo "<meta http-equiv=\"Refresh\" content=\"" . $delay . "; URL=" . $url . "\">";		
		exit();
	} catch (Exception $err) {
		return $err->getMessage();
	}	
}
?>
<?php require_once '../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../cxconfig/config.inc.php'; ?>
<?php require_once '../cxconfig/global-settings.php'; ?>
<?php require_once '../appweb/inc/sessionvars.php'; ?>
<?php require_once '../appweb/lib/gump.class.php'; ?>
<?php require_once '../appweb/inc/site-tools.php'; ?>
<?php require_once '../appweb/inc/query-orders.php'; ?>
<?php require_once '../i18n-textsite.php'; ?>
<?php
//echo "Estamos generando el reporte, por favor espera un momento...";

//recibe datos de PEDIDOS
$idOrder = "";
$dataOrders = array();
$dataOrders = ordersQuery($idOrder);
$resuDataOrders = count($dataOrders);

if($resuDataOrders > 0){
    
    

	if (PHP_SAPI == 'cli')
		die('Este archivo solo se puede ver desde un navegador web');
	
	/** Se agrega la libreria PHPExcel */
	require_once('../appweb/lib/PHPExcel/Classes/PHPExcel.php');

	// Se crea el objeto PHPExcel
	 $objPHPExcel = new PHPExcel();
	
	// Se asignan las propiedades del libro
	$objPHPExcel->getProperties()->setCreator("Dotaciónes Quest") // Nombre del autor
		->setLastModifiedBy("Admi Quest") //Ultimo usuario que lo modificó
		->setTitle("Reporte de pedidos"); // Titulo
		//->setSubject("Reporte Excel con PHP y MySQL") //Asunto
		//->setDescription("Reporte de alumnos") //Descripción
		//->setKeywords("reporte alumnos carreras") //Etiquetas
		//->setCategory("Reporte excel"); //Categorias
	
	$tituloReporte = "Ordenes de pedido";
    
    $subTituloOrden = "Sobre la orden";
    $subTituloItem = "Sobre el Item";
    $subTituloFuncionario = "Sobre el funcionario";
    $subTituloEmpresa = "Sobre la empresa";
    
	$titulosColumnas = array('Fecha', 'Hora', '#Pedido', 'Ciudad Envio', 'Cant.', 'Ref. Item', 'Colección', 'Clima', 'Kit', 'Prenda','Talla','Color', 'Descripción', 'Funcionario', 'Cédula', 'Email', 'Teléfono', 'Dirección', 'Ciudad', 'Entidad compradora', 'Nit', 'Email', 'Teléfono', 'Dirección', 'Ciudad');
        	
	// Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:Y1')
        ->mergeCells('A2:E2')
        ->mergeCells('F2:M2')
        ->mergeCells('N2:S2')
        ->mergeCells('T2:Y2');
	 
	// Se agregan los titulos del reporte
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', $tituloReporte) // Titulo del reporte
        ->setCellValue('A2', $subTituloOrden) // Titulo seccion orden
        ->setCellValue('F2', $subTituloItem) // Titulo seccion item
        ->setCellValue('N2', $subTituloFuncionario) // Titulo seccion funcionario
        ->setCellValue('T2', $subTituloEmpresa) // Titulo seccion empresa
		->setCellValue('A3',  $titulosColumnas[0])  //Titulo de las columnas
		->setCellValue('B3',  $titulosColumnas[1])
		->setCellValue('C3',  $titulosColumnas[2])
		->setCellValue('D3',  $titulosColumnas[3])
		->setCellValue('E3',  $titulosColumnas[4])		
        ->setCellValue('F3',  $titulosColumnas[5])
        ->setCellValue('G3',  $titulosColumnas[6])
        ->setCellValue('H3',  $titulosColumnas[7])
        ->setCellValue('I3',  $titulosColumnas[8])
        ->setCellValue('J3',  $titulosColumnas[9])
        ->setCellValue('K3',  $titulosColumnas[10])
        ->setCellValue('L3',  $titulosColumnas[11])
        ->setCellValue('M3',  $titulosColumnas[12])
        ->setCellValue('N3',  $titulosColumnas[13])
        ->setCellValue('O3',  $titulosColumnas[14])
        ->setCellValue('P3',  $titulosColumnas[15])
        ->setCellValue('Q3',  $titulosColumnas[16])
        ->setCellValue('R3',  $titulosColumnas[17])
        ->setCellValue('S3',  $titulosColumnas[18])
        ->setCellValue('T3',  $titulosColumnas[19])
        ->setCellValue('U3',  $titulosColumnas[20])
        ->setCellValue('V3',  $titulosColumnas[21])
        ->setCellValue('W3',  $titulosColumnas[22])
        ->setCellValue('X3',  $titulosColumnas[23])
        ->setCellValue('Y3',  $titulosColumnas[24]);
		
	//Se agregan los datos de los alumnos
	 
	$i = 4; //Numero de fila donde se va a comenzar a rellenar
	
    if(is_array($dataOrders)){
        foreach($dataOrders as $doKey){
                                    
            //SOBRE EL PEDIDO
            $idItem = $doKey['id_solici_promo'];
            $statusOrder = $doKey['estado_solicitud'];
            $refOrder = $doKey['cod_orden_compra'];
            $nameClientOrder = $doKey['nome_cliente'];
            $telClientOrder = $doKey['tel_cliente'];
            $mailCLientOrder = $doKey['mail_cliente'];
            $nameSotreOrder = $doKey['nome_empresa'];
            $repreStoreOrder = $doKey['representante_empresa'];
            $cityDeliveryOrder = $doKey['ciudad_solicitud'];
            $dateOrder = $doKey['fecha_solicitud'];
            $timeOrder = $doKey['hora_solicitud']; 

            $dataSotreOrder = $doKey['datastore'];
            $dataUserOrder = $doKey['datauser'];
            $dataPackKitOrder = $doKey['datapackit'];
            $dataItemsOrder = $doKey['datadetaorder'];    
            
            $fullNameDelivery = "";
            //NOMBRE DE CIUDAD ENTREGA
            $db->where('id_ciudad_user',$cityDeliveryOrder);
            $queryCiudadEntrega = $db->getOne('ciudades_user', 'id_ciudad_user, name_ciudad_user, name_estado_user'); 
            $nombreCiudadEntrega = $queryCiudadEntrega['name_ciudad_user'];
            $EstadoCiudadEntrega = $queryCiudadEntrega['name_estado_user'];
            $fullNameDelivery = $nombreCiudadEntrega." / ".$EstadoCiudadEntrega;
                  

            //SOBRE LA TIENDA                
            if(is_array($dataSotreOrder)){            

                foreach($dataSotreOrder as $dsokey){                
                    $nameStore = $dsokey['nombre_account_empre'];
                    $nitStore = $dsokey['nit_empresa'];
                    $logoStore = $dsokey['logo_account_empre'];
                    $mailStore = $dsokey['mail_account_empre'];
                    $tel1Store = $dsokey['tel_account_empre1'];
                    $tel2Store = $dsokey['tel_account_empre2'];
                    $dirStore = $dsokey['dir_account_empre'];
                    $cityStore = $dsokey['ciudad_account_empre'];

                }

            }

            //SOBRE EL USUARIO               
            if(is_array($dataUserOrder)){

                foreach($dataUserOrder as $duokey){                
                    $nameUser = $duokey['nombre_account_user'];
                    $documentUser = $duokey['cedula_user'];                
                    $mailUser = $duokey['mail_account_user'];
                    $tel1User = $duokey['tel_account_user'];
                    $tel2User = $duokey['tel_account_user2'];
                    $dirUser = $duokey['dir_account_user'];
                    $cityUser = $duokey['ciudad_account_user'];

                }

            }


            //SOBRE EL PEDIDO                
            $totalItemsORder = count($dataItemsOrder);
            $cantItem = 1;            
            if(is_array($dataItemsOrder)){

                foreach($dataItemsOrder as $eokey){ 
                    $idOrder = $eokey['id_solici_promo'];
                    $cantItemOrder = $eokey['cant_pedido'];
                    $idItemOrder = $eokey['id_prod_filing'];
                    //$nameItemOrder = $eokey['nombre_account_user'];
                    $skuItemOrder = $eokey['cod_venta_prod_filing'];
                    $skuFullItemOrder = html_entity_decode($eokey['cod_venta_descri_filing']);
                    $climaItemOrder = $eokey['tipo_kit_4user'];
                    $kitItemOrder = $eokey['nome_catego_product'];
                    $namePrendaItemOrder = $eokey['nome_subcatego_producto'];
                    $generoKitOrder = $eokey['tags_depatament_produsts'];
                    $labelItemOrder = $eokey['foto_producto_filing'];
                    
                    $tallaLetraItemOrder = $eokey['id_talla_letras'];
                    $tallaNumeItemOrder = $eokey['id_talla_numer'];
                    $colorItemOrder = $eokey['id_color'];
                    
                    
                    //define talla item
                    $tallaItem ="";
                    $colorItem ="";
                    if(isset($tallaLetraItemOrder) && $tallaLetraItemOrder !=""){
                        $db->where('id_talla_letras', $tallaLetraItemOrder);
                        $tallaItem_query = $db->getOne('talla_letras', 'nome_talla_letras');
                        $tallaItem = $tallaItem_query['nome_talla_letras'];
                    }else if(isset($tallaNumeItemOrder) && $tallaNumeItemOrder !=""){
                        $db->where('id_talla_numer', $tallaNumeItemOrder);
                        $tallaItem_query = $db->getOne('talla_numerico', 'talla_numer');
                        $tallaItem = $tallaItem_query['talla_numer'];
                    }
                    
                    //define color item
                    if(isset($colorItemOrder) && $colorItemOrder !=""){
                        $db->where('id_color', $colorItemOrder);
                        $colorItem_query = $db->getOne('tipo_color', 'nome_color');
                        $colorItem = $colorItem_query['nome_color'];
                    }
                    
                    $objPHPExcel->setActiveSheetIndex(0)
                                        
                    ->setCellValue('A'.$i, $dateOrder)
                    ->setCellValue('B'.$i, $timeOrder)
                    ->setCellValue('C'.$i, $refOrder)
                    ->setCellValue('D'.$i, $fullNameDelivery)
                    ->setCellValue('E'.$i, $cantItemOrder)
                    ->setCellValue('F'.$i, $skuItemOrder)
                    ->setCellValue('G'.$i, $generoKitOrder)
                    ->setCellValue('H'.$i, $climaItemOrder)
                    ->setCellValue('I'.$i, $kitItemOrder)
                    ->setCellValue('J'.$i, $namePrendaItemOrder)
                    ->setCellValue('K'.$i, $tallaItem)
                    ->setCellValue('L'.$i, $colorItem)
                    ->setCellValue('M'.$i, $skuFullItemOrder)
                    ->setCellValue('N'.$i, $nameUser)
                    ->setCellValue('O'.$i, $documentUser)
                    ->setCellValue('P'.$i, $mailUser)
                    ->setCellValue('Q'.$i, $tel1User)
                    ->setCellValue('R'.$i, $dirUser)
                    ->setCellValue('S'.$i, $cityUser)
                    ->setCellValue('T'.$i, $nameStore)
                    ->setCellValue('U'.$i, $nitStore)
                    ->setCellValue('V'.$i, $mailStore)
                    ->setCellValue('W'.$i, $tel1User)
                    ->setCellValue('X'.$i, $dirStore)
                    ->setCellValue('Y'.$i, $cityStore);
                    
                    $cantItem += $cantItem;
                    
                    $i++;

                }
            }
                    
        }//fin foreach global
    }//if is un array
    
                                    
	//define estilo de culumnas
	$estiloTituloReporte = array(
		'font' => array(
			'name'      => 'Arial',
			'bold'      => true,
			'italic'    => false,
			'strike'    => false,
			'size' =>16,
			'color'     => array(
				'rgb' => 'FFFFFF'
			)
		),
		'fill' => array(
			'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array(
				'rgb' => 'd51a1a')
		),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_NONE
			)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		)
	);
    
    //define estilo SOBRE ORDEN
	$estiloTituloOrden = array(
		'font' => array(
			'name'      => 'Arial',
			'bold'      => true,
			'italic'    => false,
			'strike'    => false,
			'size' =>14,
			'color'     => array(
				'rgb' => 'FFFFFF'
			)
		),
		'fill' => array(
			'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array(
				'rgb' => '6d6d6d')
		),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_NONE
			)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		)
	);
    
    //define estilo SOBRE ITEM
	$estiloTituloItem = array(
		'font' => array(
			'name'      => 'Arial',
			'bold'      => true,
			'italic'    => false,
			'strike'    => false,
			'size' =>14,
			'color'     => array(
				'rgb' => 'FFFFFF'
			)
		),
		'fill' => array(
			'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array(
				'rgb' => '5f5f5f')
		),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_NONE
			)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		)
	);
    
    //define estilo SOBRE FUNCIONARIO
	$estiloTituloFuncionario = array(
		'font' => array(
			'name'      => 'Arial',
			'bold'      => true,
			'italic'    => false,
			'strike'    => false,
			'size' =>14,
			'color'     => array(
				'rgb' => 'FFFFFF'
			)
		),
		'fill' => array(
			'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array(
				'rgb' => '4f4f4f')
		),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_NONE
			)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		)
	);
    
     //define estilo SOBRE EMPRESA
	$estiloTituloEmpresa = array(
		'font' => array(
			'name'      => 'Arial',
			'bold'      => true,
			'italic'    => false,
			'strike'    => false,
			'size' =>14,
			'color'     => array(
				'rgb' => 'FFFFFF'
			)
		),
		'fill' => array(
			'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array(
				'rgb' => '3f3f3f')
		),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_NONE
			)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		)
	);
	 
	$estiloTituloColumnas = array(
		'font' => array(
			'name'  => 'Arial',
			'bold'  => true,
			'color' => array(
				'rgb' => 'FFFFFF'
			)
		),
		'fill' => array(
			'type'       => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array(
				'rgb' => '555555')
		),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_NONE
			)
		),
		'alignment' =>  array(
			'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'wrap'      => TRUE
		)
	);
	 
	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
		'font' => array(
			'name'  => 'Arial',
			'color' => array(
				'rgb' => '000000'
			)
		),
		'borders' => array(
			'left' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN ,
			'color' => array(
					'rgb' => '333333'
				)
			)
		)
	));
	
	//aplicar estilos a las columnas
	$objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($estiloTituloOrden);
    $objPHPExcel->getActiveSheet()->getStyle('F2:M2')->applyFromArray($estiloTituloItem);
    $objPHPExcel->getActiveSheet()->getStyle('N2:S2')->applyFromArray($estiloTituloFuncionario);
    $objPHPExcel->getActiveSheet()->getStyle('T2:Y2')->applyFromArray($estiloTituloEmpresa);        
	$objPHPExcel->getActiveSheet()->getStyle('A3:Y3')->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:Y".($i-1));
	
	//ancho columnbas
	for($i = 'A'; $i <= 'Y'; $i++){
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
	}
	
	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle('Ordenes de pedido');
	 
	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);
	 
	// Inmovilizar paneles
	//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
	$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);
		
	$filename = "ordenes-de-pedido" .date('dmY-hi') .".xls";
	
	/////////////SI FUNCIONA
	//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    //PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
    
	//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
	//$objWriter->save($filename);
    //PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
    //PHPExcel_Settings::setZipClass(PHPExcel_Settings::ZIPARCHIVE);
	//////////////////
    
    ////////////////////////////////
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save($filename);
	/////////////////////////////////
    
	infoDown($filename);
		
}else{
	print_r('No hay resultados para mostrar');
}//si existen registros
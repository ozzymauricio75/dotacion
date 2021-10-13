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
	$titulosColumnas = array('Fecha', 'Hora', '#Pedido', 'Ciudad Envio', 'Cant.', 'Ref. Item', 'Tipo ropa', 'Clima', 'Kit', 'Descripción', 'Funcionario', 'Cédula', 'Email', 'Teléfono', 'Dirección', 'Ciudad', 'Entidad compradora', 'Nit', 'Email', 'Teléfono', 'Dirección', 'Ciudad');
        	
	// Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:V1');
	 
	// Se agregan los titulos del reporte
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', $tituloReporte) // Titulo del reporte
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
        ->setCellValue('V3',  $titulosColumnas[21]);
		
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
            $cityDeliveryOrder = $doKey['ciudad_empresa'];
            $dateOrder = $doKey['fecha_solicitud'];
            $timeOrder = $doKey['hora_solicitud']; 

            $dataSotreOrder = $doKey['datastore'];
            $dataUserOrder = $doKey['datauser'];
            $dataPackKitOrder = $doKey['datapackit'];
            $dataItemsOrder = $doKey['datadetaorder'];                

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
                    $generoKitOrder = $eokey['tags_depatament_produsts'];
                    $labelItemOrder = $eokey['foto_producto_filing'];
                    
                    
                    $objPHPExcel->setActiveSheetIndex(0)
                                        
                    ->setCellValue('A'.$i, $dateOrder)
                    ->setCellValue('B'.$i, $timeOrder)
                    ->setCellValue('C'.$i, $refOrder)
                    ->setCellValue('D'.$i, $cityDeliveryOrder)
                    ->setCellValue('E'.$i, $cantItemOrder)
                    ->setCellValue('F'.$i, $skuItemOrder)
                    ->setCellValue('G'.$i, $generoKitOrder)
                    ->setCellValue('H'.$i, $climaItemOrder)
                    ->setCellValue('I'.$i, $kitItemOrder)
                    ->setCellValue('J'.$i, $skuFullItemOrder)
                    ->setCellValue('K'.$i, $nameUser)
                    ->setCellValue('L'.$i, $documentUser)
                    ->setCellValue('M'.$i, $mailUser)
                    ->setCellValue('N'.$i, $tel1User)
                    ->setCellValue('O'.$i, $dirUser)
                    ->setCellValue('P'.$i, $cityUser)
                    ->setCellValue('Q'.$i, $nameStore)
                    ->setCellValue('R'.$i, $nitStore)
                    ->setCellValue('S'.$i, $mailStore)
                    ->setCellValue('T'.$i, $tel1User)
                    ->setCellValue('U'.$i, $dirStore)
                    ->setCellValue('V'.$i, $cityStore);
                    
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
				'argb' => '777777')
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
				'argb' => '555555')
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:V1')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A3:V3')->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:V".($i-1));
	
	//ancho columnbas
	for($i = 'A'; $i <= 'V'; $i++){
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
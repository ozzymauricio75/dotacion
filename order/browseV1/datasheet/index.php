<?php
/*if(!isset($_GET['dsfile'])){
    echo "{}";
}else{*/
    
if(isset($_GET['dsfile'])){
    $filePDF = $_GET['dsfile'];
}
$pathPDF = "../../../files-display/fichatecnica/".$filePDF;
$layoutPrintPDF = "<html>";
$layoutPrintPDF .= "<head>";
$layoutPrintPDF .= "<head>";
$layoutPrintPDF .= "</header>";
$layoutPrintPDF .= "<body>";
$layoutPrintPDF .= "<script type='text/javascript' src='../../../appweb/lib/pdfobject.min.js' ></script>";
$layoutPrintPDF .= "<script type='text/javascript'>";
$layoutPrintPDF .= "PDFObject.embed('".$pathPDF."', document.body);";// PDFObject.embed("/pdf/sample-3pp.pdf", document.body);
$layoutPrintPDF .= "</script>";
$layoutPrintPDF .= "</body>";
$layoutPrintPDF .= "</html>";
echo $layoutPrintPDF;
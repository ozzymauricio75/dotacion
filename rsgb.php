<?php //header("Content-Type: image/jpg"); //include 'admiquest/appweb/lib/phMagick/phMagick.php'; ?>
<?php
//https://www.youtube.com/watch?v=XrF0nh1mB2Y
//https://www.sanwebe.com/2014/10/ajax-image-upload-resize-with-imagemagick-jquery-php
//http://www.imagemagick.org/script/perl-magick.php
//http://lab.fawno.com/2016/05/22/php-e-imagemagick-conversion-de-imagenes-cmyk-a-rgb/

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*function transformImageColorspace($imagePath, $colorSpace)
{
    $imagick = new Imagick(realpath($imagePath));
    $imagick->transformimagecolorspace($colorSpace);
    //$imagick->separateImageChannel($channel);
    header("Content-Type: image/jpg");
    return $imagick->getImageBlob();
    
    //$imagick->getImageBlob();
}*/

if(!function_exists('mime_content_type')) {

    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

	$hp = explode('.',$filename);
        $ext = strtolower(array_pop($hp));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}




$directorio = 'files-display/album/800/';
$ficheros1  = scandir($directorio);

//$finfo = new finfo(FILEINFO_MIME);//finfo_open(FILEINFO_MIME_TYPE);


foreach($ficheros1 as $fileK){
    $patchFile = 'files-display/album/800/'.$fileK;//http://dotacionesquest.com.co/
    $colorSpace = "Imagick::COLORSPACE_SRGB";
    //echo $patchFile."<br>";
    //$image_mime = image_type_to_mime_type();
    //$size = getimagesize($patchFile); 
    //echo $size['mime'];
    //$ext = explode('.', $patchFile);
    //$extFile = $ext[1];
    //echo $extFile."<br>";
     //if (file_exists($patchFile)) {
     //$finfo = new finfo(FILEINFO_MIME, "/usr/share/misc/magic.mgc");
	$image_mime = mime_content_type($fileK); //mime_content_type($patchFile); //$finfo->file($patchFile);  //finfo_file($finfo, $patchFile);
     
     if($image_mime=="image/jpeg"){
     	//echo "entro";
     	$patchFilef = 'files-display/album/800/'.$fileK; //http://dotacionesquest.com.co/
	//$imagick = new Imagick($patchFilef);
	//$imagick->transformimagecolorspace(Imagick::COLORSPACE_SRGB);//transformimagecolorspace(Imagick::COLORSPACE_SRGB);
	//$imagick->separateImageChannel(Imagick::CHANNEL_ALL);
	
	//echo $imagick->getImageBlob();
	//$imagick->getImageBlob();
	//$imagick->writeImage($fileK);
	
	 $image = new Imagick($patchFilef);
	  //$icc_cmyk = file_get_contents('ISOnewspaper26v4.icc');
	  //$image->profileImage('icc', $icc_cmyk);
	 
	  $icc_rgb = file_get_contents('http://dotacionesquest.com.co/admisite/appweb/lib/sRGB_v4_ICC_preference_displayclass.icc');
	  $image->profileImage('icc', $icc_rgb);
	  unset($icc_rgb);
	  $image->setImageColorSpace(Imagick::COLORSPACE_RGB);
	  //$image->setImageColorSpace(Imagick::COLORSPACE_RGB);
	  //$image->setImageRenderingIntent(Imagick::RENDERINGINTENT_RELATIVE);
	  //$image->setOption('black_point_compensation', true);
	  
	  //$image->quantizeImage('',Imagick::COLORSPACE_SRGB,'','','');
	  
	 //$image->setImageColorSpace(Imagick::COLORSPACE_SRGB);
	  //$image->transformimagecolorspace(Imagick::COLORSPACE_SRGB);
	 //$image->setImageRenderingIntent(Imagick::RENDERINGINTENT_RELATIVE);
	  //$image->separateImageChannel(Imagick::CHANNEL_ALL);
	  //$image->setOption('black_point_compensation', true);
	 
	 //$image->setCompression(Imagick::COMPRESSION_JPEG); 
	//$image->setCompressionQuality(75);
	 
	 //$image->setImageFormat('jpg');
	 $patchFilefinal = "files-display/album/labelfinal/".$fileK;
	 //if(unlink($patchFilef)){
	  $image->writeImage($patchFilefinal);
	  //}
	
	$image->clear(); 
	$image->destroy(); 
	
    }//else{
         //echo "NO -- entro";
    //}
    
    //$channel = "1";
    //$nuevos = transformImageColorspace($patchFile, $colorSpace);
    
    //echo $nuevos."<br>";
    
    //echo $file."<br>";
    
    //$image = new ImageConverter($file, array(
    //    'tosRGB' => true,
    //));
    //$image->process();
    
    //$image = new Imagick($fileK);
    //$image->Quantize(colorspace=>'sRGB');
}
//finfo_close($finfo);
//print_r($ficheros1);




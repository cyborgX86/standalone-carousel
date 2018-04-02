<?php

/*getPool() obtiene las imágenes y ubicación de la carpeta de reproducción del
Slider.*/

function getPool($path){

    if(substr($path, -1) != "/") $path .= "/"; // añade "/" al final de la carpeta.
    $dir = opendir($path);
    $files = array();

    while ($current = readdir($dir)){
        if( $current != "." && $current != "..") {
            if(is_dir($path.$current)) {
                getPool($path.$current);
            }
            else {
                $files[] = $current;
            }
        }
    }
return array($path, $files);
}

/*getCarousel() obtiene la cola de reproducción incorporando las imagenes al Slider
de forma aleatoria. Si la fecha en el nombre del archivo es menor a la fecha
actual saca la imagen de cola de reproducción. Si el nombre del archivo no comienza
por una fecha válida no entra en cola de reproducción.*/

function getCarousel($path){
    global $path;
    global $files;
    global $widthImage;
    global $heightImage;

    shuffle($files); // desordena el array de forma aleatoria.

    for($i=0; $i<count( $files ); $i++){
      if (is_numeric(substr($files[$i],0,8)) & substr($files[$i],0,8) >= Date("Ymd")){
        echo '<div style="width: ' . $widthImage . 'px; height: ' . $heightImage . 'px;
              max-height: ' . $heightImage . 'px;">
              <img style="width: ' . $widthImage . 'px; height: ' . $heightImage . 'px
              " src="' . $path . $files[$i] . '" />
              </div>';
      }
    }
}

/*getIndicators() obtiene el número de imágenes en la cola de reproducción generando
un elemento <li> para cada uno de ellos dentro de la clase css "indicartors".*/

function getIndicators($path){
  global $files;

    //Se imprime un solo elemento de la clase "active".
    echo '<li class="active"><em></em></li>';

    //Se imprime la lista de elementos (<li> - 1).
    for($i=0; $i<(count( $files ) - 1); $i++){
      if (is_numeric(substr($files[$i],0,8)) & substr($files[$i],0,8) >= Date("Ymd")){
        echo '<li><em></em></li>';
      }
    }
}

/*printHeader() imprime la barra de cabecera si $header está definido a True.*/

function printHeader($header){
  global $header;
  global $titleHeader;
  global $subTitleHeader;
  global $chanelName;
  global $subTitleChanel;

  if ($header === True){
    echo '<nav style="margin: 0px; height: 3%; width: 100%;" class="navbar navbar-default">
  	       <div style="margin: 0px; height: 3%;"class="container-fluid">
  		     <div class="navbar-header">
  			      <a class="navbar-brand">' . $titleHeader . '</a>
  			      <a class="navbar-brand">:::: ' . $subTitleHeader . ' ::::</a>
  		     </div>
  		     <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  			      <ul class="nav navbar-nav">
  				        <li class="active"><a>Canal: #' . $chanelName . '</a></li>
                  <li class="active"><a>:::: ' . $subTitleChanel . ' ::::</a></li>
  			      </ul>
  		     </div>
  	       </div>
          </nav>';
  }else{
    return;
  }
}

/*refreshTime() devuelva el tiempo de refresco en el navegador. El tiempo de refresco
es múltiplo de las imágenes en cola de reproducción.*/

function refreshTime($path){
    global $files;
    global $timeFocus;
    $imagesIn = array();

    for($i=0; $i<count( $files ); $i++){
        if (substr($files[$i],0,8) >= Date("Ymd")){
        array_push($imagesIn, $files[$i]);
      }
    }
$refreshTime = count($imagesIn) * $timeFocus;
return ($refreshTime);
}

/*delFiles() elimina los ficheros que inician su nombre con fecha menor a la fecha
del sistema.*/

function delFiles($path){
  global $path;
  global $files;

    for($i=0; $i<count( $files ); $i++){
      if (is_numeric(substr($files[$i],0,8)) & substr($files[$i],0,8) < Date("Ymd")){
        unlink ($path . $files[$i]);
      }
    }
return;
}
?>

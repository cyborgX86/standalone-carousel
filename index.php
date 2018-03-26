<?php

/*
Muestra información y noticias mediante un carrusel de imágenes. Para que una
imágen entre en cola de reproducción el nombre de la misma debe comenzar por la
fecha de vencimiento de la noticia (yyyymmdd*.*). Una vez vencida la fecha saldrá
de cola de reproducción y la imagen será eliminada.
*/

require_once ('config.inc.php');
require_once ('functions.inc.php');

$path  = getPool($pool)[0]; // ubicación de las imágenes.
$files = getPool($pool)[1]; // elementos del carrusel.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?php echo ($title); ?></title>
    <meta http-equiv="refresh" content="<?php echo refreshTime($pool); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="StyleSheet" type="text/css">
    <script src="jquery/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript">
    // Carrusel/indicadores.
    $(function(){
	$('#carousel div:gt(0)').hide();
	setInterval(function(){
          // control carrusel
          $('#carousel div:first-child').fadeOut(<?php echo ($fadeOut); ?>)
          .next('div').fadeIn(<?php echo ($fadeIn); ?>).end().appendTo('#carousel');
          // control indicadores
          $('.indicators li.active').removeClass('active').next()
          .add('.indicators li:first').last().addClass('active');
        }, <?php echo ($timeFocus * 1000); ?>); // milisegundos.
      });
      </script>

</head>
<body>

<?php printHeader($header) ?>

<div style="margin-top: 3%; margin-bottom: 1%;">
  <div align="center" class="col-md-12 col-sm-12  col-xs-12" style="width: 100%; height: 100%;">
    <div id="carousel">
        <?php getCarousel($pool); ?>
    </div>
  </div>
</div>

<div align="center" class="col-md-12 col-sm-12  col-xs-12" style="width: 90%; height: 100%;">
  <ul class="indicators">
    <?php getIndicators($pool); ?>
  </ul>
</div>

</body>
</html>

<?php delFiles($pool);?>

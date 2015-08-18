<?php
require_once "cadenas.php";
function Cabecera ( $titulo, $css, $js = false)
{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<?php  print "<title>$titulo</title>\n" ?>
		<?php
			foreach ($css as $numero => $nombre) {
				print "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://$_SERVER[HTTP_HOST]/CSS/$nombre.css\">\n";
			}
			if($js){
				foreach ($js as $numero => $nombre) {
					print "<script type=\"text/javascript\" src=\"http://$_SERVER[HTTP_HOST]/Javascript/$nombre.js\"></script>\n";
				}
			}
		?>
	</head>
	<body id="page">
<?php
}
function CerrarDocumento()
{
?>
	</body>
</html>
<?php
}
?>
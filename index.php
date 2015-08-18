<?php
// CONSTANTES
define ( "BIBLIOTECA", "./Bibliotecas/" );

// BIBLIOTECAS
require_once "./cargador.php";
require_once "./panel.php";
require_once BIBLIOTECA."autoCarga2.php";
require_once BIBLIOTECA."cadenas.php";
require_once BIBLIOTECA."pagina.php";

//RECOGER SESION
session_start();

// VARIABLES GLOBALES
$servidor = $_SERVER["HTTP_HOST"];
$pagina = obtenerPagina();
$sesionUsuario = isset( $_SESSION["usuario"] );

// INICIALIZAR LA CESTA
if( ! isset( $_SESSION["cesta"] ) ) {
  $_SESSION["cesta"] = new cesta();
  $_SESSION["peso"] = 0;
}
//CARGADOR DE FUNCIONES DE PAGINA
switch ( $pagina ) {
  case 'inicio':
    preparar_inicio();
    break;
  case 'ordenadores':
    preparar_ordenadores();
    break;
  case 'pedido':
   preparar_pedido();
    break;
  case 'servicios':
    $titulo = "SERVICIOS";
    preparar_servicios();
    break;
  case 'areaprivada':
    preparar_areaPrivada();
    break;
}

//CSS APLICADOS EN LA PAGINA
/*$css[] = "bootstrap";
$css[] = "bootstrap-theme";*/
$css[] = "principal";

//JS APLICADOS EN LA PAGINA
$js[] = "Ajax.class";
$js[] = "validacion.array";
$js[] = "cerrarSesion";
$js[] = "cambiar";
$js[] = "ocultar_mostrar_cesta";
$js[] = "cargarPanel";
$js[] = "cerrarPanel";
$js[] = "permitirClick";
$js[] = "enviarConsulta";
$js[] = "cerrarError";
/*$js[] = "JQuery";
$js[] = "bootstrap";*/

Cabecera( $titulo, $css, $js );
cargarPanel();
?>
		<header>
			<div id="barra_inicio">
        <?php barra_inicio_right() ?>
     	</div>
   		<nav id="barra_navegacion">
   			<img id="logo" alt="logo" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/logo.png">
   			<ul id="menu">
   				<li class="menu_seccion">
   					<a href="<?php $_SERVER["HTTP_HOST"]?>/inicio">
              <img id="imagen_inicio" class="seccion" alt="letras_inicio" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/menu-inicio.png" onmouseover="cambiar(this)" onmouseout="cambiar(this)">
            </a>
   				</li>
   				<li class="menu_seccion">
   					<a href="<?php $_SERVER["HTTP_HOST"]?>/servicios">
              <img id="imagen_servicios" class="seccion" alt="letras_servicios" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/menu-servicios.png" onmouseover="cambiar(this)" onmouseout="cambiar(this)">
            </a>
   				</li>
   				<li class="menu_seccion">
   					<a href="<?php $_SERVER["HTTP_HOST"]?>/ordenadores">
              <img id="imagen_ordenadores" class="seccion" alt="letras_ordenadores" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/menu-ordenadores.png" onmouseover="cambiar(this)" onmouseout="cambiar(this)">
            </a>
   				</li>
   			</ul>
   		</nav>
   		<div id="barra_inferior">
   			<?php mostrarSitio( $titulo ); ?>
        <p id="total" class="texto right titulo_inferior">Total: <?php print $_SESSION["cesta"]->total; ?>€</p>
   			<img id="cesta" class="enlace" alt="cesta" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/cesta.png" onmouseover="cambiar(this)" onmouseout="cambiar(this)" onclick="ocultar_mostrar_cesta()">
        <?php comprar()?>
			</div>
  	</header>
    <section id="content">
      <?php cargarContenido(); ?>
    </section>
 		<footer>
 			<section id="footer_content">
  			<div id="redes_sociales">
  				<a href="https://www.facebook.com/pages/IFC-Computers/247123108826081?notif_t=fbpage_fan_invite">
            <img class="redes_sociales lateral_left" alt="facbook" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/facebook.png">
          </a>
          <img class="redes_sociales lateral_left" alt="logo_twitter" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/twitter.png">
  				<img class="redes_sociales lateral_left" alt="googleplus" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/googleplus.png">
  			</div>
  			<ul id="menu_legal">
  				<li class="menu_legal_seccion">
  					<a class="footer_links" onclick="cargarPanel('aviso_legal')">Aviso Legal</a>
  				</li>
  				<li class="menu_legal_seccion">
  					<a class="footer_links" onclick="cargarPanel('privacidad')">Privacidad</a>
  				</li>
  				<li class="menu_legal_seccion">
  					<a class="footer_links" onclick="cargarPanel('politicaCookies')">Política de Cookies</a>
  				</li>
  			</ul>
  			<ul id="menu_contacto">
          <li class="menu_contacto_seccion">
  				  <a class="footer_links" onclick="cargarPanel('contacto')">Contacto</a>
  				</li>
  				<li class="menu_contacto_seccion">Correo: atencionifc@gmail.com</li>
  				<li class="menu_contacto_seccion">Atención al cliente : 697438748-961855475</li>
  			</ul>
  			<img id="whatsapp" alt="whatsapp" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/whatsapp.png">
  		</section>
  	</footer>
<?php
CerrarDocumento();
?>
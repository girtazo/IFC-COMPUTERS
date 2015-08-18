<?php
function cargarPanel() {
	?>
	<div id="pantalla" class="ocultar" onclick="cerrarPanel(this)">
      <section id="contacto" class="ocultar" onmouseover="permitirClick(0)" onmouseout="permitirClick(1)">
        <h3>Contacto</h3>
        <table>
          <tbody>
            <tr><td>Su Correo</td><td><input type="text" name="contacto[correo]" placeholder="Escriba aqui su correo"></td></tr>
            <tr><td>Su Consulta</td><td><textarea cols="50" rows="5" name="contacto[consulta]" placeholder="Escriba aqui su consulta"></textarea></td></tr>
          </tbody>
        </table>
        <input type="button" name="consulta" value="Enviar Consulta" onclick="enviarConsulta()">
      </section>
      <section id="aviso_legal" class="ocultar" onmouseover="permitirClick(0)" onmouseout="permitirClick(1)">
      	<?php textoAvisolegal(); ?>
      </section>
      <section id="privacidad" class="ocultar" onmouseover="permitirClick(0)" onmouseout="permitirClick(1)">
      	<?php textoPrivacidad(); ?>
      </section>
      <section id="politicaCookies" class="ocultar" onmouseover="permitirClick(0)" onmouseout="permitirClick(1)">
      	<?php textoPoliticaCookies(); ?>
      </section>
      <section id="informativa" class="ocultar" onmouseover="permitirClick(0)" onmouseout="permitirClick(1)">
      </section>
      <section id="producto_detalle" class="ocultar" onmouseover="permitirClick(0)" onmouseout="permitirClick(1)">
      	<img id="imagen_detalle" class="left" alt="producto" src="">
      	<div id="descripcion">
      		<h1 id="nombre"></h1>
      		<div id="detalle">
      		</div>
      		<div id="precio"></div>
      	</div>
      </section>
    </div>
    <div id="pantallaError" class="ocultar" onclick="cerrarError()" onmouseover="permitirClick(0)" onmouseout="permitirClick(1)">
      <div id="mensajeError" class="ocultar"></div>
    </div>
   	<?php
}
function cargarCesta() {
	?>
	<section id="cuadro_cesta" class="right ocultar">
        <section id="productos_cesta">
          <?php mostrarProductosCesta(); ?>
        </section>
    </section>
    <?php
}
function barra_inicio_right() {
	global $sesionUsuario;
	if( $sesionUsuario ) {
		?>
		<div title="sesion_usuario" class="barra_inicio_right">
			<a href="<?php $_SERVER["HTTP_HOST"]?>/areaprivada">
				<div id="logo_perfil" class="left" onmouseover="cambiar(this)" onmouseout="cambiar(this)">
					<img class="left" alt="logo_perfil" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/icono_usuario.png" >
					<span class="titulo_inferior left"><?php print $_SESSION["usuario"]->nombre; ?></span>
				</div>		
			</a>
			<img class="left enlace" alt="cerrar_sesion" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/cerrarSesion.png" onclick="cerrarSesion()" onmouseover="cambiar(this)" onmouseout="cambiar(this)">
		</div>
		<?php 
	} else { 
		?>
		<div title="sesion_usuario" class="barra_inicio_right texto">
			<p class="left texto">
    			<a class="footer_links">¿Has olvidado la contraseña? Pulse aqui</a>
    		</p>
			<h3 class="titulo_inferior left">ÁREA CLIENTE</h3>
			<input class="campos left" type="text" name="inicio[correo]" placeholder="Correo">
			<input class="campos left" type="password" name="inicio[password]" placeholder="Contraseña">
			<input class="left boton" type="button" name="inicio" value="Inicio" onclick="inicioSesion()">
    	</div>
		<?php 
	}
}
function mostrarSitio( $titulo ) {
	?>
	<p class="texto titulo_superior blanco" id="sitio"><?php print $titulo ?></p>
	<?php
}
function slider() {
	global $sesionUsuario, $ofertas;
	if( $sesionUsuario ) {
		?>
		<section id="sliderIniciado" class="slider">
		<?php
	} else {
		?>
		<section id="slider" class="slider">
		<?php
	}
	?>
		<ul id="slider_lista">
		<?php
		foreach ($ofertas as $id => $oferta) {
			?>
			<li class="slider_elemento">
				<img class="slider_imagen" alt=<?php print "\"producto_".$oferta->id."\""; ?> src="./imagenes/<?php print $oferta->imagen; ?>">
			</li>
			<?php
		}
		?>
		</ul>
		<a class="boton_left slider_boton enlace" onclick="anteriorOferta()"></a>
		<a class="boton_right slider_boton enlace" onclick="siguienteOferta()"></a>
	</section>
	<?php
}
function cuadro_registro () {
	global $sesionUsuario;
	if( ! $sesionUsuario ) {
		?>		
		<section id="cuadro_registro">
			<div class="left">
			<p class="texto titulo_superior">Regístrese aquí</p>
			<div class="input_dos">
				<p class="parrafo_registro">
					<input type="text" placeholder="Correo" class="campos" name="registro[correo]">
					<input type="password" placeholder="Contraseña" class="campos" name="registro[password]">
				</p>
			</div>
			<div class="input_tres">
				<p class="parrafo_registro">
					<input type="text" placeholder="Nombre" class="campos" name="registro[nombre]">
					<input type="text" placeholder="Apellidos" class="campos" name="registro[apellidos]">
					<input type="text" placeholder="DNI" class="campos" name="registro[dni]">
				</p>
				<p class="parrafo_registro">
					<input type="text" placeholder="Teléfono fijo" class="campos" name="registro[telefono_fijo]">
					<input type="text" placeholder="Teléfono móvil" class="campos" name="registro[telefono_movil]">
				</p>
			</div>
			<div class="input_dos">
				<p class="parrafo_registro">
					<input type="text" placeholder="Código Postal" class="campos" name="registro[codigo_postal]">
					<input type="text" placeholder="Dirección" class="campos" name="registro[direccion]">
				</p>
			</div>
			<div class="input_checkbox">
				<p class="boletin">
					<input type="checkbox" class="campos enlace" name="registro[boletin]">
				</p>
				<p class="blanco boletin">
					Suscríbete a nuestro boletín de ofertas
				</p>
			</div>
			<div class="input_checkbox">
	  			<input type="button" class="boton campos" name="registro" value="Registro" onclick="registrar()" >
			</div>
			</div>
		</section>
		<?php
	}
}
function mostrarOrdenadores ( $productos, $cesta ) {
	?>
	<section id="productos">
	<?php
	foreach( $productos as $id => $producto ) {
		if( ! ( $producto->servicio || $producto->oferta ) ) {
			$descripcion_corta = $producto->descripcion;
			$descripcion_corta = substr($descripcion_corta, 0,185);
			if( $descripcion_corta != $producto->descripcion ) {
				$descripcion_corta = $descripcion_corta. "<span class=\"enlace morado\" onclick=\"ver_producto( '$producto->id' )\"> ... Ver mas</span>";
			}
			?>
			<article>
	  			<h1><?php print $producto->nombre; ?><span class="right"><?php print $producto->precio; ?>€</span></h1>
	  			<img class="producto" alt=<?php print "\"producto_".$producto->id."\""; ?> src="./imagenes/<?php print $producto->imagen; ?>">
	  			<p class="texto left"><?php print $descripcion_corta; ?></p>
				<?php
				$existe = false;
				foreach ( $cesta->productos as $id => $valor ) {
	  				if($producto->id == $id ) {
	  					$existe = true;
	  				}
	  			}
	  			if( $existe ) {
	  				?>
					<div class="left" id="menu_producto">
						<img alt="ver_producto" class="left producto_icon enlace" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/ver_white.png" onclick="ver_producto( <?php print "'$producto->id'"; ?> )">
	        			<img class="left producto_icon enlace" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/mas.gif" onclick="guardar_producto( <?php print "'$producto->nombre'"; ?> )">
	        			<img class="left producto_icon enlace" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/menos.gif" onclick="quitar_producto( <?php print "'$producto->nombre'"; ?> )">
	        			<img class="left producto_icon enlace" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/eliminar.png" onclick="eliminar_producto( <?php print "'$producto->nombre'"; ?> )">
	      			</div>
	      			<?php
	  			} else {
	  				?>
	  				<div class="left" id="menu_producto">
	        			<img alt="ver_producto" class="left producto_icon enlace" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/ver_white.png" onclick="ver_producto( <?php print "'$producto->id'"; ?> )">
	        			<img alt="comprar" class="left producto_icon enlace" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/cesta.png" onclick="guardar_producto( <?php print "'$producto->nombre'"; ?> )">
	      			</div>
					<?php
	  			}
	  			?>	
			</article>
		<?php
		}
	}
	?>
	</section>
	<?php
}
function mostrarServicios($servicios){
	?>
	<div class="center-3 left"></div>
	<section id="servicios" class="panel panel-primary left">
		<div class="panel-heading">Servicios</div>
	<?php
	foreach( $servicios as $id => $servicio ) {
		?>
		<article>
			<img class="producto left" alt="servicio_<?php print $servicio->id; ?>" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/<?php print $servicio->imagen; ?>">
  			<section id="descripcion" class="left"> 
  				<h3><?php print $servicio->nombre; ?><span class="right"><?php print $servicio->precio; ?>€</span></h4>
  				<p class="texto left"><?php print $servicio->descripcion; ?></p>
  			</section>
		</article>
		<?php
	}
	?>
	</section>
	<div class="center-10 left"></div>
	<?php
}
function mostrarProductosCesta() {
	$cesta = $_SESSION["cesta"];
	if( $cesta->productos->count() ) {
		foreach ( $cesta->productos as $id => $producto ) {
			if( $producto = producto::recogeProducto( "id", $producto->productos_id ) ){
				?>
				<article id="producto_cesta">
					<img src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/<?php print $producto->imagen; ?>">
				</article>
				<?php
			}
		}
	} else {
		?>
			<img id="vacio" alt="cesta_vacia" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/vacio.png"> 
		<?php
	}
}
function comprar() {
	global $pagina, $sesionUsuario;
	if( $sesionUsuario && ( $_SESSION["cesta"]->productos->count() > 0 ) ) {
		if( $pagina != "pedido" ) {
			?>
			<a href="<?php $_SERVER["HTTP_HOST"]?>/pedido">
				<div id="pedido" class="right enlace" onmouseover="cambiar(this)" onmouseout="cambiar(this)">
        			<p class="texto right titulo_inferior">Comprar</p>
        			<img id="libretapedido" class="right" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/realiza_pedido.png">
				</div>
			</a>
			<?php
		} else {
			?>
				<div id="pedido" class="right enlace" onmouseover="cambiar(this)" onmouseout="cambiar(this)" onclick ="pedir_pedido()">
        			<p class="texto right titulo_inferior">Realizar Pedido</p>
        			<img id="libretapedido" class="right" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/realiza_pedido.png">
				</div>
			<?php
		}
	}
}
function eleccion() {
	?>
	<section id="tablas">
        <table id="personal">
        	<caption>Datos De envio</caption>
        	<tbody>
        		<tr><td>Nombre:</td><td class="text_right"><?php print $_SESSION["usuario"]->nombre; ?></td></tr>
        		<tr><td>Apellidos:</td><td class="text_right"><?php print $_SESSION["usuario"]->apellidos; ?></td></tr>
        		<tr><td>DNI:</td><td class="text_right"><?php print $_SESSION["usuario"]->dni; ?></td></tr>
        		<tr><td>Codigo Postal:</td><td class="text_right"><?php print $_SESSION["usuario"]->codigo_postal; ?></td></tr>
        		<tr><td>Dirección:</td><td class="text_right"><?php print $_SESSION["usuario"]->direccion; ?></td></tr>
        	</tbody>
        </table>
		<table id="envio">
			<caption>Elige la forma de envio</caption>
			<tbody>
				<?php
					$envios = envio::enviosPedido( $_SESSION["peso"] );
					foreach ($envios as $id => $envio) {
						$empresa = empresa_transporte::recogeEmpresa_transporte("id",$envio->empresas_transporte_id);
						?>
							<tr><td><input class="enlace" type="radio" name="envio" value=<?php print "$envio->id"?> onchange="seleccion_envio(this)"</td><td><?php print $empresa->nombre." ".$envio->tipo." ".$envio->tiempo." ".$envio->coste."€"; ?></td></tr>
						<?php
					}
				?>
			</tbody>
		</table>
		<table id="pago">
			<caption>Pago</caption>
			<tbody>
				<?php
					$pagos = pago::recogeTodosPagos();
					foreach ($pagos as $id => $pago ) {
						?>
							<tr>
								<td><input class="enlace" type="radio" name="pago" value=<?php print "$pago->id"?> onchange="seleccion_pago(this)"></td>
								<td>La forma de pago <?php if($pago->incremento > 0) { print " ".$pago->pago." conlleva un recargo de un ".$pago->incremento."%"; } else { print " ".$pago->pago." no tiene ningun tipo de recargo"; } ?></td>
							</tr>
						<?php
					}
				?>
			</tbody>
		</table>
		<table id="productos">
			<caption><a><img alt="anteriores" class="flecha_cesta enlace" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/flecha_cesta2.png" onclick="navegar_pedido(this)"></a>Pedido<a><img alt="siguientes" class="flecha_cesta enlace" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/flecha_cesta.png" onclick="navegar_pedido(this)"></a></caption>
			<thead><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Importe</th></thead>
			<tbody>
				<?php
				$visulizados = 1;
				$numproducto = 1;
				foreach ($_SESSION["cesta"]->productos as $id => $detalle_cesta) {
					if( $numproducto >= $_SESSION["numero_producto"] ) {
						if ( $visulizados <= $_SESSION["VISUALIZAR_MAXIMO_PRODUCTOS"] ) {
							$producto = producto::recogeProducto( "id", $detalle_cesta->productos_id );
							?>
							<tr>
								<td><?php print $producto->nombre; ?></td>
								<td class="text_center"><?php print $detalle_cesta->cantidad; ?></td>
								<td class="text_right"><?php print $detalle_cesta->precio;?>€</td>
								<td class="text_right"><?php print ($detalle_cesta->cantidad*$detalle_cesta->precio); ?>€</td>
							</tr>
							<?php
							$visulizados++;
						}
					}
					$numproducto++;
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td class="text_right">Pagado con</td>
					<td class="text_right" name="tipo_pago">Transferecia bancaria Incremento:</td>
					<td class="text_center" name="incremento_pago">0%</td>
					<td class="text_right" name="recargo"><?php print $_SESSION["recargo"]; ?>€</td>
				</tr>
				<tr>
					<td class="text_right">Enviado por</td>
					<td class="text_center" name="empresa_envio"></td>
					<td class="text_center" name="tipo_envio"></td>
					<td class="text_right" name="coste_envio"><?php print $_SESSION["coste_envio"]; ?>€</td>
				</tr>
				<tr>
					<td ></td>
					<td></td>
					<td>Total:</td>
					<td id="totalpedido" class="text_right"><?php print ($_SESSION["cesta"]->total + $_SESSION["coste_envio"] + $_SESSION["recargo"] ); ?>€</td>
				</tr>
			</tfoot>
		</table>
	</section>
	<?php
}
function menuAreaPrivada($contenido) {
	?>
	<section id="menuAreaPrivada">
		<ul>
			<li<?php if( $contenido == "datos_cuenta" ) { ?> class="hover"<?php } ?>><a href="<?php $_SERVER["HTTP_HOST"]?>/areaprivada/datos_cuenta"><h3>Datos Cuenta</h3></a></li>
			<!--<li<?php if( $contenido == "cestas" ) { ?> class="hover" <?php } ?>><a href="<?php $_SERVER["HTTP_HOST"]?>/areaprivada"><h3>Cestas Guardadas</h3></a></li>
			<li<?php if( $contenido == "cesta" ) { ?> class="hover" <?php } ?>><a href="<?php $_SERVER["HTTP_HOST"]?>/areaprivada"><h3>Cesta</h3></a></li>-->
			<li<?php if( $contenido == "pedidos" ) { ?> class="hover" <?php } ?>><a href="<?php $_SERVER["HTTP_HOST"]?>/areaprivada/pedidos"><h3>Pedidos</h3></a></li>
	<?php
	if( $_SESSION["usuario"]->administrador ) {
		?>
			<!--<li<?php if( $contenido == "administrar_usuarios" ) { ?> class="hover" <?php } ?>><a href="<?php $_SERVER["HTTP_HOST"]?>/areaprivada/administrar_usuarios"><h3>Administrar Usuarios</h3></a></li>-->
			<li<?php if( $contenido == "administrar_pedidos" ) { ?> class="hover" <?php } ?>><a href="<?php $_SERVER["HTTP_HOST"]?>/areaprivada/administrar_pedidos"><h3>Administrar Pedidos</h3></a></li>
		<?php
	}
	?>
		</ul>
	</section>
	<?php
}
function contenidoAreaPrivada($contenido) {
	?>
	<section id="contenido_menu">
		<?php
		switch ( $contenido ) {
			case "datos_cuenta":
				$fidelidad = fidelidad::recogeFidelidad("id",$_SESSION["usuario"]->fidelidades_id);
				?>
				<table>
					<tbody>
						<tr class="modificable" onmouseover="cambiar(this)" onmouseout="cambiar(this)"><td>Correo:</td><td class="margen"></td><td class="text-right" contenteditable ="true" title="correo" onfocus="seleccionDato(this);" onblur="cambiar_dato()"><?php print $_SESSION["usuario"]->correo; ?></td><td><img src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/realiza_pedido_morado.png"></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Contraseña:</td><td><input type="password" name="password[password]"></td><td>Nueva Contraseña:</td><td><input type="password" name="password[npassword]"></td><td>Repite Contraseña:</td><td><input type="password" name="password[rpassword]"></td><td><input type="button" value="Cambiar Contraseña" onclick="cambiarPassword()"></td></tr>
						<tr><td>Nombre:</td><td class="margen"></td><td class="text-right" title="nombre"><?php print $_SESSION["usuario"]->nombre; ?></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Apellidos:</td><td class="margen"></td><td class="text-right" title="apellidos"><?php print $_SESSION["usuario"]->apellidos; ?></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>DNI:</td><td class="margen"></td><td class="text-right" title="dni"><?php print $_SESSION["usuario"]->dni; ?></td><td></td><td></td><td></td><td></td></tr>
						<tr class="modificable" onmouseover="cambiar(this)" onmouseout="cambiar(this)"><td>Telefono fijo:</td><td class="margen"></td><td class="text-right" title="telefono_fijo" contenteditable ="true" onfocus="seleccionDato(this);" onblur="cambiar_dato()"><?php print $_SESSION["usuario"]->telefono_fijo; ?></td><td><img src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/realiza_pedido_morado.png"></td><td></td><td></td><td></td></tr>
						<tr class="modificable" onmouseover="cambiar(this)" onmouseout="cambiar(this)"><td>Telefono movil:</td><td class="margen"></td><td class="text-right" title="telefono_movil" contenteditable ="true" onfocus="seleccionDato(this);" onblur="cambiar_dato()"><?php print $_SESSION["usuario"]->telefono_movil; ?></td><td><img src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/realiza_pedido_morado.png"></td><td></td><td></td><td></td></tr>
						<tr class="modificable" onmouseover="cambiar(this)" onmouseout="cambiar(this)"><td>Codigo Postal:</td><td class="margen"></td><td class="text-right" title="codigo_postal" contenteditable ="true" onfocus="seleccionDato(this);" onblur="cambiar_dato()"><?php print $_SESSION["usuario"]->codigo_postal; ?></td><td><img src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/realiza_pedido_morado.png"></td><td></td><td></td><td></td></tr>
						<tr class="modificable" onmouseover="cambiar(this)" onmouseout="cambiar(this)"><td>Direccion:</td><td class="margen"></td><td class="text-right" title="direccion" contenteditable ="true" onfocus="seleccionDato(this);" onblur="cambiar_dato()"><?php print $_SESSION["usuario"]->direccion; ?></td><td><img src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/realiza_pedido_morado.png"></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Fidelidad:</td><td class="margen"></td><td class="text-right" title="fidelidades_id"><?php print ( $fidelidad->nombre ); ?></td><td></td><td></td><td></td><td></td></tr>
					</tbody>
				</table>
				<?php
				break;
			case "cestas":
				# code...
				break;
			case "pedidos":
				$pedidos = pedido::recogePedidos("clientes_id", $_SESSION["usuario"]->id);
				if( count( $pedidos ) > 0 ) {
					?>
					<table id="pedidos">
						<thead><th>Numero de Pedido</th><th>Fecha</th><th>Total</th><th>Tipo de Pago</th><th>Tipo de envio</th><th>Pagado</th><th>Enviado</th></thead>
						<tbody>
							<?php
							foreach ($pedidos as $numero => $pedido) {
								$pago = pago::recogePago("id",$pedido->pagos_id);
								$envio = envio::recogeEnvio("id",$pedido->envios_id);
								$empresa_transporte = empresa_transporte::recogeEmpresa_transporte("id",$envio->empresas_transporte_id);
								?>
									<tr id="<?php print $numero; ?>">
										<td><?php print $numero; ?></td>
										<td><?php print $pedido->fecha; ?></td>
										<td><?php print $pedido->total; ?>€</td>
										<td><?php print $pago->pago; ?></td>
										<td><?php print ($envio->tipo." ".$empresa_transporte->nombre); ?></td>
										<td><?php if( $pedido->pagado == 1 ) { print ("Sí"); } else { print("No"); } ?></td>
										<td><?php if( $pedido->enviado == 1 ) { print ("Sí"); } else { print("No"); } ?></td>
										<?php 
										if( ($pedido->enviado != 1) || ($pedido->enviado != 1) ) {
										?>
											<td><img alt="cancelar_pedido" class="enlace" id="cancelar_pedido" src="<?php $_SERVER["HTTP_HOST"]?>/imagenes/cancelar_pedido_morado.png" onclick="cancelarPedido(<?php print $numero; ?>)"></td>
										<?php
										}
										?>
									</tr>
								<?php
							}
							?>
						</tbody>
					</table>
					<?php
				} else {
					?>
						<div id="aviso">No tienes ningun pedido</div>
					<?php
				}
				break;
			case "cesta":
				# code...
				break;
			case "administrar_usuarios":
				$usuarios = usuario::recogeUsuarios( "id", $_SESSION["usuario"]->id, "<>" );
				?>
				<table id="usuarios">
					<thead><th>Correo</th><th>Nombre</th><th>Apellidos</th><th>DNI</th><th>Codigo Postal</th><th>Direccion</th><th>Telefono fijo</th><th>Telefono movil</th><th>Administrador</th><th>Boletin</th><th>Fidelidades</th></thead>
					<tbody>
						<?php
						foreach ($usuarios as $id => $usuario) {
							?>
							<tr>
								<td><?php print ($usuario->correo); ?></td>
								<td><?php print ($usuario->nombre); ?></td>
								<td><?php print ($usuario->apellidos); ?></td>
								<td><?php print ($usuario->dni); ?></td>
								<td><?php print ($usuario->codigo_postal); ?></td>
								<td><?php print ($usuario->direccion); ?></td>
								<td><?php print ($usuario->telefono_fijo); ?></td>
								<td><?php print ($usuario->telefono_movil); ?></td>
								<td><input type="checkbox" name="<?php print $usuario->id; ?>" <?php if( $usuario->administrador == 1 ) { print("checked"); } ?> value="<?php print( $usuario->administrador); ?>" onclick="cambiar_rol('<?php print( $usuario->id); ?>')"></td>
								<td><input type="checkbox" name="<?php print $usuario->id; ?>" <?php if( $usuario->boletin == 1 ) { print("checked"); } ?> value="<?php print( $usuario->boletin); ?>" onclick="cambiar_suscripcion('<?php print( $usuario->id); ?>')"></td>
								<td><?php if ( $usuario->fidelidades_id == 1 ) { print ("cliente"); } ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<?php
				break;
				break;
			case "administrar_pedidos":
				$pedidos = pedido::recogeTodosPedidos();
				?>
				<table id="pedidos">
					<thead><th>Numero de Pedido</th><th>Fecha</th><th>Total</th><th>Tipo de Pago</th><th>Tipo de envio</th><th>Pagado</th><th>Enviado</th></thead>
					<tbody>
						<?php
						foreach ($pedidos as $numero => $pedido) {
							$pago = pago::recogePago("id",$pedido->pagos_id);
							$envio = envio::recogeEnvio("id",$pedido->envios_id);
							$empresa_transporte = empresa_transporte::recogeEmpresa_transporte("id",$envio->empresas_transporte_id);
							?>
								<tr>
									<td><?php print $numero; ?></td>
									<td><?php print $pedido->fecha; ?></td>
									<td><?php print $pedido->total; ?>€</td>
									<td><?php print $pago->pago; ?></td>
									<td><?php print ($envio->tipo." ".$empresa_transporte->nombre); ?></td>
									<td><input type="checkbox" name="actualiza[pagado][<?php print $pedido->id ?>]" <?php if( $pedido->pagado == 1 ) { ?> checked <?php } ?> value="<?php print $pedido->pagado; ?>" onclick="cambiarEstado(this)"></td>
									<td><input type="checkbox" name="actualiza[enviado][<?php print $pedido->id ?>]" <?php if( $pedido->enviado == 1 ) { ?> checked <?php } ?> value="<?php print $pedido->enviado; ?>" onclick="cambiarEstado(this)"></td>
								</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<?php
				break;
		}
		?>	
	</section>
	<?php
}
function textoAvisolegal() {
	?>
	<h3>Aviso Legal</h3>
	<h4>Datos identificativos</h4>
	<p>En cumplimiento con el deber de información recogido en artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y del Comercio Electrónico,le informamos:</p>

	<p>IFC Computers S.L. (en adelante, IFC Computers) es una empresa dedicada a la venta de Informática Online.</p>
	<p>IFC Computers se encuentra inscrita en el Registro Mercantil de Murcia, Tomo 2236, Libro 0, folio 50, hoja MU-52949.</p>
	<p>IFC Computers con NIF B73347494, es una sociedad domiciliada a los efectos de la presente información en la Avda. Europa, Parcelas 2-5 y 2-6 Polígono Industrial Las Salinas, 30840 Alhama de Murcia, y es en la actualidad la encargada de la explotación, gestión y funcionamiento del sitio web www.pccomponentes.com. Otros datos de contacto que ponemos a su disposición: girtazo@gmail.com.</p>
	<h4>Usuarios</h4>
	<p>El acceso y/o uso de este portal atribuye la condición de USUARIO, que acepta, desde dicho acceso y/o uso, las Condiciones Generales de Uso aquí reflejadas. Las citadas Condiciones serán de aplicación independientemente de las Condiciones Generales de Contratación que en su caso resulten de obligado cumplimiento.</p>

	<h4>Uso del portal</h4>
	<p>www.ifc-shop.tk proporciona el acceso a multitud de productos, informaciones, servicios, programas o datos (en adelante, "los contenidos") en Internet pertenecientes a IFC Computers, o a terceros a los que el USUARIO puede tener acceso. El USUARIO asume la responsabilidad del uso del portal. Dicha responsabilidad se extiende al registro que fuese necesario para acceder a determinados servicios o contenidos. En dicho registro el USUARIO será responsable de aportar información veraz y lícita. Como consecuencia de este registro, al USUARIO se le puede proporcionar una contraseña de la que será responsable, comprometiéndose a hacer un uso diligente y confidencial de la misma. El USUARIO se compromete a hacer un uso adecuado de los contenidos y servicios que IFC Computers ofrece a través de su portal y con carácter enunciativo pero no limitativo, a no emplearlos para:</p>

	<p>Incurrir en actividades ilícitas, ilegales o contrarias a la buena fe y al orden público.</p>
	<p>Difundir contenidos o propaganda de carácter racista, xenófobo, pornográfico ilegal, de apología del terrorismo o atentatorio contra los derechos humanos.</p>
	<p>Provocar daños en los sistemas físicos y lógicos de IFC Computers, de sus proveedores o de terceras personas, introducir o difundir en la red virus informáticos o cualesquiera otros sistemas físicos o lógicos que sean susceptibles de provocar los daños anteriormente mencionados;</p>
	<p>Intentar acceder y, en su caso, utilizar las cuentas de correo electrónico de otros usuarios y modificar o manipular sus mensajes.</p>
	<p>IFC Computers se reserva el derecho de retirar todos aquellos comentarios y aportaciones que vulneren el respeto a la dignidad de la persona, que sean discriminatorios, xenófobos, racistas, pornográficos, que atenten contra la juventud o la infancia, el orden o la seguridad pública o que, a su juicio, no resultaran adecuados para su publicación. En cualquier caso, IFC Computers no será responsable, dentro de los límites marcados por la ley, de las opiniones vertidas por los usuarios en su web a través de cualquier herramienta de participación.</p>

	<h4>Propiedad Intelectual e Industrial</h4>
	<p>Todos los signos distintivos, marcas, nombres comerciales, contenidos, estructura, diseño y forma de presentación de los elementos y cualquier otra información que aparezca en este sitio Web son propiedad de IFC Computers por sí o como cesionaria y están protegidos por los derechos de propiedad industrial e intelectual.</p>
	<p>El usuario tiene prohibida la reproducción, transformación, distribución, comunicación pública y, en general cualquier otra forma de explotación de los elementos referidos en el apartado anterior sin autorización expresa de IFC Computers.</p>
	<p>El usuario se abstendrá de emplear medios que puedan suprimir, alterar, eludir o manipular cualesquiera dispositivos de protección o sistemas de seguridad que puedan estar instalados y que comporten un riesgo o daño o inutilización del sitio Web y/o sus contenidos.</p>
	<p>IFC Computers no se responsabiliza del posible uso inapropiado que terceros realicen de esta página Web, ni de la información que a través de ella transmitan a terceros. El uso de los contenidos que pueda hacer el usuario y las eventuales consecuencias, daños o perjuicios que pudiesen derivarse, son de la exclusiva responsabilidad del usuario. IFC Computers se excluye por los daños y perjuicios de toda naturaleza causados a los usuarios por el uso de enlaces (links), directorios y herramientas de búsqueda, que permiten a los usuarios acceder a sitios Web pertenecientes y/o gestionados por terceros así como de la presencia de virus u otros códigos maliciosos en los contenidos que puedan producir cualquier tipo de daños en el sistema informático, documentos electrónicos o ficheros de los usuarios. IFC Computers se reserva el derecho de ejercitar las acciones legales que considere oportunas derivadas de cualesquiera usos ilícitos por parte de terceros de los contenidos de su página web.</p>
	<h4>Exclusión de garantías y responsabilidad</h4>
	<p>IFC Computers no se hace responsable, en ningún caso, de los daños y perjuicios de cualquier naturaleza que pudieran ocasionar, a título enunciativo: errores u omisiones en los contenidos, falta de disponibilidad del portal o la transmisión de virus o programas maliciosos o lesivos en los contenidos, a pesar de haber adoptado todas las medidas tecnológicas necesarias para evitarlo.</p>

	<h4>Modificaciones</h4>
	<p>IFC Computers se reserva el derecho de efectuar sin previo aviso las modificaciones que considere oportunas en su portal, pudiendo cambiar, suprimir o añadir tanto los contenidos y servicios que se presten a través de la misma como la forma en la que éstos aparezcan presentados o localizados en su portal.</p>

	<h4>Enlaces</h4>
	<p>En el caso de que en nombre del dominio se dispusiesen enlaces o hipervínculos hacía otros sitios de Internet, IFC Computers no ejercerá ningún tipo de control sobre dichos sitios y contenidos. En ningún caso IFC Computers asumirá responsabilidad alguna por los contenidos de algún enlace perteneciente a un sitio web ajeno, ni garantizará la disponibilidad técnica, calidad, fiabilidad, exactitud, amplitud, veracidad, validez y constitucionalidad de cualquier material o información contenida en ninguno de dichos hipervínculos u otros sitios de Internet. Igualmente la inclusión de estas conexiones externas no implicará ningún tipo de asociación, fusión o participación con las entidades conectadas.</p>

	<h4>Derecho de exclusión</h4>
	<p>IFC Computers se reserva el derecho a denegar o retirar el acceso a portal y/o los servicios ofrecidos sin necesidad de preaviso, a instancia propia o de un tercero, a aquellos usuarios que incumplan las Condiciones Generales de Uso.</p>

	<h4>Generalidades</h4>
	<p>IFC Computers perseguirá el incumplimiento de las condiciones así como cualquier utilización indebida de su portal ejerciendo todas las acciones civiles y penales que le puedan corresponder en derecho.</p>

	<h4>Modificación de las presentes condiciones y duración</h4>
	<p>IFC Computers podrá modificar en cualquier momento las condiciones aquí determinadas, siendo debidamente publicadas como aquí aparecen.</p>

	<h4>Legislación aplicable y jurisdicción</h4>
	<p>La relación entre IFC Computers y el USUARIO se regirá por la normativa española vigente y cualquier controversia se someterá a los Juzgados y Tribunales españoles.</p>
	<?php
}
function textoPrivacidad() {
	?>
	<h3>Politica De Privacidad</h3>

	<p>La visita a este sitio Web no implica que el usuario esté obligado a facilitar ninguna información. En el caso de que el usuario facilite alguna información de carácter personal, los datos recogidos en este sitio web serán tratados de forma leal y lícita con sujeción en todo momento a los principios y derechos recogidos en la Ley Orgánica 15/1999, de 13 de diciembre, de Protección de Datos de Carácter Personal (LOPD), y demás normativa de desarrollo.</p>

	<h4>Información a los usuarios</h4>

	<h5>Apartado "Nuevo Cliente"</h5>

	<p>De acuerdo a la Ley Orgánica 15/1999 de 13 de Diciembre, de Protección de Datos de Carácter Personal (LOPD), le informamos que mediante la cumplimentación de los formularios, sus datos personales quedarán incorporados y serán tratados en ficheros de IFC Computers S.L (en adelante, IFC Computers).</p> 

	<p>La principal finalidad de dicho fichero es la gestión de los usuarios registrados en nuestra web, así como el envío de publicidad relativa a los productos y servicios comercializados por IFC Computers o para el envío de publicidad, descuentos y promociones de productos y servicios de otras entidades.</p> 

	<p>Si no desea recibir este tipo de publicidad deberá marcar la casilla que aparece en el formulario.</p> 

	<p>IFC Computers asegura la confidencialidad de los datos aportados y garantiza que, en ningún caso, serán cedidos para ningún otro uso sin mediar consentimiento previo y expreso de nuestros usuarios. Sólo le pediremos aquellos datos necesarios para la prestación del servicio requerido y únicamente serán empleados para este fin.</p>

	<h5> Apartado "Realizar Compra"</h5> 

	<p>De acuerdo a la Ley Orgánica 15/1999 de 13 de Diciembre, de Protección de Datos de Carácter Personal (LOPD), le informamos que mediante la cumplimentación de los formularios, sus datos personales quedarán incorporados y serán tratados en ficheros de IFC Computers.</p> 

	<p>La principal finalidad de dicho fichero es mantener la relación contractual con nuestros clientes, facilitar la tramitación de los pedidos, la realización de estudios estadísticos, así como el envío de publicidad relativa a los productos y servicios comercializados por IFC Computers o para el envío de publicidad, descuentos y promociones de productos y servicios de otras entidades.</p> 

	<p>Con motivo de la compra sus datos pueden ser comunicados a los siguientes destinatarios:</p>
	<ul>
		<li>Entidades bancarias para el pago las compras mediante tarjeta.</li>
		<li>A la Oficina de consumidores y usuarios en caso de existir alguna reclamación.</li>
		<li>A los fabricantes, Servicios técnicos y/o mayoristas en el caso de garantías o reparaciones. Estos destinatarios pueden estar ubicados dentro del territorio Español como en fuera del mismo, en función del producto y/o servicio adquirido.</li>
		<li>En los supuestos legalmente establecidos, como es el caso de las Fuerzas y Cuerpos de Seguridad.</li>
	</ul>
	<p>IFC Computers asegura la confidencialidad de los datos aportados y garantiza que, en ningún caso, serán cedidos para ningún otro uso sin mediar consentimiento previo y expreso de nuestros clientes. Sólo le pediremos aquellos datos necesarios para la prestación del servicio requerido y únicamente serán empleados para este fin.</p>

	<h5>Apartado "Boletín ofertas" </h5>
	<p>De conformidad con lo dispuesto en la Ley Orgánica 15/1999 de 13 de diciembre, de Protección de Datos de Carácter Personal, le informamos que el e-mail facilitado será incorporado en un fichero titularidad de IFC Computers con la finalidad de enviar el boletín de ofertas. Este Boletín tiene carácter exclusivamente informativo. Los datos personales son empleados por IFC Computers de acuerdo con las exigencias de la Ley 15/1999, de 13 de Diciembre, de protección de datos de carácter personal.</p> 

	<h5>Apartado "Formulario de Contacto y Centro de Soporte de IFC Computers" </h5>
	<p>De conformidad con lo dispuesto en la Ley Orgánica 15/1999 de 13 de diciembre, de Protección de Datos de Carácter Personal, le informamos que el email facilitado será incorporado en un fichero titularidad de IFC Computers con la finalidad de gestionar el centro de soporte de IFC Computers y el contacto con el cliente vía ticket.</p>

	<h4>Uso de los tickets</h4>
	<p>Cada usuario puede acceder a sus tickets mediante usuario y contraseña. Las contraseñas son personales e intransferibles y El usuario es responsable del uso de sus contraseñas y de su comunicación a terceros. La información que contiene los tickets es de carácter confidencial. IFC Computers prohíbe la publicación de los tickets a terceros y de su divulgación en foros, redes sociales y cualquier sitio web.</p>

	<h4>Apartado "Formulario RMA"</h4> 
	<p>De acuerdo a la Ley Orgánica 15/1999 de 13 de Diciembre, de Protección de Datos de Carácter Personal (LOPDP), le informamos que mediante la cumplimentacián del formularios, sus datos personales quedarán incorporados y serán tratados en ficheros de IFC Computers.</p>

	<p>La principal finalidad de dicho fichero es la gestión del RMA (Uso de garantía de su producto).</p>

	<p>Sus datos pueden ser comunicados a los fabricantes en el supuesto de productos averiados o defectuosos.</p>

	<h4>Consentimiento</h4>

	<p>Mediante el envío de los formularios entendemos que el usuario presta su consentimiento para que se traten los datos conforme las finalidades previstas en cada uno de los formularios. IFC Computers no comunicará los datos a terceros salvo en los supuestos legalmente establecidos o autorizados por el interesado. IFC Computers comunica a los titulares de los datos su intención de enviarles comunicaciones comerciales por correo electrónico o por cualquier otro medio de comunicación electrónica equivalente. Asimismo, los titulares manifiestan conocer esta intención y prestan su consentimiento expreso para la recepción de las mencionadas comunicaciones. El consentimiento aquí prestado por el Titular para comunicación de datos a terceros tiene carácter revocable en todo momento, sin efectos retroactivos.</p>

	<h4>Derechos de los interesados</h4>
	<p>El interesado puede ejercitar sus derechos ARCO (acceso, rectificación, cancelación y oposición) en relación con sus datos personales dirigiéndose por escrito y adjuntando fotocopia del DNI a la dirección Av. Europa Parcela 2-3, Pol. Ind. Las Salinas 30840 Alhama de Murcia, a través de nuestro formulario o al correo electrónico girtazo@gmail.com. IFC Computers tiene a su disposición modelos mediante los cuales puede ejercitar los derechos ARCO.</p>

	<h4>Calidad de los datos</h4>
	<p>Los usuarios deberán garantizar la veracidad, exactitud, autenticidad y vigencia de los datos de carácter personal que les hayan sido recogidos.</p>

	<h4>Protección de los menores</h4>
	<p>No recogemos datos personales de menores. Es responsabilidad del padre/madre/tutor legal velar por para la privacidad de los menores, haciendo todo lo posible para asegurar que han autorizado la recogida y el uso de los datos personales del menor.</p>

	<h4>Redes Sociales</h4>
	<p>A través de nuestra página web puede acceder a las redes sociales Facebook, Twitter o Google+ de acceso abierto a todos los usuarios. Se trata de sitios web donde el usuario puede registrase y seguirnos gratuitamente. En estas redes sociales los usuarios podrán conocer de nuestras actividades, opiniones, acceder a las fotos y vídeos. Los usuarios de estas redes sociales deben ser conscientes de que este lugar es independiente de la web www.ifc-shop.tk y está abierto, es decir, es visible para todos sus usuarios, y las políticas de privacidad a aplicar a estos contenidos son las fijadas por Facebook, Twitter o Google+. IFC Computers no es titular de las redes sociales.</p>
	<?php
}
function textoPoliticaCookies() {
	?>
	<h3>Política de Cookies </h3>

	<h4>¿Qué es una cookie? </h4>

	<p>Una cookie es un fichero que se descarga en su ordenador al acceder a determinadas páginas web. Las cookies permiten a una página web, entre otras cosas, almacenar y recuperar información sobre los hábitos de navegación de un usuario o de su equipo y, dependiendo de la información que contengan y de la forma en que utilice su equipo, pueden utilizarse para reconocer al usuario.</p>

	<h4>¿Qué tipos de cookies utiliza www.ifc-shop.tk?</h4>

	<p>Según el plazo de tiempo que permanecen activas las cookies pueden ser:</p>

	<p><b>Cookies de sesión:</b> diseñadas para recabar y almacenar datos mientras el usuario accede a una página web. Se suelen emplear para almacenar información que sólo interesa conservar para la prestación del servicio solicitado por el usuario en una sola ocasión (por ejemplo, una lista de productos adquiridos).</p>
	<p><b>Cookies persistentes: </b> Son un tipo de cookies por las que los datos siguen almacenados en el terminal y puede accederse a ellos y ser tratados durante un periodo definido. Tienen fecha de borrado. Se utilizan por ejemplo en el proceso de compra o registro para evitar tener que introducir nuestros datos constantemente.</p>

	<p>Según quien sea la entidad que gestione el equipo o dominio desde donde se envían las cookies y trate los datos que se obtengan, podemos distinguir:</p>

	<p><b>Cookies propias:</b> Son aquellas que se envían al dispositivo del usuario gestionadas exclusivamente por nosotros para el mejor funcionamiento del sitio.</p>
	<p><b>Cookies de terceros:</b> Son aquellas que se envían al dispositivo del usuario desde un equipo o dominio que no es gestionado por nosotros sino por otra entidad, que tratará los datos obtenidos.</p>
	<p>Cuando navegues por www.ifc-shop.tk se pueden instalar en tu dispositivo las siguientes cookies:</p>

	<p><b>Cookies de registro:</b> Cuando el usuario entra en nuestra web e inicia sesión se instala una cookie propia y temporal para que pueda navegar por su zona de usuario sin tener que introducir sus datos continuamente. Esta cookie desaparecerá cuando cierre sesión.</p>
	<p><b>Cookies de análisis:</b> Sirven para estudiar el comportamiento de los usuarios de forma anónima al navegar por nuestra web. Así podremos conocer los contenidos más vistos, el número de visitantes, etc. Una información que utilizaremos para mejorar la experiencia de navegación y optimizar nuestros servicios. Pueden ser propias pero también de terceros. Entre éstas últimas se encuentran las cookies de Google Analytics y las de Iadvice.</p>
	<p><b>Cookies publicitarias de terceros:</b> El objetivo es optimizar la exposición de anuncios publicitarios. Para gestionar estos servicios utilizamos la plataforma de Doubleclick de Google que almacena información sobre los anuncios que han sido mostrados a un usuario, los que le interesan y si visita la web del anunciante.</p>

	<h4>Configuración, consulta y desactivación de cookies</h4>
	<p>Usted puede permitir, bloquear o eliminar las cookies instaladas en su equipo mediante la configuración de las opciones del navegador instalado en su ordenador:</p>

	<p>Chrome, desde http://support.google.com/chrome/bin/answer.py?hl=es&answer=95647</p>  
	<p>Safari, desde http://support.apple.com/kb/ph5042</p>
	<p>Explorer, desde http://windows.microsoft.com/es-es/windows7/how-to-manage-cookies-in-internet-explorer-9</p>
	<p>Firefox, desde http://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we</p>

	<p>Todo lo relativo a las cookies de Google, tanto analíticas como publicitarias, así como su administración y configuración se puede consultar en:</p>

	<p>http://www.google.es/intl/es/policies/technologies/types/"</p>
	<p>http://www.google.es/policies/technologies/ads/"</p>
	<p>https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage</p>

	<p>En cuanto a lo referente a las cookies instaladas por Iadvice lo encontrará en <a href="http://www.iadvize.com/es/aviso_legal_iadvize.html">http://www.iadvize.com/es/aviso_legal_iadvize.html</a>

	<p>Si decide deshabilitar las Cookies no podremos ofrecerle algunos de nuestros servicios como, por ejemplo, permanecer identificado o mantener las compras en su carrito.</p>

	<h4>Actualización de cookies</h4>
	<p>Las cookies de <a href="http://www.ifc-shop.tk">http://www.ifc-shop.tk</a> pueden ser actualizadas por lo que aconsejamos que revisen nuestra política de forma periódica.</p>

	<p>Mas informacion en: <a href="http://www.ifc-shop.tk/politica_cookies.html">http://www.ifc-shop.tk/politica_cookies.html</a></p>

	<?php
}
?>
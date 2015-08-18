Array.prototype.valido = true;
Array.prototype.numero_parametro = 0;
Array.prototype.parametro = new Array();
Array.prototype.validar = function () {
	this.valido = true
	for ( var i = 0; i < this.length; i = i +2 ) {
		var cadena = new String(this[i]);
		campo_valido = true;
		if( cadena.substr( cadena.length-1 ,1 ) == "r" ) {
			cadena = cadena.substr( 0, cadena.length-1 );
			campo = document.getElementsByName( cadena )[0];
			if( ! this[i+1].test( campo.value ) ) {
				campo_valido = false;
				this.valido = false;
				// Codigo de campo mal rellenado - Requeridos//
				className = new String( campo.className );
				if( className.substr( className.length-9, 9 ) != "no_valido" ) {
					className = className + " no_valido";
					document.getElementsByName( cadena )[0].className = className;
				}
			}
		} else {
			campo = document.getElementsByName( cadena )[0];
			if( ( ! this[i+1].test( campo.value ) ) && ( campo.value != "" ) ) {
				campo_valido = false;
				this.valido = false;
				// Codigo de campo mal rellenado//
				className = new String( campo.className );
				if( className.substr( className.length-9, 9 ) != "no_valido" ) {
					className = className + " no_valido";
					document.getElementsByName( cadena )[0].className = className;
				}
			}
		}
		if( campo_valido ) {
			className = new String( campo.className );
			if( className.substr( className.length-9, 9 ) == "no_valido" ) {
				className = className.substr( 0, className.length-9 );
			}
			document.getElementsByName( cadena )[0].className = className;
		}
		if( this.valido ) {
			this.parametro[this.numero_parametro] = cadena;
			this.numero_parametro++;
			this.parametro[this.numero_parametro] = document.getElementsByName( cadena )[0].value;
			this.numero_parametro++;
		}
	}
	return this.valido;
}
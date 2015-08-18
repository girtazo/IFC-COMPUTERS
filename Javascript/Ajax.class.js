var Ajax=function (url,metodo,funcion,tipoenvio,parametros,tipocontenido)
{
	this.url=url;
	this.metodo=metodo;
	this.repiticion=true;
	this.funcion = funcion
	this.tipoenvio=tipoenvio;
	this.parametros=parametros;
	this.tipocontenido=tipocontenido;
	this.objecto=null;
	this.RecogerObjeto();
	this.Envio();
	this.Cargar();
}
Ajax.prototype=
{
	RecogerObjeto: function()
	{

		if(window.XMLHttpRequest)
		{
			this.objecto = new XMLHttpRequest();
		}
		else if(window.ActiveXObject)
		{
			this.objecto = new ActiveXObject("Microsoft.XMLHTTP");
		}
		this.objecto.open(this.metodo,this.url,true);
	},
	PrepararParametros: function()
	{
		var cadena="";
		if(this.tipoenvio=="XML")
		{
			cadena="<parametros>";
			for(var c=0;this.parametros.length>c;c++)
			{
				cadena+="<"+this.parametros[c]+">"+this.parametros[c+1]+"</"+this.parametros[c]+">";
				c++;
			}
			cadena+="</parametros>";
		}
		else
		{
			for(var c=0;this.parametros.length>c;c++)
			{
				cadena+=this.parametros[c]+"="+this.parametros[c+1]+"&";
				c++;
			}
			cadena+="nocache="+Math.random();
		}
		this.parametros=cadena;
	},
	Envio: function()
	{
		if(this.metodo=="POST")
		{
			this.objecto.setRequestHeader("Content-Type",this.tipocontenido);
			this.PrepararParametros();
			this.objecto.send(this.parametros);

		}
		else
		{
			this.objecto.send(null);
		}
	},
	Cargar: function()
	{
		this.objecto.onload = this.funcion;
	}
}
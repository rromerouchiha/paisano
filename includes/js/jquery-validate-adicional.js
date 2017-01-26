//Datos alfanumericos
$.validator.addMethod( "alphanumeric", function( value, element ) {
	return this.optional( element ) || /^\w+$/i.test( value );
}, "Letters, numbers, and underscores only please" );


$.validator.addMethod( "textocomun", function( value, element ) {
	return this.optional( element ) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]+$/.test( value );
}, "S&oacute;lo alfanumerico" );

$.validator.addMethod( "direccion", function( value, element ) {
	return this.optional( element ) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ,.#0-9$%&()=?!¡¿/\n#:; ]+$/.test( value );
}, "Letras, n&uacute;meros, #$%&/()=?¡¿;:," );

$.validator.addMethod( "estatura", function( value, element ) {
	return this.optional( element ) || /^[0-9 ]+$/.test( value );
}, "Ingrese una estatura valida (ej.  168 )" );

$.validator.addMethod( "descriptiva", function( value, element ) {
	return this.optional( element ) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ,.#0-9/ ]+$/.test( value );
}, "S&oacute;lo letras y n&uacute;meros" );

$.validator.addMethod( "busqueda", function( value, element ) {
	return this.optional( element ) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ0-9- ]+$/.test( value );
}, "S&oacute;lo letras,fechas y n&uacute;meros" );

$.validator.addMethod( "placa", function( value, element ) {
	return this.optional( element ) || /^[a-zA-ZñÑ0-9/ ]+$/.test( value );
}, "Ingrese una placa correcta" );

$.validator.addMethod( "pas", function( value, element ) {
	return this.optional( element ) || /^[a-zA-Z0-9!#$%/()¡&]+$/.test( value );
}, "S&oacute;lo may&uacute;sculas, min&uacute;sculas, n&uacute;meros y los siguientes caracteres !#$%/()¡&" );

$.validator.addMethod( "usuario", function( value, element ) {
	return this.optional( element ) || /^[a-zA-Z0-9_.]+$/.test( value );
}, "S&oacute;lo may&uacute;sculas, min&uacute;sculas, guion bajo, punto y n&uacute;meros" );

$.validator.addMethod( "numeros", function( value, element ) {
	return this.optional( element ) || /^[0-9]+$/.test( value );
}, "S&oacute;lo n&uacute;meros [0-9]" );

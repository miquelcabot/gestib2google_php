# gestib2google
Conversió de fitxer XML del GestIB al domini de Google

## Requisits
Requisits: 
* Un servidor web amb suport per [PHP 7.0](http://www.php.net/).
* Llibreries Google API. Es poden instal·lar amb la següent instrucció:
```
$ php composer.phar require google/apiclient:^2.0
```
* Crear credencials d'autorització (authorization credentials) seguint [aquest enllaç](https://console.developers.google.com) i copiar el fitxer generat **client_secret.json** a la carpeta arrel de l'aplicació.

## Credits
Basat en el tema [Start Bootstrap SB Admin](https://github.com/BlackrockDigital/startbootstrap-sb-admin/).

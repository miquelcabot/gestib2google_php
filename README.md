# gestib2google
Conversió de fitxer XML del GestIB al domini de Google

## Requisits generals
* Crear credencials d'autorització (authorization credentials) seguint [aquest enllaç](https://console.developers.google.com) i copiar el fitxer generat **client_secret.json** a la carpeta arrel de l'aplicació.
* Crear un fitxer `config.php` (n'hi ha d'exemple a la carpeta arrel).

## Executar amb Apache/PHP
Requisits: 
* Un servidor web amb suport per [PHP 7.0](http://www.php.net/).
* Llibreries Google API. Es poden instal·lar amb la següent instrucció:
```
$ php composer.phar require google/apiclient:^2.0
```
* Copiar l'aplicació a la carpeta `htdocs` d'Apache.

## Executar amb Docker
Requisits: 
* Docker ([https://docs.docker.com/install/](https://docs.docker.com/install/))

Per executar el contenidor:
```
docker-compose up -d
```

Per aturar i eliminar el contenidor:
```
docker-compose down
```

Per anar a l'aplicació web, s'ha d'obrir l'adreça [http://localhost:8080](http://localhost:8080)


## Credits
Basat en el tema [Start Bootstrap SB Admin](https://github.com/BlackrockDigital/startbootstrap-sb-admin/).

<h1 align="center">FATCOM</h1>

## Acerca de FATCOM

FATCOM es un software desarrollado por la empresa **[LoginWeb](https://loginweb.net/)** para la administración de cualquier tipo de empresa o comercio desde internet, con la capacidad de generar una PWA que se instala en distintas plataformas (Windows, Linux, Mac, Android y IOS) para dar una mejor experiencia al usuario final.

## Características

Con el fin de desarrollar un software que pueda administrar de manera eficiente la información de todas las actividades realizadas en una empresa o comercio, FATCOM cuenta con un set de características que te facilitarán la administración de dicha información, entre las cuales podemos destacar:

- **Administración de inventario.**
- **Administración de ventas.**
- **Administración de compras.**
- **Administración de caja.**
- **Facturación computarizada con generación de libros de compras y ventas.**
- **E-Commerce.**
- **Administración de delivery.**


## Componentes

FATCOM está desarrollado bajo el lenguaje PHP, pero también utiliza libreréas basadas en el lenguaje JavaScript. Las herramientas sobre las que está desarrollado FATCOM son:

- **[Laravel](https://vehikl.com/)**
- **[Admin Voyager](https://tighten.co)**
- **[laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)**
- **[Laravel-Excel](https://github.com/Maatwebsite/Laravel-Excel)**
- **[Intervention Image](http://image.intervention.io/)**
- **[simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode)**
- **[Numeros-en-Letras](https://github.com/villca/Numeros-en-Letras)**
- **[barcode](https://github.com/milon/barcode)**
- **[laravel-mix](https://laravel.com/docs/5.8/mix)**
- **[Laravel Socialite](https://laravel.com/docs/5.8/socialite)**


## Instalación

Para la instalación de FATCOM se deben seguir algunos pasos que se describen a continuación.

- *Clonar el proyecto desde le repositorio*
```bash
    git clone https://github.com/loginweb-dev/fatcom.git && cd fatcom
```
- *Crear la base de datos "fatcom"*
- *Copiar el archivo .env y editar los datos de usuario del gestos de base de datos*
```bash
    cp .env.example .env && nano .env
```
- *Instalar dependencias de composer y npm*
```bash
    composer install && npm install && npm run prod
```
- *Instalar FATCOM*
```bash
    php artisan fatcom:install
```
- *Luego de instalar todas las dependias se recomienda ejecutar el siguiente comando*
```bash
    composer dump-autoload
```

## Uso

Luego de realizar la instalación, para utilizar el sistema simplemente se debe inicializar el servidor HTTP y el servidor de websockets.

- *Iniciar el servidor HTTP*
```bash
    php artisan serve
```
- *Iniciar el servidor websockets*
```bash
    php artisan websockets:serve
```
- *Una vez iniciado los servicios ingresa a http://127.0.0.1:8000/admin e iniciar sesión con los siguientes datos:*
```bash
Usuario : admin@admin.com
Password: password
```

## Adicional

- **Para que funcione el login desde Facebook y Google debe agregar la clave publica y privada en la parte inferior del archivo .env**
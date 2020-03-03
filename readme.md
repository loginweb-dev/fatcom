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
- **Administración de pedidos.**


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

- **run: git clone https://github.com/loginweb-dev/fatcom.git**
- **run: cd fatcom**
- **run: cp .env.example .env**
- **Crear la base de datos fatcom**
- **run: nano .env**
- **Editar el usuario y contraseña de la conexión a la base de datos**
- **run: composer install**
- **run: php artisan key:generate**
- **run: php artisan migrate**
- **run: php artisan db:seed**
- **run: php artisan storage:link**
- **run: cp -r ./vendor/tcg/voyager/publishable/dummy_content/users ./storage/app/public**
- **run: composer dump-autoload**
- **run: npm install**
- **run: npm run prod**
- **run: php artisan websockets:serve**
- **run: php artisan serve**

```bash
Usuario : admin@admin.com
Password: password
```

### Adicional

- **Para que funcione el login desde Facebook y Google debe agregar la clave publica y privada en la parte inferior del archivo .env**
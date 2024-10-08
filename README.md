
# Restaurante

Soporte Backend para la gestión de mesas de un restuarente. Elaborado totalmente en PHP, sirve como API para las peticiones enviadas desde el proyecto Frontend.

## Tabla de contenidos
- Requisitos Previos
- Instalación y Configuración
- Endpoints
- Errores y manejo de respuestas
- Tecnologías Utilizadas
- Contribuciones

## Requisitos Previos
Antes de comenzar, es necesario que te asegures de tener instalados los siguientes requisitos para tu entorno de desarrollo:
- PHP 8.0 o superior
- Composer
- MySQL
- Un Servidor Web como Apache

Para el desarrollo de este proyecto se ha utlizado XAMPP, por lo que se recomienda su uso. Puede obtenerlo [aquí](https://www.apachefriends.org/es/index.html)

## Instalación
Ya una vez instalados los requisitos, a través del terminal puede escribir el comando, recuerda que al trabajar en XAMPP, el fichero del proyecto debe encontrarse en htdocs: 

``` git clone https://github.com/samg1207/restaurante ``` 

Navega hasta la carpeta y una vez ahí utiliza el siguiente comando:

``` composer install ```

## Endpoints
Para esta sección es fundamental tener el documento .htaccess correctamente elaborado. 

Es también recomendable mas no necesario, tener PHroute. Para esto escribir en la terminal
```composer require phroute/phroute```

En el documento router/routes.php Se encuentran todos endpoints a los que hará referencia el front para la función que necesite. Todas tienen como URL base https://localhost/restaurante/ y luego el endpoint:
- Para Abrir una mesa
  - Endpoint /openservice
  - Método: post
  - Cuerpo: ```"mesa": 1 ```
- Para Cerrar una mesa: 
  - es exactamente igual al anterior con la variación del Endpoint: /closeservice

- Para ver el estado de una mesa: 
  -Endpoint : /seeservice/nro de mesa
  - Método: GET 

- Para hacer un pedido
  - Endpoint /addproduct
  - Método: POST 
  - Data: {
      mesa: numero de la mesa,
      id_producto: id del producto a añadir
      cantidad: cantidad de este producto, por defecto es 1.
  }

  - Para eliminar un pedido:
    - Endpoint: /deleteproduct
    - Método: DELETE 
    - Data: {
      mesa: numero de la mesa,
      id_producto: id del producto a añadir
      cantidad: cantidad de este producto, por defecto es 1.
  }

  -Para ver los productos segun su tipo
    - Endpoint /pizzas o /bebidas o /cafes (Según lo que se quiera ver)
    - Metodo: GET 


## Errores y Manejo de Respuestas: 

Los Errores son recogidos en un archivo .txt por lo que no se muestran en la pantalla. Se recomienda la revisión de este fichero continuamente con el fin de detectar nuevos errores. 

El manejo de respuestas se hace a traves de una clase "Helper" que tiene un método estático "responser", este recoge todas las respuestas HTTP dando como exitosas según el método la 200 o la 201 y como negativas las 400, 401, 404, 405 y 500.

## Tecnologías Utilizadas
- PHP 8.1 como lenguaje de programación en el Servidor
- MySQL como sistema gestor de base de datos
- Composer para la gestión de dependencias

## Contribuciones

Las contribuciones son bienvenidas. Para contribuir:

1. Haz un fork del repositorio.
2. Crea una nueva rama (git checkout -b feature/nueva-funcionalidad).
3. Realiza los cambios y haz commit (git commit -m "Añadir nueva funcionalidad").
4. Envía un pull request.
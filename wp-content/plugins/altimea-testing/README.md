
# Altimea Testing



## Desarrollo frontend

Tools frontend

1. Bootstrap v4.1.1 (marco principal de trabajo)
2. bourbon v4.3.4 (generar efecto al hacer scroll)

Trabajar los estilos(scss), script, imgs y fonts en la carpeta src y usar los comandos de gulp
* gulp build(compila los archivos de la carpeta src en modo desarrollo)
* gulp (ejecuta la tarea gulp build + server de desarrollo)

```sh
gulp build
gulp

```

Siempre antes de enviar un pull o hacer commit se recomienda ejecutar la tarea de gulp dist(compila para producción)

```sh
gulp dist

```

Compilar archivos *PUG*
Se usa la tarea pug debido a que este proceso es muy pesado para hacerlo de modo síncrono.
Despues de escribir tu codigo pug generarlo con el siguiente comando.

```sh
gulp pug

```

### Error común en gulp resueltos

Error: watch ENOSPC

```sh
sudo bash -c 'echo 524288 > /proc/sys/fs/inotify/max_user_watches'
```


## Sass utils core

#### Use breakpoints Bootsrap4.1.1
[ver más documentación](https://getbootstrap.com/docs/4.1/layout/overview/#responsive-breakpoints)

```scss
.my-component{
    // use max-width
    @include media-breakpoint-down(sm){
        // props
    }
    @include media-breakpoint-down(xs){
        // props
        &__head{
            // props
        }
    }
    // use min-width
    @include media-breakpoint-up(xs){
        // props
    }
}
```

#### Alternative for custom breakpoints: Input sass example use mixin mq and style code sass for component

Use sass mixin responsive helpers file in `sass/mixin/_media_queries.scss`
Use BEM for write css: https://css-tricks.com/bem-101/

```scss
.my-component{
    // use max-width mq custom
    @include maxw(360px){
        // props
    }
    // use min-width mq custom
    @include minw(360px){
        // props
    }
}
```





## Desarrollo backend
Agregar variables de configuración en `wp-config.php`  
variables necesarias

	define('WP_ENV', 'dev');
	


## Contributors
@Altimea

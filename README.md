# Sistema Analítico para Supermercados - Guía Completa de Instalación

## Tabla de Contenidos
1. [Requisitos Previos](#requisitos-previos)
2. [Instalación Paso a Paso](#instalación-paso-a-paso)
3. [Configuración del Entorno](#configuración-del-entorno)
4. [Primera Ejecución](#primera-ejecución)
5. [Acceso a los Servicios](#acceso-a-los-servicios)
6. [Estructura del Proyecto](#estructura-del-proyecto)
7. [Configuración de VS Code](#configuración-de-vs-code)
8. [Solución de Problemas](#solución-de-problemas)
9. [Preguntas Frecuentes](#preguntas-frecuentes)

## Requisitos Previos

Antes de comenzar, necesitarás instalar estos programas en tu computadora:

### 1. Instalar Docker
- **Windows 10/11**:
  1. Descargar Docker Desktop desde [docker.com](https://www.docker.com/products/docker-desktop)
  2. Ejecutar el instalador y seguir las instrucciones
  3. Reiniciar la computadora

- **macOS**:
  1. Descargar Docker Desktop para Mac desde [docker.com](https://www.docker.com/products/docker-desktop)
  2. Arrastrar la aplicación a la carpeta Applications
  3. Ejecutar Docker desde Launchpad

- **Linux (Ubuntu/Debian)**:
  ```bash
  sudo apt-get update
  sudo apt-get install docker.io
  sudo systemctl start docker
  sudo systemctl enable docker
  sudo usermod -aG docker $USER
  ```
  *Nota: Deberás cerrar sesión y volver a entrar*

### 2. Instalar Git
- Descargar desde [git-scm.com](https://git-scm.com/downloads)
- Ejecutar el instalador con todas las opciones por defecto

### 3. Instalar Node.js
- Descargar la versión LTS (20.x) desde [nodejs.org](https://nodejs.org/)
- Ejecutar el instalador con configuraciones predeterminadas

### 4. Instalar VS Code
- Descargar desde [code.visualstudio.com](https://code.visualstudio.com/)
- Instalar con opciones por defecto

## Instalación Paso a Paso

### 1. Clonar el Repositorio

Abre una terminal (Command Prompt en Windows, Terminal en Mac/Linux) y ejecuta:

```bash
git clone https://github.com/tu-usuario/tu-repositorio.git
cd tu-repositorio
```

### 2. Configurar el Archivo .env

1. Haz una copia del archivo .env.example:
   ```bash
   cp .env.example .env
   ```

2. Abre el archivo .env en VS Code:
   ```bash
   code .env
   ```

3. Busca y modifica estas líneas:
   ```ini
   DB_CONNECTION=pgsql
   DB_HOST=postgres
   DB_PORT=5432
   DB_DATABASE=olap_dw
   DB_USERNAME=olap_user
   DB_PASSWORD=olap_password
   ```

### 3. Construir los Contenedores Docker

Ejecuta este comando (puede tardar varios minutos la primera vez):

```bash
docker-compose up -d --build
```

*Explicación:*
- `docker-compose up`: Levanta los contenedores
- `-d`: Ejecuta en segundo plano
- `--build`: Reconstruye las imágenes si hay cambios

### 4. Instalar Dependencias de PHP

1. Accede al contenedor de la aplicación:
   ```bash
   docker exec -it olapbd2025-app bash
   ```

2. Instala las dependencias de Composer:
   ```bash
   composer install
   ```

3. Genera la clave de aplicación:
   ```bash
   php artisan key:generate
   ```

### 5. Configurar la Base de Datos

Dentro del mismo contenedor:

1. Ejecuta las migraciones:
   ```bash
   php artisan migrate
   ```

2. Carga datos iniciales:
   ```bash
   php artisan db:seed
   ```

### 6. Instalar Dependencias de Frontend

1. Instala paquetes de Node.js:
   ```bash
   npm install
   ```

2. Compila los assets:
   ```bash
   npm run build
   ```

3. Para desarrollo con recarga automática:
   ```bash
   npm run dev
   ```

### 7. Configurar Permisos

Ejecuta estos comandos dentro del contenedor:

```bash
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache
```

## Configuración del Entorno

### Configuración de PostgreSQL

1. Accede a pgAdmin en http://localhost:5050
2. Inicia sesión con:
   - Email: admin@olap.com
   - Contraseña: admin123
3. Agrega un nuevo servidor:
   - Nombre: OLAP Server
   - Host: postgres
   - Usuario: olap_user
   - Contraseña: olap_password

### Variables de Entorno Importantes

En tu archivo `.env` puedes configurar:

```ini
APP_NAME="Sistema Analítico Supermercados"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Configuración de almacenamiento
FILESYSTEM_DISK=local

# Configuración de caché
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Configuración de correo (opcional)
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@supermercado.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Primera Ejecución

1. Inicia todos los servicios:
   ```bash
   docker-compose up -d
   ```

2. Verifica que todos los contenedores estén corriendo:
   ```bash
   docker ps
   ```
   Deberías ver 4 contenedores con estado "Up"

3. Accede a la aplicación en tu navegador:
   - Frontend: http://localhost:8000
   - API: http://localhost:8000/api

## Acceso a los Servicios

| Servicio       | URL                   | Credenciales               |
|----------------|-----------------------|----------------------------|
| Aplicación     | http://localhost:8000 | -                          |
| PgAdmin        | http://localhost:5050 | admin@olap.com / admin123  |
| PostgreSQL     | postgres:5432         | olap_user / olap_password  |
| Vite Dev       | http://localhost:5173 | -                          |

## Estructura del Proyecto

```
supermercado-analitico/
├── docker/               # Configuraciones de Docker
│   ├── nginx/            # Configuración de Nginx
│   └── postgresql/       # Scripts de inicialización de PostgreSQL
├── app/                  # Lógica principal de la aplicación
│   ├── Models/           # Modelos de la base de datos
│   ├── Http/             # Controladores y middleware
│   └── Services/         # Servicios y lógica de negocio
├── config/               # Configuraciones de Laravel
├── database/             # Migraciones y seeders
│   ├── migrations/       # Esquema de la base de datos
│   ├── seeders/          # Datos iniciales
│   └── factories/        # Generadores de datos de prueba
├── public/               # Archivos accesibles públicamente
├── resources/            # Assets frontend
│   ├── js/               # Código JavaScript/Vue
│   ├── scss/             # Estilos SCSS
│   └── views/            # Vistas Blade
├── routes/               # Definición de rutas
│   ├── api.php           # Rutas de API
│   ├── web.php           # Rutas web
│   └── channels.php      # Rutas de broadcasting
├── storage/              # Archivos generados
├── tests/                # Pruebas automatizadas
├── .env                  # Variables de entorno
├── .env.example          # Plantilla de variables de entorno
├── docker-compose.yml    # Configuración de servicios Docker
├── Dockerfile            # Configuración del contenedor principal
└── package.json          # Dependencias de frontend
```

## Configuración de VS Code

### Extensiones Recomendadas

1. **PHP Intelephense** - Autocompletado para PHP
2. **Laravel Artisan** - Ejecutar comandos de Artisan
3. **Docker** - Manejo de contenedores Docker
4. **PostgreSQL** - Conexión a bases de datos
5. **Volar** - Soporte para Vue 3
6. **ESLint** - Análisis de código JavaScript
7. **Prettier** - Formateo de código

### Configuración de Debugging

1. Crea un archivo `.vscode/launch.json` con:
```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9003,
      "pathMappings": {
        "/var/www": "${workspaceFolder}"
      }
    }
  ]
}
```

2. En tu `.env`, asegúrate de tener:
```ini
XDEBUG_MODE=develop,debug
XDEBUG_CONFIG="client_host=host.docker.internal"
```

## Solución de Problemas

### 1. Docker no inicia

**Síntomas**: Error al ejecutar `docker-compose up`
**Solución**:
1. Verifica que Docker esté corriendo:
   ```bash
   docker ps
   ```
2. En Windows/Mac, abre Docker Desktop y espera a que esté "listo"
3. En Linux, verifica el servicio:
   ```bash
   sudo systemctl status docker
   ```

### 2. Problemas con PostgreSQL

**Síntomas**: Error de conexión a la base de datos
**Solución**:
1. Verifica que el contenedor esté corriendo:
   ```bash
   docker ps | grep postgres
   ```
2. Revisa los logs:
   ```bash
   docker logs olapbd2025-postgres
   ```
3. Prueba conectarte manualmente:
   ```bash
   docker exec -it olapbd2025-postgres psql -U olap_user -d olap_dw
   ```

### 3. Errores de Composer

**Síntomas**: `composer install` falla
**Solución**:
1. Limpia la caché:
   ```bash
   composer clear-cache
   ```
2. Reinstala dependencias:
   ```bash
   rm -rf vendor/
   composer install
   ```

### 4. Problemas con Node.js

**Síntomas**: `npm install` falla
**Solución**:
1. Elimina node_modules:
   ```bash
   rm -rf node_modules/
   ```
2. Limpia caché npm:
   ```bash
   npm cache clean --force
   ```
3. Reinstala:
   ```bash
   npm install
   ```

## Preguntas Frecuentes

### ¿Cómo reinicio el sistema completo?

1. Detén los contenedores:
   ```bash
   docker-compose down
   ```
2. Elimina volúmenes persistentes:
   ```bash
   docker volume prune
   ```
3. Reconstruye:
   ```bash
   docker-compose up -d --build
   ```

### ¿Cómo actualizo el proyecto?

1. Detén los contenedores:
   ```bash
   docker-compose down
   ```
2. Actualiza el código:
   ```bash
   git pull origin main
   ```
3. Reconstruye:
   ```bash
   docker-compose up -d --build
   ```

### ¿Cómo accedo a los logs?

Para ver logs en tiempo real:
```bash
docker-compose logs -f
```

Logs específicos por servicio:
```bash
docker logs olapbd2025-app
docker logs olapbd2025-postgres
docker logs olapbd2025-webserver
```

### ¿Cómo creo un usuario administrador?

1. Accede al contenedor:
   ```bash
   docker exec -it olapbd2025-app bash
   ```
2. Ejecuta:
   ```bash
   php artisan make:filament-user
   ```
3. Sigue las instrucciones para crear el usuario

## Optimización para Desarrollo

### Comandos útiles

- Recargar configuración de Nginx:
  ```bash
  docker exec olapbd2025-webserver nginx -s reload
  ```

- Ejecutar pruebas:
  ```bash
  docker exec olapbd2025-app php artisan test
  ```

- Ver rutas disponibles:
  ```bash
  docker exec olapbd2025-app php artisan route:list
  ```

### Configuración de Hot Reload

Para desarrollo frontend con recarga automática:
1. En una terminal, ejecuta:
   ```bash
   docker exec -it olapbd2025-app npm run dev
   ```
2. Accede a http://localhost:5173

## Licencia

Este proyecto está bajo la [licencia MIT](https://opensource.org/licenses/MIT).

---

Este documento se actualizó por última vez el 27 de Julio de 2025. Para cualquier problema, por favor abre un issue en el repositorio del proyecto.

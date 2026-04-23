# MI PROYECTO "miPHP"
Un proyecto que he creado para aprender PHP.

### SECUENCIA INICIAL DEL PROYECTO.
1. Empezando: lo primero que hice es configurar mi proyecto para que pueda tener una base para poder empezar con el proyecto.
2. ¿Qué es lo exactamente he configurado para haber podido empezar?
3. Pues el proyecto lo estoy haciendo en PHPStorm, la versión premium y para poder visualizar lo que estoy haciendo utilizó XAMPP por eso que el directorio del proyecto se encuentra en "C:\xampp\htdocs\miPHP".
---
4. CONFIGURACIÓN


#### 🚀 miPHP - Estructura y Configuración Profesional

He desarrollado este proyecto con el objetivo de seguir estándares modernos de programación en PHP, priorizando la seguridad, la organización y la escalabilidad. A continuación, detallo cómo he configurado la base del sistema.

---

#### 📂 Arquitectura del Proyecto

He organizado el proyecto siguiendo un estándar profesional que separa la **lógica de negocio** del **punto de entrada público**. De esta forma, solo la carpeta `public/` es accesible desde el servidor web, protegiendo el resto del código fuente.

```text
miPHP/
├── public/                 # Único punto de acceso (Front Controller)
│   └── index.php           # Carga el sistema y gestiona las peticiones
├── src/                    # Lógica del núcleo (Clases bajo el namespace App)
│   ├── Database/           # Gestión de la conexión (Patrón Singleton)
│   └── Models/             # Modelos de datos (Usuario, Tarea, etc.)
├── vendor/                 # Dependencias gestionadas por Composer
├── .env                    # Variables de entorno (Configuración sensible)
├── .env.example            # Plantilla para la configuración del entorno
└── composer.json           # Definición de dependencias y Autoloading
```

---

#### 📦 Gestión de Dependencias con Composer

Para evitar el uso manual de `include` o `require` en cada archivo, he implementado **Autoloading PSR-4**. Esto permite que el sistema localice y cargue mis clases de forma automática.

#### Configuración de `composer.json`
He utilizado `phpdotenv` para gestionar las credenciales de la base de datos de forma segura:

```json
{
    "require": {
        "vlucas/phpdotenv": "^5.6"
    },
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
}
```

#### Comandos clave utilizados:
* `composer require vlucas/phpdotenv`: Para instalar la gestión de variables de entorno.
* `composer dump-autoload`: Lo ejecuto para regenerar el mapa de clases cada vez que añado nuevos directorios o namespaces.

---

#### ⚙️ El "Puente" (Autoloading)

Para que toda la arquitectura funcione, mi archivo `public/index.php` actúa como motor de arranque, cargando el autoloader de Composer antes de cualquier otra lógica:

```php
// Carga automática de todas las clases en src/ y dependencias en vendor/
require_once __DIR__ . '/../vendor/autoload.php';

// Gracias a esto, puedo importar clases limpiamente:
use App\Models\Usuario; 
```

---

#### 🔄 Resumen del Flujo de Datos

He diseñado el flujo de información para que sea modular y seguro:

1.  **Registro:** **Composer** mapea todo el contenido de `src/` bajo el espacio de nombres `App\`.
2.  **Entorno:** **Dotenv** procesa el archivo `.env` y carga las credenciales en la superglobal `$_ENV`.
3.  **Conexión:** La clase `Connection.php` extrae esos datos de forma segura para levantar una instancia de **PDO**.
4.  **Modelos:** Mis clases en `Models/` consumen esa conexión para interactuar con la base de datos mediante sentencias preparadas.

---

#### 🛠️ Tecnologías utilizadas:
* **PHP 8+**
* **Composer** (Gestión de dependencias y PSR-4)
* **PDO** (Conexión segura a base de datos)
* **Dotenv** (Seguridad en variables de entorno)

---
5. Eso hace que el proyecto se pueda visualizar en el navegador después de iniciar el servidor de Apache, también voy a necesitar iniciar el de MySQL para poder trabajar con las bases de datos de cada entidad.
6. Y bien, voy a empezar por crear una entidad sencilla como un usuario por ejemplo. Con los campos de id y nombre, el id sería autoincrementable y sería la clave primaria de la entidad.
7. Después de haber creado la tabla de usuarios, he hecho para tener un input para poder asignarle a cada usuario un nombre y de allí se me listan desde la base de datos que tengo creada.
8. Luego he querido probar algo más complejo y probe por implementar una nueva tabla, para asignarle diferentes tareas a los usuarios. Abajo sale en detalle los campos que tiene cada tarea.
---
### 📊 Datos para la tabla de tareas

| Columna | Tipo | Restricciones | Descripción |
| :--- | :--- | :--- | :--- |
| `id` | **INT** | `PK`, `AUTO_INCREMENT` | Identificador único de registro. |
| `nombre` | **VARCHAR(255)** | `NOT NULL` | Título o descripción de la actividad. |
| `completado` | **TINYINT(1)** | `DEFAULT 0` | Estado (0 = Pendiente, 1 = Finalizada). |
| `usuario_id` | **INT** | `FK` | Relación con el ID del usuario creador. |
| `creado_en` | **TIMESTAMP** | `DEFAULT NOW` | Marca de tiempo de creación. |

---
### 🛠️ Script de Creación (SQL)
Para tener en cuenta el script que he utilizado para la tabla que he creado "tareas":

```sql
-- Estructura para la tabla `tareas`
CREATE TABLE tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    completado TINYINT(1) DEFAULT 0,
    usuario_id INT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    /* Integridad Referencial */
    CONSTRAINT fk_usuario_tarea 
        FOREIGN KEY (usuario_id) 
        REFERENCES usuarios(id) 
        ON DELETE CASCADE
);
```
---
### Filtro y Gestión Individual
Lo siquiente que voy a realizar va a ser:

1. En la lista de usuarios, aparezca un enlace que diga "Ver Tareas".
2. Al hacer clic, la página se "filtre" y te enseñe solo lo que ese usuario tiene pendiente.
3. Añadiremos el botón de Eliminar tarea para practicar el borrado.


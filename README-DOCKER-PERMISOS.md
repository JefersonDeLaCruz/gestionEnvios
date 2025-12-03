# Configuración Docker con UID/GID Dinámico

## Problema Resuelto

El usuario dentro del contenedor ahora coincide con el usuario del host, eliminando problemas de permisos al trabajar con archivos.

## Beneficios

- VSCode puede escribir libremente en los archivos dentro del contenedor
- No se necesita más `chmod` para ajustar permisos manualmente
- Los archivos creados desde el contenedor tienen el propietario correcto
- Funciona automáticamente en todas las PCs del equipo
- Mantiene compatibilidad total con Apache + Laravel

## Cambios Realizados

### Dockerfile
Agregados argumentos UID/GID y configuración del usuario www-data:

```dockerfile
ARG UID=1000
ARG GID=1000

RUN groupmod -g ${GID} www-data && \
    usermod -u ${UID} -g ${GID} www-data && \
    chown -R www-data:www-data /var/www/html

ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data
```

### docker-compose.yml
Configurado para pasar UID/GID como build arguments:

```yaml
services:
  app:
    build:
      context: .
      args:
        UID: ${UID:-1000}
        GID: ${GID:-1000}
```

### Archivos de Configuración

**`.env.docker`** - Personal, NO versionar
```bash
UID=1000
GID=1000
```

**`.env.docker.example`** - Plantilla, SÍ versionar

## Uso

### Configuración Inicial

1. Obtén tu UID/GID:
   ```bash
   id -u  # UID
   id -g  # GID
   ```

2. Crea y edita `.env.docker`:
   ```bash
   cp .env.docker.example .env.docker
   # Edita con tus valores
   ```

3. Reconstruye el contenedor:
   ```bash
   docker-compose down
   docker-compose build --no-cache
   docker-compose up -d
   ```

### Uso Normal

```bash
docker-compose up -d
```

Los permisos funcionan automáticamente sin `chmod`.

## Versionamiento

**NO versionar:**
- `.env.docker` (configuración personal)

**SÍ versionar:**
- `.env.docker.example` (plantilla)
- `dockerfile`
- `docker-compose.yml`

## Solución de Problemas

### Problemas de permisos persisten

```bash
# Verifica valores actuales
cat .env.docker
id -u && id -g

# Reconstruye desde cero
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### El contenedor no inicia

```bash
# Revisa logs
docker-compose logs app

# Verifica que UID/GID sean numéricos en .env.docker
```

## Cómo Funciona

1. Docker Compose lee `UID` y `GID` de `.env.docker`
2. Pasa los valores al Dockerfile como build arguments
3. Dockerfile modifica el usuario `www-data` con tu UID/GID
4. Apache ejecuta como `www-data` con tus permisos
5. Archivos creados tienen tu usuario como propietario

## Para Nuevos Miembros del Equipo

1. Clonar repositorio
2. Copiar `.env.docker.example` a `.env.docker`
3. Ejecutar `id -u` y `id -g`
4. Actualizar `.env.docker` con tus valores
5. Ejecutar `docker-compose up -d`

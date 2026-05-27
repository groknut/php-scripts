
# LEMP сервер внутри Docker на Windows

> ❗️Перед началом убедитесь, что у вас установлены Podman/Docker на Windows. \
> ❗️Для работы с podman/docker-compose мы будем использовать пакетный менеджер python (я буду использовать uv и uvx)


## Сборка сервера

### Инициализация проекта
Склонируйте репозиторий
```bash
git clone lemp-docker
cd lemp-docker
```
Структура проекта будет следующей:
```text
.
├── src/
│   └── index.php
├── docker-compose.yml
├── Dockerfile
└── nginx.conf
```
### Поднимаем сервер
Собираем наш проект:
```bash
uvx podman-compose up -d
```

Переходим на localhost:8080

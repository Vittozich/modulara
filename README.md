# Modulara

Библиотека для модульной архитектуры в Laravel.

## Совместимость
- PHP: `^8.2`
- Laravel: `^10 || ^11 || ^12`

## Что делает пакет
- Автоматически ищет модули в `app/Modular/Modules`.
- Автоматически подключает модульные:
  - маршруты (`Routes/web.php`, `Routes/api.php`)
  - вьюшки (`Views/*`)
  - миграции (`Migrations/*`)
- Публикует базовую структуру `app/Modular/Base` для наследования.
- Поддерживает кэш путей модулей (routes/views/migrations).

## Быстрый старт
1. Подключить пакет через Composer.
2. Опубликовать конфиг:

```bash
php artisan modulara:config
```

3. Опубликовать базовую структуру:

```bash
php artisan modulara:base
```

## Команды
- `php artisan modulara:config` — публикация `config/modulara.php`
- `php artisan modulara:config --force` — перезаписать конфиг
- `php artisan modulara:base` — публикация `app/Modular/Base`
- `php artisan modulara:base --force` — перезаписать base-файлы
- `php artisan modulara:cache-clear` — очистить кэш путей модулей

## Структура модульности
Корень модульности в приложении:
- `app/Modular/Modules`

Минимальный модуль:
- `Routes` ( `web.php` и/или `api.php` )
- `Views` (если модуль рендерит UI)
- `Migrations` (если модуль хранит миграции)

Рекомендуемые директории модуля:
- `Controllers`
- `Actions`
- `DTOs`
- `Repositories`
- `Models`
- `Tests`

## Конфиг `config/modulara.php`

```php
return [
    'nesting_level' => 1,

    'cache' => [
        'enabled' => true,
        'store' => 'file',
        'ttl_seconds' => 3600,
        'key_prefix' => 'modulara',
        'disabled_on_envs' => [
            'local',
            'dev',
            'development',
            'test',
        ],
    ],
];
```

### Параметры
- `nesting_level` — максимальная глубина вложенности модулей.
- `cache.enabled` — включает/выключает кэш путей модулей.
- `cache.store` — Laravel cache store для кэша Modulara (по умолчанию `file`).
- `cache.ttl_seconds` — TTL кэша в секундах. `<= 0` или `null` => `rememberForever`.
- `cache.key_prefix` — префикс ключей кэша.
- `cache.disabled_on_envs` — список `APP_ENV`, где кэш автоматически отключается.

## Как работает кэш
Кэшируются результаты поиска директорий:
- `Routes`
- `Views`
- `Migrations`

Это ускоряет boot приложения при большом количестве модулей.

По умолчанию:
- используется `file` store,
- кэш выключен в окружениях: `local`, `dev`, `development`, `test`.

## Когда очищать кэш
После изменений структуры модулей (добавили/переименовали/удалили папки `Routes/Views/Migrations`):

```bash
php artisan modulara:cache-clear
```

## Проверка работоспособности
1. Убедиться, что команды `modulara:*` доступны в `php artisan list`.
2. Создать тестовый модуль в `app/Modular/Modules` и проверить, что маршрут доступен.
3. Проверить, что модульные вьюшки и миграции подхватились автоматически.

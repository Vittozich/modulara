# Библиотека для разбиения логики на модули

Поддержка только php 8.2 и laravel 10 (это минимум, есть версия 0.2.1 с поддержкой laravel 9.6, но она лишь "проект")

# Проверка работоспособности

1. открыть `/modulara/template/test` в браузере как uri текущего проекта. Должна быть страница с текстом "Hello from template"
2. Работают команды.
3. Тесты ещё пилятся.

## Команды для работы с модульностью:

- `php artisan modulara:config` - публикация файла конфигурации.
  

- `php artisan modulara:base` - публикация базовой структуры с основными классами. (todo изменить публикацию)

## Структура модульности:

Вся модульность начинается в папке `Modular`

Если следовать структуре модульности при создании модулей - все миграции, вьюшки и роуты будут обнаружены автоматически.

В папке `Base` находятся основные элементы системы, от которых должно происходить наследование всех элементов в модульности, 
описание строится в виде `Общее описание : конкретное описание основных элементов`:
- `Actions` - Действия, классы, в которых публичное только одно действие `run`, 2 вида с dto и без. Actions используется только в рамках Dependency Injection. : Присутствует основной класс (который будет настраиваться) и класс работы с DTO объектами.
- `Controllers` - Контроллеры и инвокеры (invokers) - это контроллеры, где выполняется логика только контроллеров, но не приложения, хотя можно сначала писать логику и там (для упрощения) : Присутствуют api и web контроллеры, которые созданы просто для удобства наследования (и доп. настройки)
- `DTOs` - Data Transfer objects - классы, которые позволяют перемещать данные между классами и методами. : Присутствует настраиваемый главный DTO объект
- `Models` - Модели, которые работают с базой данных и используют логику связи между друг-другом. : Присутствуют корневая модель (с описанием методов в виде аннотаций) и основная для наследования (где можно выбрать доп. аргументы, например тип timestamp полей)
- `Repositories` - Репозитории, где выполняется логика запросов моделей. : Присутствует корневой репозиторий, который имеет логику паттерна репозиторий.
- `Routes` - Стандартные роуты: Содержатся не публикуемые шаблоны web и api роутов, так как не имеет смысла их публиковать, когда происходит автоопределение структуры модульности.
- `Tests` - основные тесты, которые используют разный подход к тестированию данных в базе данных (нужен файл .env.testing со своими подключениями к тестовой базе данных): 
    - `DbTestCase` - тестирует данные в тестовой базе, автоматическая очистка базы после каждого теста 
    - `ExistsDbTestCase` - тестирует существующую базу, без её обновление или очистки (для поиска)
    - `SimpleTestCase`- тестирует данные в тестовой базе, но без очистки данных - для проверки наполненности и цепочки тестов.
  
В папке `Mosules` находятся все модули, которые имеют от 1 и до бесконечности вложенность. (1 дефолт)

Каждый уровень вложенности следует называть по-разному, например основной уровень (конечный) всегда будет называться ...Module (SomeNameModule), второй уровень ...Section, третий уровень ...Service и т.д. Но лучше изначально иметь лишь 1 уровень. Ни одно название модуля не должно повторяться даже если они находятся на разных уровнях вложенности.

## Именование компонентов модулей:

### Обязательное (автооопределение):

- `Migrations` - папка, в которой будут содержаться миграции
- `Routes` - папка с роутами, должна содержать и/или `api.php`, `web.php`
- `Views` - папка с вьюшками, к которым затем можно будет обращаться по имени модуля.

### Желательное (автосоздание (в разработке))

- `Controllers` - контроллеры модуля
- `Models` - модели модуля
- `Factories` - фабрики для создания объектов в основном для тестов  
- `Tests` - различные тесты модуля (в разработке, нужно задать или описать как тесты будут обращаться к этой папке) 

### Дополнительное (автосоздание (в разработке) и следование SOLID и частично DDD для разработки)  

- `Repositories` - репозитории моделей модуля
- `DTOs` - DTO объекты для использования в `Actions` или при передаче информации  
- `Actions` - классы с одним методом (run) и вложенными `Tasks`

### Нежелательное (без автосоздания из-за связанности)

- `Services` - сервисы, от которых будут создаваться модели для работы с логикой приложения (нежелательно, потому что сервисы могут быть огромными, огромным количеством DI и методов)

## План разработки:

- [ ] Создать краткую документацию для быстрой работы.
- [x] Основной элемент поиска модулей `Modular.php` - это ядро, используемое в провайдерах (src/).
- [x] Файл конфигурации модулей `modulara.php` (максимальная вложенность = 1) (config/).
- [x] Публикация `Modular/Base` в соответствующую папку с переименованием `namespace` (в базовой сборке Laravel).
- [x] Собственные провайдеры для работы с модульностью.
- [x] Добавление DTO и Actions в структуру и публикацию.
- [ ] Добавление фабрики к DTO и описания функционала DTO и их разновидностей.
- [ ] Добавление к базовой публикации рабочего примера одного модуля.
- [ ] Базовые тесты по проверки работоспособности модульности.
- [ ] Доработка публикации `Base` для добавления новых элементов не нарушения структуры (автоматически добавлять то, чего нет).
- [ ] Добавление Requests к логике модулей.
- [ ] Описание или создание документации (или провайдера) для работы с тестами в модульности.
- [ ] Решение проблемы связанности модулей (либо через статические экспортные методы переопределения классов, либо через структурные экспортные интерфейсы) + описание глобальных модулей и их структуры.
- [ ] Консольные команды по созданию элементов модульности внутри фреймворка.
- [ ] Полная документация по консольным командам и по работе со структурой модульности.
- [ ] Добавление Job (очередей) в модульность.
- [ ] Добавление observers и listeners с events в модульность.
- [ ] Разработка системы логирования в модулях.
- [ ] Разработка методики, code-style и code convention в модульности и разработка паттерна (на подобии porto) 
- [ ] Отключение полное или частичное автопоиска модулей и возможность указания их вручную. 
- [ ] Разработка оболочки для консольных команд (отдельный пакет или в этом, будет указанна ссылка).
- [ ] Разработка отдельного фреймворка модульности (отдельный проект, будет указанна ссылка).
- [ ] Перевести все комменты в коде на английский, где есть русские
- [ ] Разработать и поддерживать свою библиотеку для DTO, за основу взять spatie/data-transfer-object или посмотреть новые реализации

 




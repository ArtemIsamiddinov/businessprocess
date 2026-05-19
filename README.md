# Компонент бизнес-процессов Demai (Business Process Component)

Легковесная и гибкая библиотека для создания бизнес-процессов на вашей платформе. Проект использует строгую типизацию, полностью соответствует стандартам PSR-4 и PSR-12, а также интегрирован с диспетчером событий PSR-14.


## Особенности

* **Интерфейсный подход**: Полная свобода реализации для ваших сущностей и состояний.
* **Безопасность и надежность**: Защита от ошибок неинициализированных свойств (Fatal Error) благодаря встроенному паттерну *Null Object*.
* **Разделение логики**: Легкое подключение кастомной валидации переходов через привязку уникальных валидаторов к конкретным состояниям.
* **Событийная архитектура**: Автоматическая отправка стандартизированного события `StateChangedEvent` после каждого успешного перехода при использовании любого PSR-14 совместимого диспетчера.
* **Fluent API**: Поддержка цепочек вызовов для быстрой настройки конфигурации состояний.

## Установка

Установите пакет с помощью Composer:

```bash
composer require demai/business-process
```

## Быстрый старт

### 1. Реализация сущности
Создайте класс вашей бизнес-модели (например, Заказ или Задача), унаследовав его от `BaseEntity`:

```php
use Demai\BusinessProcess\Entity\BaseEntity;

class Order extends BaseEntity
{
    public function __construct(
        private int \$id
    ) {
        // До явной установки статуса свойство state автоматически 
        // защищено объектом NullState
    }

    public function getId(): int
    {
        return \$this->id;
    }
}
```

### 2. Создание состояний и разрешенных маршрутов
Определите ваши состояния, унаследовав их от `BaseState`. Метод `getNext()` диктует карту разрешенных переходов:

```php
use Demai\BusinessProcess\State\BaseState;

class NewOrderState extends BaseState
{
    public function getNext(): array
    {
        // Возвращаем объекты состояний, на которые разрешен переход
        return [
            new ProcessingOrderState(),
            new CancelledOrderState()
        ];
    }
}
```

### 3. Управление переходами через StateRouter
Используйте `StateRouter` для безопасного перевода сущности из одного состояния в другое с полной поддержкой валидации и сквозного контекста:

```php
use Demai\BusinessProcess\StateRouter;

\$order = new Order(123);
\$order->setState(new NewOrderState()); // Задаем начальное состояние

// Инициализируем роутер (опционально вторым аргументом можно передать ваш PSR-14 EventDispatcher)
\$router = new StateRouter(\$order);

// Выполняем переход с передачей контекста (например, ID пользователя)
\$context = ['actor_id' => 42];
\$result = \$router->setState(new ProcessingOrderState(), false, \$context);

if (\$result === true) {
    echo "Состояние заказа успешно обновлено!";
} else {
    echo "Переход заблокирован: " . \$result; // Например: "incorrect state" или текст ошибки из валидатора
}
```

## Обработка событий

Каждый раз, когда состояние сущности успешно меняется (и в роутер был передан диспетчер), генерируется событие `StateChangedEvent`. Вы можете перехватить его в слушателях вашего приложения:

```php
use Demai\BusinessProcess\StateChangedEvent;

class OrderNotificationListener
{
    public function __invoke(StateChangedEvent \$event): void
    {
        \$entity = \$event->entity;       // Сама сущность (Order)
        \$from = \$event->fromState;     // Предыдущее состояние
        \$to = \$event->toState;         // Новое состояние
        \$context = \$event->context;   // Переданные метаданные (например, ['actor_id' => 42])
        
        // Ваша логика (отправка писем, логирование действия в аудит-лог и т.д.)
    }
}
```

## Разработка и тестирование

Если вы хотите внести изменения в саму библиотеку, убедитесь, что все тесты и проверки стиля кода проходят успешно.

Запуск тестов PHPUnit:
```bash
./vendor/bin/phpunit
```

Запуск линтера PHP CodeSniffer (стандарт PSR-12):
```bash
./vendor/bin/phpcs
```

Автоматическое исправление мелких ошибок форматирования:
```bash
./vendor/bin/phpcbf
```

## Лицензия

Этот проект распространяется под лицензией GNU General Public License v3 (GPL-3.0-only). Подробности см. в файле [LICENSE](LICENSE).

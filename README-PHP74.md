# QueryCriteria для PHP 7.4+ и Laravel 7+

Это версия пакета, адаптированная для работы с PHP 7.4+ и Laravel 7+.

## Совместимость

- PHP 7.4 и выше
- Laravel 7.0 и выше
- DynamoDB 5.0 и выше

## Отличия от основной версии

Основная версия пакета требует PHP 8.2+ и Laravel 10+. Эта версия была адаптирована для работы со старыми версиями PHP и Laravel путем:

1. Изменения зависимостей в composer.json
2. Замены union типов (`string|null`) на nullable типы (`?string`)
3. Удаления типизации свойств класса (property type hints)
4. Замены возвращаемого типа `static` на `self` в интерфейсах и классах
5. Замены стрелочных функций (`fn`) на стандартные функции с use
6. Замены именованных параметров на позиционные

## Основные изменения

1. Изменены зависимости в composer.json:
   - `"php": "^7.4|^8.0"` вместо `"php": "^8.2"`
   - `"laravel/framework": "^7.0|^8.0|^9.0|^10.0"` вместо `"laravel/framework": ">=10.0"`
   - `"baopham/dynamodb": "^5.0|^6.0"` вместо `"baopham/dynamodb": "^6.4"`

2. Исправлены типы в интерфейсах и классах:
   - Заменены возвращаемые типы `static` на `self`
   - Заменены union типы на nullable типы
   - Удалены типизированные свойства классов
   - В ряде методов для совместимости интерфейсов сохранены типизации возвращаемых значений и параметров

3. Заменены все стрелочные функции:
   - Все `fn($param) => $expression` заменены на `function($param) use (...) { return $expression; }`

4. Заменены именованные параметры:
   - Например: `$this->fetch(total: -1, onlyWithCriteriaSet: $onlyWithCriteriaSet)` → `$this->fetch(-1, 1, $onlyWithCriteriaSet)`
   - `->paginate(perPage: $total, page: $page)` → `->paginate($total, $page)`

## Список основных изменений по файлам

- **Изменены стрелочные функции (fn)**: `StackCriteriaBuilder.php`, `WebCriteriaBuilder.php`, `SelectAll.php`
- **Удалены типизированные свойства**: `Where.php`, `WhereDate.php`, `WithRelations.php`, `GreaterThan.php`, `LessThan.php`, `ChainCriteria.php`
- **Заменены union типы**: `FullTextCriteria.php`, `Sort.php`
- **Изменены возвращаемые типы**: `HasCriteriaSelector.php`, `HasDynamoDb.php`, `HasUnion.php`

## Установка

```bash
composer require ihor-ok/query-criteria:1.3.5-php74
```

## Использование

Использование полностью идентично основной версии пакета. 
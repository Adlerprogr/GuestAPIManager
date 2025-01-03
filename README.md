# Guest API Manager

## Описание

Guest API — это микросервис для работы с данными гостей. Микросервис предоставляет API для выполнения CRUD операций над сущностью "Гость". Он позволяет создавать, изменять, удалять и получать данные гостей, которые хранятся в базе данных.

Сущность "Гость" имеет следующие обязательные поля:

- Имя
- Фамилия
- Телефон (уникальное значение)
- Email (уникальное значение)

Дополнительно, у каждого гостя могут быть следующие опциональные атрибуты:

- Страна — если страна не указана, она определяется на основе телефонного кода.

## Что было реализовано:

- **CRUD операции для гостей**:
    - Создание, получение, обновление и удаление гостей.
- **Автоматическое определение страны по номеру телефона**:
    - Если страна не указана, она определяется на основе префикса номера телефона.
- **Валидация входных данных**:
    - Проверка формата номера телефона и уникальности email и телефона.
- **Swagger документация API**:
    - Документация для всех API-эндпоинтов с использованием Swagger.
- **Мониторинг производительности**:
    - Заголовки `X-Debug-Time` и `X-Debug-Memory` для отслеживания времени и памяти.
- **Тесты для маршрутов**:
    - Написаны тесты для проверки корректности работы API.
- **Docker контейнеризация**:
    - Использование Docker для развертывания приложения и базы данных.

### Структура проекта

Проект разделен на несколько слоев:

- **Controllers** — Контроллер для обработки запросов о гостях.
- **Requests** — Запросы и валидация данных гостя.
- **Resources** — Ресурс для форматирования данных гостя в API.
- **Models** — Модель для работы с данными гостя.
- **Services** — Логика работы с phone.
- **config** — Конфигурация префиксов телефонов для определения страны (phone_prefixes.php) и документации API Swagger (l5-swagger.php).
- **factories** — Фабрика для создания тестовых данных о гостях.
- **migrations** — Миграция для создания таблицы гостей.
- **tests** — Тесты для проверки маршрутов API.
- **routes** — Определения маршрутов для API.
- **Dockerfile** — Конфигурация для создания контейнера Docker.
- **docker-compose.yml** — Настройки для запуска контейнеров с помощью Docker Compose.
- **.env** — Файл с переменными окружения для настройки конфигураций.
- **README.md** — Описание проекта, инструкция по установке и запуску.

## Эндпоинты

###  Swagger документация API:
-  Чтобы получить доступ к Swagger UI, запустите приложение и перейдите по следующему маршруту:

   ```bash
   http://localhost:86/api/documentation
   ```


### 1. Создание нового гостя

- **POST** `/api/guests`

  **Запрос**:

  ```json
  {
    "first_name": "John",
    "last_name": "Doe",
    "phone": "+12345678901",
    "email": "john.doe@example.com",
    "country": "USA"
  }
  ```

  **Ответ**:

- **Статус:** `201 Created`

  ```json
  {
    "id": 1,
    "first_name": "John",
    "last_name": "Doe",
    "phone": "+12345678901",
    "email": "john.doe@example.com",
    "country": "USA"
  }
  ```

  **Коды состояния**:
    - `201 Created`: Гость успешно создан.
    - `422 Unprocessable Entity`: Ошибка валидации данных.

### 2. Получение гостя по ID

- **GET** `/api/guests/{id}`

  **Ответ**:

- **Статус:** `200 OK`
  ```json
    {
      "id": 1,
      "first_name": "John",
      "last_name": "Doe",
      "phone": "+12345678901",
      "email": "john.doe@example.com",
      "country": "USA"
    }
  ```

  **Коды состояния**:
    - `200 OK`: Данные гостя успешно получены.
    - `404 Not Found`: Гость с указанным ID не найден.

### 3. Обновление данных гостя

- **PUT** `/api/guests/{id}`

  **Запрос**:

  ```json
  {
    "first_name": "John",
    "last_name": "Doe",
    "phone": "+12345678901",
    "email": "john.doe@example.com",
    "country": "USA"
  }
  ```

  **Ответ**:

- **Статус:** `200 OK`

  ```json
  {
    "id": 1,
    "first_name": "John",
    "last_name": "Doe",
    "phone": "+12345678901",
    "email": "john.doe@example.com",
    "country": "USA"
  }

  ```

  **Коды состояния**:
    - `200 OK`: Гость успешно обновлен.
    - `404 Not Found`: Гость с указанным ID не найден.

### 4. Удаление гостя

- **DELETE** `/api/guests/{id}`

  **Ответ**:

- **Статус:** `204 No Content`

**Коды состояния**:
- `204 No Content`: Гость успешно удален.
- `404 Not Found`: Гость с указанным ID не найден.

## Запуск приложения

1. Убедитесь, что у вас установлен Docker и Docker Compose.
2. Клонируйте репозиторий:

   ```bash
   git clone https://github.com/Adlerprogr/GuestAPIManager
   ```

3. Настройте файл `.env`:

   ```bash
   DB_CONNECTION=pgsql
   DB_HOST=db
   DB_PORT=5432
   DB_DATABASE=laravel
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

4. Запустите сервер:

   ```bash
   docker-compose up --build
   ```

5. Перейти в контейнер php-fpm:

   ```bash
   docker compose exec php-fpm bash
   ```

6. Из контейнера php-fpm установите зависимости:

   ```bash
   composer install
   ```

7. Из контейнера php-fpm запустите миграции:

   ```bash
   php artisan migrate
   ```

8. После запуска сервера вы можете работать с API через такие сервисы как Postman.

## Тестирование

Чтобы протестировать API, выполните команду:

```bash
php artisan test
```

### Тесты

Тесты проверяют правильность работы всех эндпоинтов API. Для генерации данных используется фабрика для модели `Guest`.

### Для запуска тестов используйте команду в контейнере php-fpm:

```bash
php artisan test
```

Автор: [Aldar]
# GuestAPIManager

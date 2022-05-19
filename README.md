Развертывание проекта:

- `git clone`
- `composer install`
- `chmod -R 777 storage`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan queue:table`
- `php artisan migrate`
- настроить очереди либо прописать в .env `QUEUE_CONNECTION=sync` 
- `php artisan -help excdev:create-user`
- `php artisan -help excdev:create-op`

Разное:
- В проекте использованы очереди; [jQuery DataTables](https://datatables.net/); пакет [freshbitsweb/laratables](https://github.com/freshbitsweb/laratables) для работы с jQuery DataTables.
- Как согласно ТЗ сделать "таблицу баланса пользователя" придумать не удалось :( Поэтому просто обернул в транзакцию запрос по обновлению баланса в табл. users и запрос по добавлению операции в табл. operations.  
- Демо: http://excdev.wowcall.ru/ (test@test.ru / 12345)


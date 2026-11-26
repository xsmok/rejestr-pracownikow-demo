# Rejestr pracowników w firmie XYZ

Aplikacja do ewidencji czasu pracy. Przełożony wpisuje pracownikowi liczbę przepracowanych godzin w danym dniu,
pracownik widzi swoje dni w miesiącu, a pracownik, przełożony i administrator komentują dni. Administrator zarządza
kontami użytkowników.

Projekt zaliczeniowy z przedmiotu „Programowanie w zastosowaniach” (Merito).

## Wymagania

- PHP 8.3 lub nowszy (Laravel 13); pracujemy na Laravel Herd z PHP 8.4
- Composer
- MariaDB (pracujemy na 11.4)
- Node.js i npm, żeby zbudować style (Tailwind przez Vite)

## Uruchomienie

1. Zainstaluj zależności PHP:

   ```bash
   composer install
   ```

2. Skopiuj `.env.example` do `.env` i uzupełnij dane bazy (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
   Jeśli aplikacja nie działa pod adresem `http://rejestr-pracownikow-demo.test`, zmień też `APP_URL`, bo z niego
   powstaje link aktywacyjny.

3. Wygeneruj klucz aplikacji:

   ```bash
   php artisan key:generate
   ```

4. Utwórz pustą bazę (domyślnie `rejestr_pracownikow_demo`, kodowanie `utf8mb4`), a potem wybierz jedną z dwóch dróg:
   - zaimportuj eksport bazy dołączony do archiwum, albo
   - utwórz tabele i dane przykładowe:

     ```bash
     php artisan migrate --seed
     ```

5. Zbuduj style:

   ```bash
   npm install
   npm run build
   ```

6. Otwórz aplikację w przeglądarce: w Herdzie `http://rejestr-pracownikow-demo.test`, a bez Herda po
   `php artisan serve` pod adresem `http://127.0.0.1:8000`.

## Konta demo

Konta tworzy `database/seeders/DatabaseSeeder.php`. Wszystkie są już aktywne i mają to samo hasło: `demo2026`.

| Rola | E-mail | Strona po zalogowaniu |
| --- | --- | --- |
| Administrator | `admin@firma-xyz.test` | Użytkownicy |
| Przełożony | `przelozony@firma-xyz.test` | Podsumowanie czasu pracy |
| Pracownik | `a.nowak@firma-xyz.test` | Mój czas pracy |

Pozostali pracownicy to `p.wisniewski@firma-xyz.test` i `k.zielinska@firma-xyz.test`, z tym samym hasłem.

## Aktywacja konta e-mailem

Każde nowe konto, także założone przez administratora, trzeba aktywować linkiem z maila. Lokalnie poczta nie
wychodzi na zewnątrz (`MAIL_MAILER=log`), a mail trafia do `storage/logs/laravel.log`.

- Link kopiuj z linii tekstowej `Aktywuj konto: http://…` na końcu wpisu. W części HTML wpisu znak `&` jest
  zapisany jako `&amp;`, więc link skopiowany stamtąd nie zadziała.
- Link otwieraj jako użytkownik, którego konto aktywujesz. Jeśli w przeglądarce jest zalogowany ktoś inny, na przykład
  administrator, który zakładał konto, aplikacja odpowie błędem 403.
- Link jest ważny 60 minut.

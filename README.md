# Wymagania

- PHP 8.2+
- Composer
- SQLite

## Instalacja

```bash
# Klonowanie repozytorium
git clone <repo-url>
cd 300books

# Instalacja zależności
composer install

# Konfiguracja środowiska
cp .env.example .env
php artisan key:generate

# Migracje bazy danych
php artisan migrate

# (Opcjonalnie) Uruchomienie kolejki
php artisan queue:work
```

## Uruchomienie

```bash
php artisan serve
```

API będzie dostępne pod adresem: `http://localhost:8000/api`

## Uruchomienie testów

```bash
php artisan test
```

## Endpointy API

### Książki

| Metoda | Endpoint | Opis | Auth    |
|--------|----------|------|---------|
| GET | `/api/books` | Lista książek z paginacją | -       |
| GET | `/api/books/{id}` | Szczegóły książki | -       |
| POST | `/api/books` | Dodanie nowej książki | Sanctum |
| PUT | `/api/books/{id}` | Aktualizacja książki | -       |
| DELETE | `/api/books/{id}` | Usunięcie książki | -       |

### Autorzy

| Metoda | Endpoint | Opis | Auth |
|--------|----------|------|------|
| GET | `/api/authors` | Lista autorów z paginacją | - |
| GET | `/api/authors/{id}` | Szczegóły autora | - |

### Parametry zapytań

- `search` - wyszukiwanie (autorzy po tytułach książek)
- `per_page` - liczba wyników na stronie (domyślnie 10)

## Przykłady użycia

```bash
# Lista książek
curl http://localhost:8000/api/books

# Dodanie książki (wymaga tokenu Sanctum)
curl -X POST http://localhost:8000/api/books \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"title": "Nowa książka", "authors": [1, 2]}'

# Wyszukiwanie autorów po tytule książki
curl "http://localhost:8000/api/authors?search=Laravel"
```

## Komenda Artisan

Tworzenie nowego autora:

```bash
php artisan create:author
```

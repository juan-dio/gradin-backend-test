# Gradin Backend

API backend untuk sistem logistik kurir.

## Persyaratan
- PHP 8.2+
- Composer
- MySQL

## Instalasi
1. Clone repo ini.
2. Copy `.env.example` ke `.env` dan sesuaikan konfigurasi database.
3. Jalankan perintah:
   ```bash
   composer install
   php artisan migrate --seed
   ```

## Endpoint Kurir
Base URL: `/api`

| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/couriers` | List kurir (paginated, filter, sort) |
| `POST` | `/couriers` | Tambah kurir |
| `GET` | `/couriers/{id}` | Detail kurir |
| `PUT` | `/couriers/{id}` | Update kurir |
| `DELETE` | `/couriers/{id}` | Hapus kurir |

### Query Params (Index)
- `level`: Filter level (e.g., `1,2,3`)
- `search`: Cari berdasarkan nama
- `sort_by`: `created_at` (default sort: `name`)
- `order`: `asc` / `desc` (untuk `created_at`)
- `per_page`: Jumlah item per halaman (default 15)

## Testing
```bash
php artisan test --filter=CourierTest
```

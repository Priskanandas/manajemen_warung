# Manajemen Warung
Aplikasi manajemen warung sederhana berbasis Laravel 8.
  

## Tech Stack

**Client:** [ruangAdmin](https://github.com/indrijunanda/RuangAdmin), Bootstrap, Jquery, filePond

**Server:** PHP 7.3.x, Laravel 8.x

  
## Dependencies

- [Laravel Breeze](https://github.com/laravel/breeze)
- [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
- [spatie/laravel-activitylog](https://github.com/spatie/laravel-activitylog)
- [akaunting/laravel-setting](https://github.com/akaunting/laravel-setting)
- [Laravel Modules](https://nwidart.com/laravel-modules/v1)


## Fitur

- Manajemen Barang
- Pembelian & Penjualan
- Pencatatan Harga
- Multi-warung (dengan pemilik bisa mengelola lebih dari satu warung)
- Autentikasi & Role (Admin / User)
- Laporan Penjualan Harian & Bulanan
- Pencetakan Nota
- Tema Gelap & Terang
  
## Installation 
``` 
git clone https://github.com/Priskanandas/manajemen_warung.git
cd manajemen_warung
composer install
cp .env.example .env
php artisan admin:install
php artisan key:generate
php artisan migrate --seed
```
That's it!


## Running Tests

To run tests, run the following command

```
php artisan test
```

```
Tests:  29 passed
Time:   7.58s
```

## License

QAdmin is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). 

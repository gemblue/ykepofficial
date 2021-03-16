# HeroicBIT

CMS jadul berbasis CodeIgniter tapi masih kepake buat proyekan cepet. Semoga darinya kita bisa menghasilkan pundi-pundi emas yang melimpah.

## Installation

- Clone project
- run `composer install`
- Create database
- Copy src/env.json.bak to src/env.json
- Run `php cli install`
- Login with admin@admin.com with password 12345

## TODO

✅ Remove Twig template dan diganti dengan Latte template (latte.nette.org)

✅ Ganti fungsi `s()` menjadi `shortcode()`

✅ Ganti fungsi `l()` menjadi `library()`

✅ Remove `public/sites/` folder

✅ Custom code (di luar fitur core HeroicBIT) ditulis di dalam folder `src/`

✅ Template folder mengarah ke `public/frontend/`

✅ Caching json data dari RajaOngkir biar makin cepet loadnya

✅ Konfigurasi setting bisa dibuat di folder `src/settings/`

🔲 Bikin module site template biar bisa ganti2 template landing page

🔲 Bikin konfigurasi setting untuk site template

🔲 Bikin mekanisme multisite dengan subdomain

🔲 Alter setiap table di database supaya support multisite

🔲 Bikin wizard untuk registrasi dan create new site mandiri

🔲 Implementasi unit testing dan integration testing pakai Codeception

🔲 Implementasi API testing

🔲 Support Entries API / Headless CMS Like

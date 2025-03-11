# Chatbot C3 PTIPD UIN SUSKA RIAU

ChatbotC3 adalah proyek chatbot berbasis Laravel menggunakan Botman dan Dialogflow untuk mendukung interaksi percakapan cerdas.

https://doi.org/10.33751/komputasi.v20i2.8281 (Jurnal)
## Tampilan di Telegram
![Tampilan Chatbot](https://raw.githubusercontent.com/Arlan-Ndruru/ChatbotC3/main/public/IMG1.png)
![Tampilan Chatbot](https://raw.githubusercontent.com/Arlan-Ndruru/ChatbotC3/main/public/IMG2.png)

## Fitur (Fitur dapat dijalankan dengan izin creator)
- Integrasi dengan Botman
- Menggunakan Dialogflow untuk NLP
- Multiuser authentication dengan Laratrust
- Frontend menggunakan Tailwind dan Flowbite

## Instalasi
1. Clone repository ini:

```bash
git clone https://github.com/Arlan-Ndruru/ChatbotC3.git
cd ChatbotC3
```

2. Install dependency:

```bash
composer install
npm install
```

3. Copy file environment:

```bash
cp .env.example .env
```

4. Generate key:

```bash
php artisan key:generate
```

5. Konfigurasi database di `.env` lalu migrasi:

```bash
php artisan migrate --seed
```

6. Jalankan server lokal:

```bash
php artisan serve
```

## Struktur Proyek
```
app/
  Http/
    Controllers/
  Conversations/
config/
database/
resources/
  views/
```

## Kontributor
- Arlan Joliansa Ndruru, S.T.
- Muhammad Fikry, S.T., M.Sc
- Yusra, S.T., M.T.

## Lisensi
Proyek ini menggunakan lisensi MIT.


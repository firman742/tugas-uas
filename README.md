# 🎓 Tugas UAS - Sistem Aplikasi Bank Sampah Diansati

Ini adalah repository untuk tugas Ujian Akhir Semester (UAS) yang berisi source code dari sistem manajemen bank sampah Diansati.com.

## 📁 Struktur Proyek

```
- app/
- bootstarp/
- config/
- database/
- public/
- resources/
- routes/
- storage/
- tests/
- ...
```

## 🚀 Cara Menjalankan Proyek (Local)

1. Clone repository:
   ```bash
   git clone https://github.com/firman742/tugas-uas.git
   cd tugas-uas
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install && npm run dev
   ```

3. Copy file `.env.example` lalu ganti nama menjadi '.env' dan sesuaikan konfigurasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Migrasikan database beserta seeder nya:
   ```bash
   php artisan migrate --seed
   ```

5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```

---

## 🤝 Kontribusi

Kami sangat terbuka untuk kontribusi! Lihat [CONTRIBUTING.md](CONTRIBUTING.md) untuk petunjuk cara berkontribusi.

---

## 🧑‍💻 Dibuat Oleh

[//]: # (- Hafidz Firman Abdullah &#40;[@firman742]&#40;https://github.com/firman742&#41;&#41;)

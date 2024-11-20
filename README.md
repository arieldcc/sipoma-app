<h1>20 November 2024</h1>

Cara clone/mengambil project dari GitHub:
1. git clone https://github.com/arieldcc/sipoma-app.git -> di GitHub (ambil project dari GitHub)
2. Composer update -> (update dependence yang dibutuhkan)
3. Php artisan key:generate -> (membuat key ke file .env)
4. Php artisan migrate -> (membuat/memasukkan tabel)
5. Php artisan db:seed —class=nama_class_seeder -> (input data awal) 

php artisan serve --host 0.0.0.0 -> jalankan project

php artisan storage:link -> menghubungkan ke media penyimpanan
chmod -R 775 storage -> memberikan akses media penyimpanan

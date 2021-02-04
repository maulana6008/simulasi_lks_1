#Task 15

#requirement
1. Composer versi terbaru
2. Xampp support PHP 7++

#Langkah Untuk Menjalankan Laravel
1. Silahkan download terlebih dahulu REST API laravelnya
2. Buka folder laravelnya dengan terminal
3. pada terminal ketik : composer install
4. buat file .env
5. copy isi dari .env.example dan paste ke .env
6. ubah DB_DATABASE, DB_USERNAME dan DB_PASSWORD sesuai informasi database Anda
7. pada terminal ketik : 
	* > php artisan key:generate
	* > php artisan migrate
	* > php artisan serve


* Untuk mengakses APInya tentu saja Anda harus melakukan login terlebih dahulu jika belum memiliki akun
anda bisa melakukan daftar akun terlebih dahulu.
	* untuk user pegawai, hanya bisa di buat oleh admin
	* untuk user customer, Anda bisa melakukan daftar akun di endpoint /daftar
* setelah itu Anda login terlebih dahulu dengan akun yang telah di buat melalui endpoint /login

Nah, kalau Anda sudah login Anda baru bisa mengakses API, 
Akan saya jelaskan Endpoint API berikut :
* /login dan /daftar anda butuh headers
	* > Content-Type : application/json
	* > X-Requested-With : XMLHttpRequest

* selain endpoint /login dan /daftar anda butuh headers
> Authorization : Bearer tokenAnda
	* token akan anda peroleh saat anda login

* /logout, method get
	* untuk melakukan logout

* /users, method get
	* mengambil data user akun sesuai session/akun yang sudah berhasil login, entah itu admin, pegawai, atau customer

* /pegawai (hanya bisa di akses oleh admin), method get
	* mengambil semua data user pegawai

* /pegawai (hanya bisa di akses oleh admin), method post
	* menambah data user pegawai

* /pegawai/{id}  (hanya bisa di akses oleh admin), method put
	* mengedit data user pegawai sesuai id yang ada pada {id}

* /pegawai/{id}  (hanya bisa di akses oleh admin), method delete
	* delete data user pegawai sesuai id yang ada pada {id}

* /jenisbensin, method get
	* mengambil data jenis bensin

* /jenisbensin (hanya bisa di akses oleh admin), method post
	* menambahkan data jenis bensin

* /jenisbensin/{id} (hanya bisa di akses oleh admin), method put
	* mengedit data jenis bensin berdasarkan {id}

* /jenisbensin/{id} (hanya bisa di akses oleh admin), method delete
	* delete mengedit data jenis bensin berdasarkan {id}


* /provent, method get
	* mengambil data jenis bensin

* /provent (hanya bisa di akses oleh admin), method post
	* menambahkan data promo atau event bensin

* /provent/{id} (hanya bisa di akses oleh admin), method put
	* mengedit data promo atau event berdasarkan {id}

* /provent/{id} (hanya bisa di akses oleh admin), method delete
	* delete mengedit data promo atau event berdasarkan {id}

* /scan/{id} (hanya bisa di akses oleh pegawai), method post
	* menambahkan data aktifitas customer pembelian bensin 
	* menampilkan data jenis,liter,nama,dan status untuk di validasi pengisian bensin (pegawai melihat jenis liter dan jenis bensin)

* /edit/{id}, method put
	* untuk edit semua data pengguna berdasarkan id login atau {id} (admin, pegawai, atau customer)

* /beli/{user_id}, method post
	* customer membeli bensin
	* mengecek saldo customer apakah cukup untuk membeli bensin tersebut
	* menambahkan data aktifitas beli bensin customer

* /topup/{user_id}, method post
	* customer top up
	* menambahkan data aktifitas dan transaksi top customer

* /topup/cek/{user_id}, method get
	* melakukan cek apakah customer sudah melakukan pembayaran invoice

* /aktifitas, method get
	* menampilkan semua data aktifitas customer

* /aktifitas/customer/{id}, method get
	* menampilkan data aktifitas customer berdasarkan {id}

* /aktifitas/pegawai/{id}, method get
	* menampilkan data aktifitas pegawai berdasarkan {id}

* /saldo/{id_user}, method get
	* menampilkan saldo user berdasarkan {id_user}

* /promo, method get
	* menampilkan data promo

* /event, method get
	* menampilkan data event

* /transaksi/customer/{id_user}, method get
	* menampilkan status top up apakah masih pending,terbayar,maupun expired dan juga menampilkan details topupnya juga berdasarkan {id_user}

* /qrcode/{id_jenisbensin}, method get
	* mengembalikan object status : success apabila bensin yang di maksud ({id_jenisbensin} ) lebih dari 1







Referensi :
1. https://medium.com/modulr/create-api-rest-with-laravel-7-passport-authentication-part-1-a8198e5d0a9
2. https://stackoverflow.com/questions/55168808/passport-laravel-createtoken-personal-access-client-not-found
3. https://laravel.com/docs/7.x/
4. https://www.petanikode.com/markdown-pemula/

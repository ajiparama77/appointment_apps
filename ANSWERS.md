1. Untuk mengatasi timezone conflict khusus nya appointment harus berada dalam   rentang jam kerja pukul 09:00 - 17:00
     Dapat membuat fungsi validasi setiap appointment akan dibuat, berikut langkah” nya
      * Setiap input jam kerja dalam pembuatan appointment kita set terlebih dahulu 		  timezone nya berdasarkan timezone creator appointment ( Asia / Jakarta ) atau 	 (Pacific/Auckland )
     * Nilai input an waktu berdasarkan timezone creator, kita convert timezone nya menjadi format UTC     
     
  
*  Nilai datetime yang sudah diconvert menjadi UTC, kita clone nilai nya..dan buat variabel baru untuk set timezone berdasarkan semua user participant yang akan kita undang dalam appointment  
* Nilai datetime sesuai preffered timezone masing-masing participant sudah bisa didapatkan, dilanjutkan pengecekan, apakah waktu yang didapat berada dalam range pukul 09:00 - 17:00, jika sebelum rentang tersebut dan melebihi, maka create appointment gagal, dan sebaliknya jika dalam batas waktu maka create appointment berhasil


2.  Database Optimization
       Untuk mengoptimalkan query database saat mengmabil user spesific appointment, 	dapat saya lakukan beberapa hal
	* Dalam query saya tambahkan kondisi where berdasarkan creator id atau 	 	   participant id mengacu kepada uuid user yang sedang logged in
	* Hanya ambil kolom yang diperlukan untuk tampilkan list appointment
	    Di halaman list awal, saya hanya ambil kolom yang penting yaitu nilai host 	 	    (creator), status dan judul appointment. Waktu appointment berdasarkan 	  	    timezone participant, informasi participant saya buat query terpisah   
    dalam fungsi baru, 	sebagai detail appointment
		
3.    Penambahan fitur
   	  Penambahan fitur dalam aplikasi ini, yaitu pemilihan jenis appointment,notifikasi,reminder dan approval appointment
	 Jenis appointment dibagi menjadi daring & tatap muka. Jika tatap muka, maka setiap appointment perlu adanya reservasi ruangan terlebih dahulu, juga dilakukan validasi pengecekan apakah ruangan yang dipilih tersedia atau tidak dalam range waktu yang diinput.
	 Tambahan fitur lainnya yaitu reminder dan notifikasi. Fitur ini bertujuan untuk mengirimkan informasi appointment yang akan datang dalam beberapa jam kedepan, kepada participant. Informasi appointment bisa dikirim melalui notifikasi di aplikasi, notfikasi pada whatsapp dan email.  
	  Point terakhir, approval appointmet untuk masing-masing participant memberikan  follow up apakah bisa hadir atau tidak. Host approval juga bisa memberikan follow up terhadap status appointment nya, apakah appointment jadi dilaksanakan atau batal

4. Untuk mengatur session dan mencegah JWT payload secara besar, yaitu kita bisa mengatur durasi access token setiap user yang logged in. Durasi access token dapat kita atur dengan menginisialisasi class jwt pada config, lalu definisikan nilai TTL, sebagai contoh durasi token selama 60 menit. Sebaiknya durasi token yang tidak terlalu lama (short lived)
Apabila dalam suatu pengaksesan aplikasi , user sudah melebihi 60 menit, maka kita 	hapus 	session nya dengan meremove token dari localstorage dan auto logout user 	dari aplikasi.
Data transaksi yang besar tidak kita simpan dalam token, melainkan kita akses data 	transaksi melalui proses backend berdasarkan nilai user yang disimpan dalam JWT
         
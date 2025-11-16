1.Untuk mengatasi timezone conflict khusus nya appointment harus berada dalam rentang jam kerja pukul 09:00 - 17:00
     Dapat membuat fungsi validasi setiap appointment akan dibuat, berikut langkah” nya
      * Setiap input jam kerja dalam pembuatan appointment kita set terlebih dahulu 		  timezone nya berdasarkan timezone creator appointment ( Asia / Jakarta ) atau 	 (Pacific/Auckland )
     * Nilai input an waktu berdasarkan timezone creator, kita convert timezone nya menjadi format UTC     
     
  
    *  Nilai datetime yang sudah diconvert menjadi UTC, kita clone nilai nya..dan buat variabel baru untuk set timezone berdasarkan semua user participant yang akan kita undang dalam appointment  

    * Nilai datetime sesuai preffered timezone masing-masing participant sudah bisa didapatkan, dilanjutkan pengecekan, apakah waktu yang didapat berada dalam range pukul 09:00 - 17:00, jika sebelum rentang tersebut dan melebihi, maka create appointment gagal, dan sebaliknya jika dalam batas waktu maka create appointment berhasil



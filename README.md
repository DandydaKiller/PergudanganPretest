<b> Aplikasi Sederhana Pergudangan </b>

<p> Aplikasi ini tidak memiliki tampilan front end (Restful API), maka diharapkan untuk memiliki Postman dalam menguji aplikasi ini<p>
  
  <p> Berikut Routes yang digunakan untuk menjalakan aplikasi tersebut : <br>
    1. /login (Parameter : email, password - dengan validasi email '@' dan password 8 character) POST <br>
    2. /register (Parameter : email, nama, conf_password, password - dengan validasi email '@' dan password 8 character) POST <br>
    3. /Tambah (Parameter: namaBarang, idGudang, deskripsiBarang, id_user, tanggal_barang)POST <br>
    4. /Edit/(id barang) GET <br>
    5. /Hapus/(id barang) GET <br>

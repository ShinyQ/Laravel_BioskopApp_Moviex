<h1>&#x1f516; Moviex, Laravel Order Ticket App &#x1f516;</h1>

<b>Deskripsi :</b> Moviex Merupakan Sebuah Web App yang dibuat menggunakan framework laravel untuk melakukan pesanan tiket bioskop, Moviex juga menyediakan Fitur Api Untuk CRUD Komponen Didalamnya

<h3> <b> Application Highlight :</b> </h3>

<img src="https://gitlab.com/dot-academy-batch-1/challange-2-moviex-kurniadi/raw/master/ss/C1.PNG"
height="450px" width="1000px">

<img src="https://gitlab.com/dot-academy-batch-1/challange-2-moviex-kurniadi/raw/master/ss/C2.PNG"
height="450px" width="1000px">


<b>Fitur - Ditur Aplikasi :</b>

* Login, Register dan Logout
* CRUD Pengguna 
* CRUD Studio Bioskop
* CRUD Film
* CRUD Order Tiket
* Integrasi API Login, Register, Logout
* Integrasi API Pengguna, Film, Dan Order Tiket

<b>API Integration :</b>

Authentication : 
* Registrasi : `{{url}}/api/register`, Params : name, email, phone, role, password, password_confirmation.
* Login : `{{url}}/api/login`, Params : email, password.
* Logout : `{{url}}/api/logout`.

*Note : <b>`Anda Harus Melakukan Set Header Untuk Menggunakan Fitur Berikut`</b>

Headers :
* Accept : application/json
* Authorization : Bearer {{token}}

Genre :
* Get Genre :  `{{url}}/api/v1/genre'
* Get Detail Genre : `{{url}}/api/v1/genre/{id}'
* Post Genre : '{{url}}/api/v1/genre' , Params : name.
* Update Genre : `{{url}}/api/v1/genre/{id}` , Params : name
* Delete Genre : `{{url}}/api/v1/genre/{id}`

Film :
* Get Film :  `{{url}}/api/v1/film'
* Get Detail Film : `{{url}}/api/v1/film/{id}'
* Post Film : '{{url}}/api/v1/genre' , Params : name, deskripsi, genre_id, studio_id, start_at, end_at.

Order :
* Get Genre :  `{{url}}/api/v1/order'
* Get Detail Genre : `{{url}}/api/v1/order/{id}'
* Post Order : '{{url}}/api/v1/order` , Params : user_id, film_id, qty.
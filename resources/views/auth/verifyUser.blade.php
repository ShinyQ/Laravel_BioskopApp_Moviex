<!DOCTYPE html>
<html>
  <head>
      <title>Welcome Email</title>
  </head>

  <body>
    <h2>Hello, {{$user['name']}}</h2>
    <br/>
    Alamat Email Kamu : {{$user['email']}}, Telah Berhasil Diregistrasi, Klik Link Dibawah Untuk Konfirmasi 
    <br/>
    <a href="{{url('user/verify', $user->token)}}">Verify Email</a>
  </body>

</html>

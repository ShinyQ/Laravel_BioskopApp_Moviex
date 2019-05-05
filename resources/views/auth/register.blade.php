<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Halaman Registrasi Akun</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>
<!-- ============================================================== -->
<!-- signup form  -->
<!-- ============================================================== -->

<body>
    <!-- ============================================================== -->
    <!-- signup form  -->
    <!-- ============================================================== -->
    <form class="splash-container" action="/register1" method="POST">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-1">Form Registrasi</h3>
                <p>Masukkan Data Anda</p>
            </div>
              <div class="card-body">
                  <div class="form-group">
                      <input class="form-control form-control-lg" type="text" name="name" required="" placeholder="Nama" autocomplete="off">
                  </div>
                  <div class="form-group">
                      <input class="form-control form-control-lg" type="email" name="email" required="" placeholder="E-mail" autocomplete="off">
                  </div>
                  <div class="form-group">
                      <input class="form-control form-control-lg" type="number" name="phone" required="" placeholder="Phone">
                  </div>
                  <div class="form-group">
                      <input class="form-control form-control-lg" name="password" type="password" required="" placeholder="Password">
                  </div>
                  @csrf
                  <div class="form-group pt-2">
                      <input class="btn btn-block btn-primary" type="submit" value="Registrasi Akun">
                  </div>

              </div>
              <div class="card-footer bg-white">
                  <p>Sudah Punya Akun ? <a href="/login" class="text-secondary">Login Disini</a></p>
              </div>
        </div>
    </form>
</body>


</html>

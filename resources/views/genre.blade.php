@extends('base/template')

@section('konten')

  <div class="row">
    <div class="col-md-6">
      <div class="card">
         <div class="card-body">
           <form>
             <div class="form-group">
                <label for="inputText3" class="col-form-label">Nama Genres</label>
                <input id="inputText3" type="text" class="form-control">
            </div>
              <button type="submit" class="btn btn-primary">Tambah Genre</button>
           </form>
         </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
         <div class="card-body">
           <label for="inputText3" class="col-form-label">List Genre Film</label>
               <table class="table table-striped">
                 <thead>
                     <tr>
                         <th scope="col">No</th>
                         <th scope="col">Nama Genre</th>
                         <th scope="col">Aksi</th
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <th scope="row">1</th>
                         <td>Mark</td>
                         <td>
                            <a class="btn btn-warning" style="color:white!important" href="#"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-danger" href="#"><i class="fa fa-trash"></i></a>
                           </td>
                     </tr>
                     <tr>
                         <th scope="row">2</th>
                         <td>Jacob</td>
                         <td>Thornton</td>

                     </tr>
                     <tr>
                         <th scope="row">3</th>
                         <td>Larry</td>
                         <td>the Bird</td>

                     </tr>
                 </tbody>
             </table>
            </div>
         </div>
    </div>
  </div>

@endsection

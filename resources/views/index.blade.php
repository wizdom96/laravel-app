<!doctype html>
<html>
  <head>
    <title>Import CSV Data to MySQL database with Laravel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
     <!-- Message -->
     @if(count($users) == 0)
     @if(Session::has('message'))
        <p >{{ Session::get('message') }}</p>
     @endif
      
     <div class="container" style="width:600px;height:auto;padding-top:50px">
        <h3>Please upload the data(csv).</h3>
        <br>
        <form method='post' action='/uploadFile' enctype='multipart/form-data' >
       {{ csrf_field() }}
       <input type='file' name='file' >
       <input type='submit' name='submit' value='Import'>
     </form>

  </div>

</div>
     @else
     
     <div class="container" style="width:600px;height:auto">
     <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col"  style="padding-left:80px">User</th>
      <th scope="col">Info  </th>
    </tr>
  </thead>
  <tbody>
  @foreach ($users as $user)
    <tr>

      <td style="padding-left:50px">{{$user->user}}</td>
      <td><a href="details/{{$user->user}}" class="btn-primary btn-lg" >View</a></h4>
</td>
    </tr>
    @endforeach
 </table>
     
 @endif
  </body>

</html>


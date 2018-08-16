@extends('admin.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Control</div>
                <div class="panel-body"> 

                  <div class="bs-example" data-example-id="panel-without-body-with-table">
                    <div class="panel panel-default">
                      <div class="panel-heading">Panel heading</div>

                      <table class="table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>E-mail</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($admins as $admin)
                          <tr>
                            <th scope="row">{{ $admin->id}}</th>
                            <td><input name="name" type="text" value="{{ $admin->name}}"></td>
                            <td><input name="email" type="text" value="{{ $admin->email}}"></td>
                          </tr>
                        @endforeach
                        <form method="POST" action="{{ route('postAdminregister') }}">
                            @csrf
                          <tr>
                            <th scope="row"></th>
                            <td><input name="name" type="text" placeholder="Enter new admin name" class=""></td>
                            <td><input name="email" type="email" placeholder="Enter new admin email" class=""></td>
                            <td><input name="password" type="password" placeholder="Enter password" class=""></td>
                            <td><button type="submit" class="btn btn-primary">Create</button></td>
                          </tr>
                        </form>
                        </tbody>
                      </table>
                    </div> 
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
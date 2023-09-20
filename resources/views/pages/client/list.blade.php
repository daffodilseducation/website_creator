@extends('layouts.app')

@section('content')


 <?php $i = 1;?>
    <div class="pageWrapper">
      <div class="container">
        <div class="headingtitle">
          <h3>Client User</h3>
          <a class="button" href="createUser"><span>Create User</span></a>
        </div>
    
  <div class="pageContent">
    <table>
     <tr>
      <th>Sr No.</th>
      <th>Name</th>
      <th>Email</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
      @foreach($ClientUser as $ClientUserVal)
    <tr>
      <td>{{$i++}}</th>
      <td>{{$ClientUserVal->name}}</td>
      <td>{{$ClientUserVal->email}}</td>
      <td>{{$ClientUserVal->status}}</td>
      <td class="actions"><a href="user/edit/{{$ClientUserVal->id}}"><i class="fa fa-pencil"></i>Edit</a></td>
    </tr>
    @endforeach
  </table>
</div>
  </div>
</div>

@endsection
@extends('layouts.app')

@section('content')


 <?php $i = 1;?>
 <div class="pageWrapper">
  <div class="container">  
    <div class="headingtitle"> 
      <h3>Client User</h3>
      <a class="button" href="{{ url('/bulkUpload')}}"><span><i class="fa fa-upload"></i>Bulk Upload</span></a>
   </div> 
  <div class="pageContent"> 
  <table>
     <tr>
      <th>Sr No.</th>
      <th>Name</th>
      <th>Email</th>
    </tr>
      @foreach($ClientUser as $ClientUserVal)
    <tr>
      <td>{{$i++}}</td>
      <td>{{$ClientUserVal->name}}</td>
      <td>{{$ClientUserVal->email}}</td>
    </tr>
    @endforeach
  </table>
</div>
</div>
@endsection

@extends('layouts.app')

@section('content')

<div class="pageWrapper">
  <div class="container">
        <div class="headingtitle">
          <h3>Edit User</h3>
          <a href="javascript:void(0);" onclick="window.history.go(-1); return false;" class="default-btn"><i class="fa fa-chevron-left"></i>Back</a>
        </div>
    <div class="pageContent">
      <form action="/updateUser" method="post">
      @csrf
        <input type="hidden" name="user_id" id="secret" value="{{$ClientUser->id}}">
        <label for="name">Enter User Name</label>
        <input type="text" name="user_name" placeholder="Enter Name.." value="{{$ClientUser->name}}">
        <label for="email">Enter User Email</label>
        <input type="text"  name="user_email" placeholder="Enter Email.." value="{{$ClientUser->email}}">
        <label for="password">Enter User Password</label>
        <input type="text"  name="user_password" placeholder="Enter Password.." value="">
        <label for="password">Status</label>
        <select id="nf-status" name="status" class="form-control" >
            <option value="active" @if($ClientUser->status == 'active') selected=selected @endif>Active</option>
            <option value="inactive" @if($ClientUser->status == 'inactive') selected=selected @endif>InActive</option>
        </select>

        
        
    <!--    <label for="lname">Enter Decryption key  </label>
        <input type="text" id="decryption_key" name="decryption_key" placeholder="Enter Decryption key..">-->

        
        <input type="submit" value="Submit">
      </form>

    </div>
  </div>
</div>      

@endsection
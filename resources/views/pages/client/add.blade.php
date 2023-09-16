@extends('layouts.app')

@section('content')
<div class="pageWrapper">
  <div class="container">
        <div class="headingtitle">
          <h3>Add User</h3>
          <a href="javascript:void(0);" onclick="window.history.go(-1); return false;" class="default-btn"><i class="fa fa-chevron-left"></i>Back</a>
        </div>
    <div class="pageContent">
      <form action="/createPostUser" method="post">
      @csrf
    <label for="name">Enter Name</label>
    <input type="text" name="name" placeholder="Enter Name.." value="">
    <label for="email">Enter Email</label>
    <input type="text"  name="email" placeholder="Enter Email.." value="">
    <label for="password">Enter Password</label>
    <input type="password"  name="password" placeholder="Enter Password.." value="">
    <label for="password">Status</label>
    <select id="nf-status" name="status" class="form-control" >
        <option value="active">Active</option>
        <option value="inactive">InActive</option>
    </select>

    
    
<!--    <label for="lname">Enter Decryption key  </label>
    <input type="text" id="decryption_key" name="decryption_key" placeholder="Enter Decryption key..">-->

    
    <input type="submit" value="Submit">
  </form>

    </div>
  </div>
</div>      

@endsection

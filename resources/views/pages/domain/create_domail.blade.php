@extends('layouts.app')

@section('content')
<div class="pageWrapper">
  <div class="container">
    <div class="headingtitle">
      <h3>Domain Form</h3>
      <a href="javascript:void(0);" onclick="window.history.go(-1); return false;" class="default-btn"><i class="fa fa-chevron-left"></i>Back</a>
    </div>
   <div class="pageContent"> 
    <form action="/createDomain" method="post">
        @csrf
      <input type="hidden" name="user_id" id="secret" value="<?php echo $userId;?>">
      <label for="fname">Enter Domain</label>
      <input type="text" id="domain" name="domain" placeholder="Enter Domain..">

      <label for="lname">Enter Login Redirect Url </label>
      <input type="text" id="login_redirect_url" name="login_redirect_url" placeholder="Enter Login Redirect Url..">
      
      <label for="lname">Enter Logout Redirect Url  </label>
      <input type="text" id="logout_redirect_url" name="logout_redirect_url" placeholder="Enter Logout Redirect Url..">
      
      <label for="password">Status</label>
      <select id="nf-status" name="status" class="form-control" >
          <option value="active">Active</option>
          <option value="inactive">InActive</option>
      </select>

      
      <input type="submit" value="Submit">
    </form>
  </div>
</div>
</div>
@endsection

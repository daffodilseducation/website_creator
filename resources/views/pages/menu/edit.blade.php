@extends('layouts.app')

@section('content')
<div class="pageWrapper">
  <div class="container">
    <div class="headingtitle">
      <h3>Edit User</h3>
      <a href="javascript:void(0);" onclick="window.history.go(-1); return false;" class="default-btn"><i class="fa fa-chevron-left"></i>Back</a>
    </div>
  


<div class="pageContent">
  <form action="/updateDomain" method="post">
      @csrf
    <input type="hidden" name="domain_id" id="secret" value="<?php echo $ClientDomain->id;?>">
    <label for="fname">Enter Domain</label>
    <input type="text" id="domain" name="domain" placeholder="Enter Domain.." value="{{$ClientDomain->domain}}">

    <label for="lname">Enter Login Redirect Url </label>
    <input type="text" id="login_redirect_url" name="login_redirect_url" placeholder="Enter Login Redirect Url.." value="{{$ClientDomain->login_redirect_url}}">
    
    <label for="lname">Enter Logout Redirect Url  </label>
    <input type="text" id="logout_redirect_url" name="logout_redirect_url" placeholder="Enter Logout Redirect Url.." value="{{$ClientDomain->logout_redirect_url}}">
    
    <label for="password">Status</label>
    <select id="nf-status" name="status" class="form-control" >
        <option value="active" @if($ClientDomain->status == 'active') selected=selected @endif>Active</option>
        <option value="inactive" @if($ClientDomain->status == 'inactive') selected=selected @endif>InActive</option>
    </select>

    
    <input type="submit" value="Submit">
  </form>
    
</div>
 </div>
</div> 
@endsection

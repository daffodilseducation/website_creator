@extends('layouts.app')

@section('content')
<div class="pageWrapper">
  <div class="container">
    <div class="headingtitle">
      <h3>Menu Form</h3>
      <a href="javascript:void(0);" onclick="window.history.go(-1); return false;" class="default-btn"><i class="fa fa-chevron-left"></i>Back</a>
    </div>
   <div class="pageContent"> 
    <form action="/createMenu" method="post" enctype="multipart/form-data">
        @csrf
      <input type="hidden" name="user_id" id="secret" value="<?php echo $userId;?>">
      <input type="hidden" name="parent_id" id="" value="<?php echo $parent_id;?>">
      <label for="fname">Enter Label</label>
      <input type="text" id="" name="label" placeholder="Enter Label..">

      <label for="lname">Enter Slug </label>
      <input type="text" id="" name="slug" placeholder="Enter Slug..">
      
      <label for="lname">Enter Order </label>
      <input type="text" id="" name="order" placeholder="Enter Order..">
      
      <label for="lname">Icon  </label> <br>
      <input type="file" id="" name="icon"> <br>
      
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

@extends('layouts.app')

@section('content')
<div class="pageWrapper">
  <div class="container">
    <div class="headingtitle">
      <h3>Edit User</h3>
      <a href="javascript:void(0);" onclick="window.history.go(-1); return false;" class="default-btn"><i class="fa fa-chevron-left"></i>Back</a>
    </div>
  


<div class="pageContent">
  <form action="/updateMenu" method="post" enctype="multipart/form-data">
      @csrf
    <input type="hidden" name="id" id="secret" value="<?php echo $MenuData->id;?>">
      <label for="fname">Enter Label</label>
      <input type="text" id="" name="label" placeholder="Enter Label.." value="<?php echo $MenuData->label;?>">

      <label for="lname">Enter Slug </label>
      <input type="text" id="" name="slug" placeholder="Enter Slug.." value="<?php echo $MenuData->slug;?>">
      
      <label for="lname">Enter Order </label>
      <input type="text" id="" name="order" placeholder="Enter Order.." value="<?php echo $MenuData->order_no;?>">
      
      <label for="lname">Icon  </label> <br>
      <input type="file" id="" name="icon"> <br>
    <label for="password">Status</label>
    <select id="nf-status" name="status" class="form-control" >
        <option value="active" @if($MenuData->status == 'active') selected=selected @endif>Active</option>
        <option value="inactive" @if($MenuData->status == 'inactive') selected=selected @endif>InActive</option>
    </select>

    
    <input type="submit" value="Submit">
  </form>
    
</div>
 </div>
</div> 
@endsection

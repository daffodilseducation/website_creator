<?php

?>

<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-md-8 col-lg-8">
      <!-- TOP CAMPAIGN-->
      <div class="top-campaign">
        <h3 class="title-3 m-b-30">User Profile</h3>
        <div class="table-responsive">
          <table class="table table-top-campaign">
            <tbody>
            <tr>
              <td>Name : </td>
              <td>{{$user->name}}</td>
            </tr>
            
            <tr>
              <td>Email : </td>
              <td>{{$user->email}}</td>
            </tr>
            
            </tbody>
          </table>
        </div>
      </div>
      <!-- END TOP CAMPAIGN-->
    </div>
  </div>
<div style="text-align: center;">
<a id="logout" class="button" href="logout">Logout</a>
</div>


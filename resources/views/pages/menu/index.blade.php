@extends('layouts.app')

@section('content')

 <?php $i = 1;?>
<div class="pageWrapper">
  <div class="container">
    <div class="headingtitle">
      <h3>Domain</h3>
      <div style="text-align:right;">
          <a id="logout" class="button" href="createMenu"><span>Create Menu</span></a>
      </div>
    </div>
    <div class="pageContent"> 
        <table>
           <tr>
            <th>Sr No.</th>
            <th>Domain</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
            @foreach($ClientDomain as $ClientDomainVal)
          <tr>
            <td>{{$i++}}</td>
            <td><a href="domainDetails/{{$ClientDomainVal->id}}">{{$ClientDomainVal->domain}}</a></td>
            <!--<td>{{$ClientDomainVal->created_at}}</td>-->
            <td><?php $old_date_timestamp = strtotime($ClientDomainVal->created_at); echo date('Y-M-d H:i:s', $old_date_timestamp); ?></td>
            <td>{{$ClientDomainVal->status}}</td>
            <td class="actions"><a href="domain/edit/{{$ClientDomainVal->id}}"><i class="fa fa-pencil"></i>Edit</a></td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
</div>
@endsection
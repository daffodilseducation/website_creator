@extends('layouts.app')

@section('content')

 <?php $i = 1;?>
<div class="pageWrapper">
  <div class="container">
    <div class="headingtitle">
      <h3>Domain</h3>
      <div style="text-align:right;">
          <a id="logout" class="button" href="/createMenu"><span>Create Menu</span></a>
      </div>
    </div>
    <div class="pageContent"> 
        <table>
           <tr>
            <th>Sr No.</th>
             <th>Id.</th>
            <th>Label</th>
            <th>Slug</th>
            <th>Order</th>
            <th>Date</th>
            <th>Parent</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
            @foreach($MenuData as $MenuVal)
          <tr>
            <td>{{$i++}}</td>
            <td>{{$MenuVal->id}}</td>
            <td><a href="domainDetails/{{$MenuVal->id}}">{{$MenuVal->label}}</a></td>
              <td>{{$MenuVal->slug}}</td>
              <td>{{$MenuVal->order_no}}</td>
            <td><?php $old_date_timestamp = strtotime($MenuVal->created_at); echo date('Y-M-d H:i:s', $old_date_timestamp); ?></td>
            <td>{{$MenuVal->parent_id}}</td>
            <td>{{$MenuVal->status}}</td>
            <td class="actions">
                <a href="/menus/edit/{{$MenuVal->id}}"><i class="fa fa-pencil"></i>Edit</a>
                  <form action="{{ route('menus.destroy', $MenuVal->id)}}" method="post"
                    class="DeleteKpiLink" id="{{$MenuVal->id}}">
                    @csrf
                    @method('DELETE')
                    <button class="item" title="Delete" type="submit">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </form>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
</div>
@endsection
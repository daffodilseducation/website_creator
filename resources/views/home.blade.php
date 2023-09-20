@extends('layouts.app')

@section('content')
<div class="pageWrapper">
      <div class="container">  
        <div class="headingtitle"> 
          <h3>Dashboard</h3>
       </div> 
      <div class="pageContent"> 
         @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

       @include('pages.chart')
      </div>
    </div>
</div>    

@endsection

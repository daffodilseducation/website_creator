@extends('layouts.app')

@section('content')
<!DOCTYPE html>
    <div class="pageWrapper">
      <div class="container">  
        <div class="headingtitle"> 
          <h3>Bulk Upload</h3>
          <a href="javascript:void(0);" onclick="window.history.go(-1); return false;" class="default-btn"><i class="fa fa-chevron-left"></i>Back</a>
       </div> 
      <div class="pageContent"> 
        <div class="formwrapper">
            <div class="formblock">
                <form action="/import_sheet" method="post" enctype="multipart/form-data">
                    @csrf
                    <label>Upload file *</label>
                    <input type="file" name="file"/>
                    <input type="submit" value="Submit">
                </form>
                <div>
                    @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                    @endif
                    @if(session()->get('error'))
                    <div class="alert alert-error" style="color: #ea0504;background-color: #d4edda;border-color: #c3e6cb">
                        {!! session()->get('error') !!}
                    </div>
                    @endif
                </div>
              </div>
              <a href="{{ url('/downloadSample')}}"><i class="fa fa-download"></i>Dowload Sample file</a>  
          </div>
           
        </div>
    </div>
</div>
  
@endsection

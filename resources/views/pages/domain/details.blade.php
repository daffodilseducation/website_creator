@extends('layouts.app')

@section('content')

<div class="pageWrapper">
  <div class="container">
        <div class="headingtitle">
          <h3>Domain Details</h3>
          <a href="javascript:void(0);" onclick="window.history.go(-1); return false;" class="default-btn"><i class="fa fa-chevron-left"></i>Back</a>
        </div>
    <div class="pageContent">
        <ol>
            <li><span>Domain</span><div><span>{{$ClientDomain->domain}}</span></div></li>
            <li><span>Domain Secret Key</span><div><span><input type="text" value="{{$ClientDomain->secret_key}}"/></span> <button onclick="copyToClipboardSecretKey('#secret_key')">Copy</button><span id="secret_key" style="display: none;">{{$ClientDomain->secret_key}}</span></div></li>
            <li><span>Login Redirect Url</span>{{$ClientDomain->login_redirect_url}}</li>
            <li><span>Logout Redirect Url</span>{{$ClientDomain->logout_redirect_url}}</li>
            <li><span>Decryption key</span><div><span><input type="text" value="{{$ClientDomain->decryption_key}}"/></span><button onclick="copyToClipboardDecryptionKey('#decryption_key')">Copy</button><span id="decryption_key" style="display: none;">{{$ClientDomain->decryption_key}}</span></div></li>
        </ol>
    </div>
     </div>    
</div>
@endsection
<script>
    function copyToClipboardSecretKey(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }

    function copyToClipboardDecryptionKey(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>
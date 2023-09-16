<!doctype html>
<html>
<head>
  <meta charset="UTF-8"/>

  <title>LO2 SSO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>


<header>
  <div class="header-container">
    <div class="logo"><img src="{{ asset('/images/logo/lo2_logo.jpg')}}"></div>
    <div class="header-actions">
      <ul>
        <li><a href="javascript:void(0);">For Enterprises</a></li>
        <li><a href="javascript:void(0);">About</a></li>
        <li><a href="{{url('/login')}}" class="btn">Login</a></li>
      </ul>
    </div>
  </div>
</header>

</body>
</html>	

<style>
  header{box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);  display: flex; justify-content: space-between; padding: .5rem 1rem; width: 100%; box-sizing: border-box;}
  header .header-container{max-width: 1140px; margin: 0 auto; width: 100%; display: flex; justify-content: space-between; align-items: center; font-family: arial;}
 header .header-container .header-actions{display:flex; align-items: center;}
 header .header-container .header-actions ul{margin: 0; padding: 0; display: flex;}
 header .header-container .header-actions ul li{margin: 0; padding: 0; display: flex;}
 header .header-container .header-actions ul li a{margin-left: 35px; color: #3490dc; text-decoration: none;}
  header .header-container .header-actions ul li a:hover{text-decoration: underline;}
</style> 
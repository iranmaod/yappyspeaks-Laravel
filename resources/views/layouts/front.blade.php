<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
    <meta name="title" content="@yield('meta_title','Test Title')">
    <meta name="description" content="@yield('meta_description','Test Description')">
    
    <script src="https://use.fontawesome.com/5430ef00bc.js"></script>
    <link href="{{ URL::asset('/assets/css/front/style.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title> @yield('title') </title>
    @yield('css')
</head>
<body>
    @yield('content')

<script>
function shareLink() {
    
    navigator.share({
        title: document.title,
        text: document.title,
        url: window.location.href
    })
    .then(() => console.log('Successful share'))
    .catch(error => console.log('Error sharing:', error));

}
</script>
</body>
</html>
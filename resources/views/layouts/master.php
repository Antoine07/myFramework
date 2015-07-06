{{$header}}
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<div class="header-container">
    <header class="wrapper clearfix">
        <h1 class="title"><a href="{{url('/')}}">{{$title}}</a></h1>
        {{$menu}}
    </header>
</div>
{{$content}}
<!-- #main -->
</div> <!-- #main-container -->
<div class="footer-container">
    <footer class="wrapper">
        <h3>footer</h3>
    </footer>
</div>
{{$footer}}
</body>
</html>
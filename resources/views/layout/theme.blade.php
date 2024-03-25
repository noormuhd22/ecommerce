<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="/default.css" rel="stylesheet" type="text/css" media="all" />
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<body>
<div id="header-wrapper">
	<div id="header" class="container">
		<div id="logo">
			<h1><a href="#">Nockup</a></h1>
		</div>

		<div id="menu">
			<ul>
				<li class="{{Request::path()==='/'?'current_page_item' : '' }}"><a href="/" accesskey="1" title="">Homepage</a></li>
				<li class="{{Request::path()==='menu'?'current_page_item' : '' }}"><a href="/menu" accesskey="2" title="">Menu</a></li>
				<li class="{{Request::path()==='about' ? 'current_page_item' : '' }}"><a href="/about" accesskey="3" title="">About Us</a></li>
				<li class="{{Request::path()==='career' ? 'current_page_item' : '' }}"><a href="/career" accesskey="4" title="">Careers</a></li>
				<li class="{{Request::path()==='contact' ? 'current_page_item' : '' }}"><a href="/contact" accesskey="5" title="">Contact Us</a></li>
			</ul>
		</div>
	</div>
	
	
</div>
<div id="wrapper">
	<div id="page" class="container">
		

		<div id="content">
			<div class="title">
				<h2>Welcome to our website</h2>
		</div>
		@yield("post")
		
			<div id="stwo-col">
				<div class="sbox1">
					
				
			</div>
		</div>
	</div>
</div>
<div id="copyright" class="container">
	<p>&copy; Untitled. All rights reserved. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
</div>
</body>
</html>

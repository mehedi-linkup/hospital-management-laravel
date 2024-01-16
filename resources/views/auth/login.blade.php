
<!DOCTYPE html>
<html>
<head>
	<title>{{companyProfile()->name}} || Login Page</title>
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/login.css')}}">
	<link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}">
	<style>
		.typed-cursor{
			color: #fff;
		}
	</style>
</head>
<body>

<div class="container">
	<div class="contant">
		<h2 class="headding"><span id="typed"></span></h2>
		<div class="login">
			<div class="left-cont">
				<div class="company-feature">
					<div class="com-image">
						<img src="{{asset('assets/img/no_image.png')}}" style="width: 100%;height: 125px; border-radius: 25px;padding-top: 5px;">
					</div>
					
				</div>
				<div class="company-info">
					<h4>{{companyProfile()->name}}</h4>
					<div class="com-add">
						<div class="com-profile">
							<strong>Address</strong> : {{companyProfile()->address}} <br>
						</div>
					</div>
				</div>
				<div class="develop_by"><strong style="font-size: 10px">Develop By </strong> <a href="http://linktechbd.com">Link-Up Technology Ltd.</a></div>
				<div class="corcel">
					<div class="round">
						<div class="inner-round">
							<div class="inner-logo"><!-- ERP --></div>
						</div>
					</div>
				</div>
				
			</div>
			<div class="right-cont">
				<div class="login-form">
					<div class="form">
						<h4>Sign In Form</h4>

						@foreach($errors->messages() as $error)
							<p style="color:red;">{{$error[0]}}</p>
						@endforeach
						<form method="post" action="{{ route('login') }}">
							@csrf
							<div class="form-group">
								<input type="text" name="username" class="form-control" value="{{old('email')}}" placeholder="User Name">
							</div>
							<div class="form-group">
								<input type="password" name="password" class="form-control" placeholder="Password">
							</div>
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-info btn-block" value="Login">
							</div>
						</form>
					</div>
				</div>
				
			</div>
			<div class="clr"></div>
		</div>
	</div>

</div>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/typed.js')}}"></script>
<script>
	$(function(){
		var typed = new Typed('#typed', {
			strings: ['Welcome to Hospital Management Software'],
			typeSpeed: 100,
			backSpeed: 100,
			loop: true
		});
	});
</script>
</body>
</html>
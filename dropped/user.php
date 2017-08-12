<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MarZa1357 is so happy</title>
  <link rel="stylesheet" href="animate.css">
  <link rel="stylesheet" href="design.css">
  <link rel="stylesheet" href="responsive.css">
  <style>
	  html{
		  background-color: #fafafa;
	  }
	  .caption:after {
		  content: 'IS SO HAPPY!!';
	  }	  
  </style>
</head>

<body>

	<nav class="row">
	  <ul>
	    <li style="width: 40px; margin: auto;">
		  <img src="./!design/someone.svg" style="border-radius: 50%;" width="30px" />
		</li>
		<li style="max-width: 300px; overflow: hidden;">
			<b class="printusr">username</b>
		</li>
		<li style="max-width: 300px; overflow: hidden;">
			<form>
				<input id="upload" class="icon" style="margin: 0 0 0 20px;" type="submit" value="" />
				<input id="signout" class="icon" style="margin: 0 0 0 20px;" type="submit" value="" />
			</form>
		</li>
	  </ul>
	</nav>
	
	<div id="cover" class="row">
		<div class="col-7 col-m-12" >
			<img src="./!design/someone.svg" width="100px" />
			<h2 style="margin: auto;">MarZa1357</h2>
		</div>
		<div class="col-5 col-m-12" >
		  <div style="text-align: left;">
			<ul style="display: block;">
				<li>Happy with 20 friends</li>
				<li>Studing IT @ KMITL</li>
				<li>Call me 0812345678</li>
			</ul>
		  </div>
		</div>
	</div>
	<div class="row" style="margin-top: 20px;">
  <?php for($i=0;$i<6;$i++){ $a = "'./img/usr/test/testimg.jpg'"; echo '
	  <div class="precard col-4 col-m-6" >
	  	<div class="card">
	  	   <div class="img" style="background-image: url('.$a.');background: cover center no-repeat;">
		    &nbsp;
		   </div>
		   <div class="text">
			   <b>MarZa1357</b><br />
			   Lorem ipsum dosit Lorem ipsum dosit de amit .
		   </div>
	  	</div>
	  </div>  
  ';} ?>
	</div>

</body>
</html>
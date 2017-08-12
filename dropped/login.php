<html>
<head>
  <title>I am so happy</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="animate.css">
  <link rel="stylesheet" href="design.css">
  <style>
	  html{
		  background: #FFDF40; /* For browsers that do not support gradients */
		  background: -webkit-linear-gradient(left top, #FFDF40, #FF8359 ); /* For Safari 5.1 to 6.0 */
		  background: -o-linear-gradient(bottom right, #FFDF40, #FF8359 ); /* For Opera 11.1 to 12.0 */
		  background: -moz-linear-gradient(bottom right, #FFDF40, #FF8359 ); /* For Firefox 3.6 to 15 */
		  background: linear-gradient(to bottom right, #FFDF40, #FF8359 ); /* Standard syntax */
	  }
  </style>
  <script>
	  function viewpassword(){
		  document.getElementsByName('pass').type = '';
	  }
  </script>
</head>
<body style="overflow: hidden;">
  <div class="container animated fadeIn" style="animation-delay: .5s;">
    <img src="/48/!design/logo.svg" style="width: 300px;" />
    <div id="login">
      <form class="animated fadeIn" style="animation-delay: .5s;">
        <br /><input onkeyup="logmein()" type="text"     name="user" placeholder="email" />
        <br /><input onkeyup="logmein()" type="password" name="pass" placeholder="password" />
        <br /><br /><input id="logmein" type="submit" value="Let's me in!" />
      </form>
    </div>
  </div>
</body>
</html>
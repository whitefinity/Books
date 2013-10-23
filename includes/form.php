</div></div>
<form class="reg" method="post" name="table">
<label for="username" id="user">Username
<input type="text" name="username" />
</label><br>
<label for="password" id="pass">Password  
<input type="password" name="password" /></label>
</label><br>
			<input type="submit" name="submit" <?php 
			if($title=="MB"){
				echo "value=\"Log in\"";
				}elseif($title=="Sign Up"){
				echo "value=\"Sign up\"";
				}else{
					echo "value=\"Submit\"";
				};?> id="enter"/>
</form>
		
	</body>
</html>
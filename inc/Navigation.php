<?php

$navigation = <<<END
<nav>
	<a href="login.php">Login</a>
</nav>
END;




if(!isset($_SESSION['userId'])){
	$adminHTML = <<<END
	
END;

}

echo $header;
echo $navigation;



?>
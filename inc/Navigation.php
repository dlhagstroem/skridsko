<?php

$navigation = <<<END
<nav>
	<a href="index.php">Start</a>
	<a href="login.php">Login</a>
</nav>
END;


$adminHTML = "";

if(!isset($_SESSION['userId'])){
	$adminHTML = <<<END
	
END;

}

echo $adminHTML;



?>
<?php
if (isset($_SESSION['error']))
{
	?>
	<div class="alert alert-danger" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	<span class="sr-only">Error:</span>
	<?php echo ($_SESSION['error']);?>
	</div>
	<?php 
	$_SESSION['error'] = null;
}

if (isset($_SESSION['succes']))
{
	?>
	<div class="alert alert-success" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	<span class="sr-only">Succes:</span>
	<?php echo ($_SESSION['succes']);?>
	</div>
	<?php 
	$_SESSION['succes'] = null;
}

if (isset($_GET['deco']))
{
	session_destroy();
	header('Location: index.php?redic=true');
}


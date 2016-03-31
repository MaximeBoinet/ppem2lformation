<?php
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">M2L Formation</a>
    </div>
	<div class="container-fluid">
		<?php if (isset($_SESSION['connecte'])){?>
			<p class="navbar-text navbar-right">Bienvenue <a href="?page=perso" class="navbar-link"><?php echo($_SESSION['name']." ".$_SESSION['fname'] )?></a>
			<a href="?deco=true" class="btn btn-reverse navbar-btn">Deconnection</a></p>
		<?php }?>
	</div>
</nav>
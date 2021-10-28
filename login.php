<?php
	session_start();
	require "require/connection.php";
	include "function.php";
	if(isset($_POST['login']))
	{
		$email = $_POST['email'];
		$password = $_POST['password'];
		$sql_login = "SELECT * FROM users WHERE email = :email AND encrypt_password =:password";
		$statement = $conn->prepare($sql_login);
		$statement->bindParam(':email',$email, PDO::PARAM_STR);
		$statement->bindParam(':password',$password, PDO::PARAM_STR);
		$statement->execute();
		$results = $statement->fetchAll(PDO::FETCH_OBJ);
		if(count($results) == 1){
			foreach ($results as $result) {
				$typeuser = $result->typeuser;
				$email = $result->email;
				$first_name = $result->first_name;
				$last_name = $result->last_name;
				$_SESSION['login'] = "Ok";
				$_SESSION['typeuser'] = $result->typeuser;
				$_SESSION['email'] = $result->email;
				$_SESSION['first_name'] = $result->first_name;
				$_SESSION['last_name'] = $result->last_name;
				$_SESSION['user_id'] = $result->user_id;
				$_SESSION['authenticate'] = $result->id;
			}
		}
		if($typeuser == "admin")
			header("Location:users");
		else{
			header("Location:shop");
		}
	}

	if(isset($_POST['register'])){
		$nome = $_POST['nome'];
		$apelido = $_POST['apelido'];
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		registerCustomer($nome,$apelido,$email,$senha);
	}
	include "includes/header-top.php"; 
	include "includes/header-middle.php";
	include "includes/header-bottom.php";
?>
	
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Entrar na sua conta</h2>
						<form action="login" method="post">
							<input type="text" required name="email" placeholder="Email" />
							<input type="password" required name="password" placeholder="Confirmar Senha"/>
							<span>
								<input type="checkbox" class="checkbox"> 
								Ficar Logado
							</span>
							<button type="submit" name="login" class="btn btn-default"> <i class="fa fa-lock"></i> Entrar</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Novo cliente registar!</h2>
						<form action="" method="post" onsubmit="return compararSenha();">
							<input type="text" name="nome" placeholder="Nome"/>
							<input type="text" name="apelido" placeholder="Apelido"/>
							<input type="email" name="email" placeholder="Email"/>
							<input type="password" name="senha" id="senha" placeholder="Senha"/>
							<input type="password" name="senha2" id="senha2" placeholder="Confirmar Senha"/>
							<button type="submit" class="btn btn-default" name="register">
								Registar
							</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
	
	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>e</span>-shopper</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe1.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe2.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 de marco 2021</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe3.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 de marco 2021</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe4.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24  de marco 2021</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="images/home/map.png" alt="" />
							<p>Beira, Mocambique</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Servicos</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Ajuda Online</a></li>
								<li><a href="#">Contacte-nos </a></li>
								<li><a href="#">Status do pedido</a></li>
								<li><a href="#">Mudar Localizacao</a></li>
								<!--<li><a href="#">FAQ’s</a></li>-->
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Compra Rapida</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Camisetes</a></li>
								<li><a href="#">Homens</a></li>
								<li><a href="#">Mulheres</a></li>
								<!--<li><a href="#">Gift Cards</a></li>-->
								<li><a href="#">Sapatos</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Politicas</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Termos de Uso</a></li>
								<li><a href="#">Politicas de privacidade</a></li>
								<li><a href="#">politicas de reembolso</a></li>
								<li><a href="#">Sistema de cobranca</a></li>
							<!--	<li><a href="#">Ticket System</a></li>-->
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Sobre Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Informacoes da companhia</a></li>
								<!--<li><a href="#">Careers</a></li>-->
								<li><a href="#">Localizacao da Loja</a></li>
								<!--<li><a href="#">Affillate Program</a></li>-->
								<li><a href="#">Copyright</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>Sobre Shopper</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Your email address" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Obtenha a mais recente atualizacao a partir <br /> do site </p>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2021 E-SHOPPER Inc. Todos direitos reservados.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Zaona&Bule</a></span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	
	<script type="text/javascript">

		function validar(){
			var senha1 = document.getElementById('senha').value;
			var senha2 = document.getElementById('senha2').value;
			if(senha1 == senha2)
				return true;
			else{

				return false;
			}
		}
	</script>
  
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
<?php 
    session_start();
	include "function.php";
    require "require/connection.php";
	include "includes/header-top.php"; 
	if(isset($_POST['cart-form'])):
		$customer = $_POST['customer'];
		$product = $_POST['product'];
		$quantity = $_POST['quantity'];
		$sql_cart = "INSERT INTO cart (product_id , 
		user_id, cart_quantity) VALUES (:product,:customer,:quantity)";
		$statement = $conn->prepare($sql_cart);
		$statement->bindParam(':product', $product,PDO::PARAM_INT);
		$statement->bindParam(':customer', $customer,PDO::PARAM_INT);
		$statement->bindParam(':quantity', $quantity,PDO::PARAM_INT);
		$statement->execute();
		if($conn->lastInsertId()){
			$_SESSION['sucesso'] = "Producto adicionado a carinha";
		}else
			$_SESSION['error'] = "Producto nao foi adicionado a carinha";
		
	endif;
    if((isset($_POST['buy-item'])) || (isset($_GET['product']) && isset($_GET['cart-item']))):
        $product = $_GET['product'];
        $cart_item = $_GET['cart-item'];
	include "includes/header-middle.php";
	include "includes/header-bottom.php";
?>
	<section>
		<div class="container">
            <div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="index">Inicio</a></li>
                  <li><a href="cart">Carinha</a></li>
				  <li class="active">Pagamento</li>
				</ol>
			</div>
			<?php if(isset($_SESSION['sucesso'])):?>
			<div class="alert alert-success text-dark" role="alert">
				<?php echo $_SESSION['sucesso']; unset($_SESSION['sucesso']);?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php endif;?>
			<?php if(isset($_SESSION['error'])):?>
			<div class="alert alert-warning text-dark" role="alert">
				<?php echo $_SESSION['error']; unset($_SESSION['error']);?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php endif;?>
			<div class="row">
				<div class="col-sm-3">
					<?php include "includes/sidebar.php"; ?>
				</div>

				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<?php 
							$products = findOneCartItem($cart_item);
							foreach($products as $product):
						?>
						<div class="col-sm-5">
							<div class="view-product">
								<img src="users/assets/images/products/<?php echo $product->image_url;?>" alt="<?php echo $product->name;?>" />
								<h3>ZOOM</h3>
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
										<div class="item active">
										  	<a href=""><img width="80px;" src="users/assets/images/products/<?php echo $product->image_url;?>" alt=""></a>
										  	<a href=""><img width="80px;" src="users/assets/images/products/<?php echo $product->image2_url;?>" alt=""></a>
										  	<a href=""><img width="80px;" src="users/assets/images/products/<?php echo $product->image3_url;?>" alt=""></a>
										</div>
										<div class="item">
											<a href=""><img width="80px;" src="users/assets/images/products/<?php echo $product->image2_url;?>" alt=""></a>
										  	<a href=""><img width="80px;" src="users/assets/images/products/<?php echo $product->image_url;?>" alt=""></a>
										  	<a href=""><img width="80px;" src="users/assets/images/products/<?php echo $product->image3_url;?>" alt=""></a>
										</div>
										<div class="item">
											<a href=""><img width="80px;" src="users/assets/images/products/<?php echo $product->image3_url;?>" alt=""></a>
										  	<a href=""><img width="80px;" src="users/assets/images/products/<?php echo $product->image_url;?>" alt=""></a>
										  	<a href=""><img width="80px;" src="users/assets/images/products/<?php echo $product->image2_url;?>" alt=""></a>
										</div>
										
									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								<h2><?php echo $product->nome;?></h2>
								<p>Web ID: <?php echo $product->product_id;?></p>
								<img src="images/product-details/rating.png" alt="" />
								<span>
									<span><?php echo number_format($product->units_price).".00Mzn";?></span>
									</br>
									<?php 
										if(isset($_SESSION['user_id'])):
											$customer = $_SESSION['user_id'];
											$productGet = $_GET['product'];
											$products = findOneCondiction("products","product_id",$productGet);
											foreach($products as $productRes)
												$product_id = $productRes->id;
											$users = findOneCondiction("users","user_id",$customer);
											foreach($users as $user)
												$customer = $user->id;
									?>
									<form method="post" class="cart-form" action="payment-confirm?continue=<?php echo $cart_item?>&product=<?php echo $product->product_id;?>&key=<?php echo $_SESSION['user_id']?>">
										<input type="hidden" name="customer" value="<?php echo $customer?>">
										<div class="form-group row">
											<label>Quandade:</label>
											<input type="number" pattern="^[1-9][0-9]{1}" minlength="1" maxlength='2'  value="1" name="quantity"/>
										</div>
										<input type="hidden" name="product" value="<?php echo $product_id?>"/>
										<button type="submit" name="payment-continue" class="btn btn-fefault cart">
											<i class="fa fa-shopping-buy"></i>
											Continuar pagamento
										</button>
									</form>
									<?php endif; ?>
								</span>
								<p><b>Disponivel:</b> NO Stock</p>
								<p><b>Categoria:</b> <?php echo $product->category_name;?></p>
								<p><b>Loja:</b> E-SHOPPER</p>
								<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</div>
						<?php endforeach; ?>
					</div><!--/product-details-->
					
					
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>
    
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
						<div header="100%" class="address">
							<img src="images/home/map.png" alt="" />
							<p>Rua Correia de Brito No. 613, Caixa Postal 544, Ponta Gea, Beira-Sofala<br> Mocambique</p>
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
	

  
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
<?php 
    session_start();
	include "function.php";
    require "require/connection.php";
	include "includes/header-top.php";
	if(isset($_POST['delete-cart'])):
		$id = $_POST['cart-product'];
		$sql_delete = "DELETE FROM cart WHERE id=:id";
		$statement = $conn->prepare($sql_delete);
		$statement->bindParam(':id',$id, PDO::PARAM_INT);
		$statement->execute();
		$_SESSION['sucesso'] = "Producto removido com sucesso!";
	endif;
	include "includes/header-middle.php";
	include "includes/header-bottom.php";
?>
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="index">Inicio</a></li>
				  <li><a href="shop">Mercado</a></li>
				  <li class="active">Lista de desejos</li>
				</ol>
			</div>

			<?php if(isset($_SESSION['sucesso'])):?>
			<div class="alert alert-info text-dark" role="alert">
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

			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Producto</td>
							<td class="description">Descricao</td>
							<td class="price">Preco</td>
							<td class="total">Preco Total</td>
							<td class="description"> Accao</td>
						</tr>
					</thead>
					<tbody>
						<?php 
							$products = findAllCart();
							foreach($products as $product):
						?>
						<tr>
							<td class="cart_product">
								<a href="product-details?product=<?php echo $product->product_id;?>">
									<img width="75px" src="users/assets/images/products/
									<?php echo $product->image_url;?>" alt="<?php echo $product->nome;?>">
								</a>
							</td>
							<td class="cart_description">
								<h4 class="border"><?php echo $product->nome;?></h4>
								<p><strong>Produzido em: </strong><?php echo $product->made_in;?></p>
								<p>Product ID: <?php echo $product->product_id;?></p>
							</td>
							<td class="cart_price">
								<p><?php echo number_format($product->units_price).".00Mzn";?></p>
							</td>
							<td class="cart_total">
								<p class="cart_total_price"><?php echo number_format($product->units_price).".00Mzn";?></p>
							</td>
							<td class="cart_delete" style="display: inline-flex;">
								<form action="product-details?product=<?php echo $product->product_id;?>" method="post">	
									<input type="hidden" name="cart-product"value="<?php echo $product->id;?>">
									<button title="Adicionar Carinha" class="btn btn-info" type="submit" name="buy-item">
										<i class="fa fa-shopping-cart"></i>
									</button>
								</form>
								<form action="payment?product=<?php echo $product->product_id;?>&cart-item=<?php echo $product->id;?>" method="post">	
									<input type="hidden" name="cart-product"value="<?php echo $product->id;?>">
									<button title="Comprar" class="btn btn-success" type="submit" name="buy-item">
										<i class="fa fa-unlock"></i>
									</button>
								</form>
								<form action="" method="post">
									<input type="hidden" name="cart-product"value="<?php echo $product->id;?>"> 
									<button title="Remover" title="Remove" class="btn btn-danger" type="submit" name="delete-cart">
										<i class="fa fa-times"></i>
									</button>
								</form>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->

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
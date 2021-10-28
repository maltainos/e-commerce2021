<?php 
    session_start();
	include "function.php";
    require "require/connection.php";
	include "includes/header-top.php";
    if(isset(($_POST['payment-continue'])) || (isset($_GET['continue']) && isset($_GET['product']) && isset($_GET['key']))):
       // $quantity = $_POST['quantity'];
        $cart_item = $_GET['continue'];
    endif;
	include "includes/header-middle.php";
	include "includes/header-bottom.php";
?>
    <script type="text/javascript">
        function price(){  
            var quantity = document.getElementById("number").value;
            var units_price = document.getElementById("price").value;
            var total = quantity * units_price;
            document.getElementById("total").value = total;
            document.getElementById("price-total").innerHTML = total+"Mzn";
            document.getElementById("pricet").value = total;
            document.getElementById("quantity").value = quantity;
        }
        function phone(){
            var phone = document.getElementById("frete").value;
			var buy_quantity = document.getElementById('quantity-buy').value;
            document.getElementById('span-frete').innerHTML = phone+".00 Mzn";
			var subtotal = document.getElementById('sub-total').value;
			if(!isNaN(phone) && !isNaN(subtotal) && !isNaN(buy_quantity)){
				var total = Number(phone) + buy_quantity * Number(subtotal);
				total = parseInt(total);
				document.getElementById('total').value = total;
			}
        }

		function calcular(){
			var units_price = document.getElementById("sub-total").value;
			var buy_quantity = document.getElementById('quantity-buy').value;
			var phone = document.getElementById("frete").value;
			if(!isNaN(units_price) && !isNaN(buy_quantity) && !isNaN(phone)){
				units_price = parseInt(units_price);
				document.getElementById('span-sub-total').innerHTML = buy_quantity * units_price;
				document.getElementById('total').value = (units_price * buy_quantity) + Number(phone);
			}
			var available = document.getElementById('available').value;
			if(!isNaN(available) && !isNaN(available)){
				if(available - buy_quantity < 0){
					document.getElementById('disponibilidade').innerHTML = "Quantidade indisponivel";
					document.getElementById('submit').setAttribute("disabled","true");
				}else{
					document.getElementById('disponibilidade').innerHTML = "";
					document.getElementById('submit').removeAttribute('disabled');
				}
			}
		}

		function validar(){
			var telefone = document.getElementById('contact').value;
			if(telefone.startsWith("25884") || telefone.startsWith("25885") || telefone.startsWith("84") || telefone.startsWith("85")){
				document.getElementById('cantacto').innerHTML = "Numero M-Pesa valido";
				document.getElementById('contacto').style = "color:blue";
			}else{
				document.getElementById('cantacto').innerHTML = "Numero M-Pesa invalido";
			}
		}
		function numero(){
			var telefone = document.getElementById('contact').value;
			if(telefone.length == 9)
				return true;
			if(telefone.length == 12)
				return true;
			alert("Campo Telefone invalido "+telefone);
			return false;
		}
    </script>
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="index">Inicio</a></li>
                  <li><a href="index">Pagamento</a></li>
				  <li class="active">Confirmar pagamento</li>
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

			<div class="row">
				<div class="col-md-4">
					<div class="img">
					<?php 
						$products = findOneCartItem($cart_item);
						foreach($products as $product):
					?>
					<a href="product-details?product=<?php echo $product->product_id;?>">
						<img width="100%;" src="users/assets/images/products/
						<?php echo $product->image_url;?>" alt="<?php echo $product->nome;?>">
					</a>
					<?php endforeach;?>
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-buy">
						<div class="table-responsive cart_info">
							<table class="table table-condensed">
								<thead>
									<tr class="cart_menu">
										<td class="image">Producto</td>
										<td class="price">Preco Unitario</td>
										<td class="quantity">Categoria</td>
										<td class="total">Sub-categoria</td>
										<td></td>
									</tr>
								</thead>
								<tbody>
									<?php 
										$products = findOneCartItem($cart_item);
										foreach($products as $product):
											$price = $product->units_price;
											$quantity = $product->quantity;
											$prod = $product->id;
									?>
									<tr>
										<td class="cart_product">
											<?php echo $product->nome; ?>
										</td>
										<td class="cart_price">
											<p><?php echo number_format($product->units_price).".00Mzn";?></p>
										</td>
										<td class="cart-category"><?php echo $product->category_name;?></td>
										<td class="cart-sub-category"><?php echo $product->sub_category_name;?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<h4><legend class="bg-primary">Forneca detalhes de faturamento..!</legend></h4>
						<form action="mpesa/payments.php" method="post" onsubmit="return numero();">
							<div class="row">
								<div class="col-sm-6">
									<div class="chose_area">
										<input type="hidden" name="product" value="<?php echo $prod;?>"/>
										<label for="province">Escolha o local a receber provincia ou cidade:</label>
										<select name="province" style="width: 100%; border:none; background:#eee;padding:8px;" id="frete" onchange="phone();">
											<option value="0">Beira</option>
											<option value="100">Manica</option>
											<option value="80">Chimoio</option>
											<option value="450">Nampula</option>
											<option value="530">Nacala</option>
											<option value="550">Angoche</option>
											<option value="430">Maputo</option>
											<option value="460">Matola</option>
											<option value="250">Inhambane</option>
											<option value="200">Xai-xai</option>
											<option value="180">Tete</option>
											<option value="190">Muatize</option>
											<option value="600">Lichinga</option>
											<option value="620">Pemba</option>
										</select>
										<div class="input-group" style="width:100%;margin-top:10px;">
											<label>Codigo postal:</label>
											<input type="text" style="width: 100%; border:none; background:#eee;padding:8px;" name="code" placeholder="Codigo postal" id="">
										</div>
										<div class="input-group" style="width:100%;margin-top:10px;">
											<label>Quantidade:</label>
											<input type="number" style="width: 100%; border:none; background:#eee;padding:8px;" name="quantity" placeholder="Quantidade" id="quantity-buy" onkeyup="calcular();" onmouseup="calcular();" value="1">
											<input type="hidden" id="available" value="<?php echo $quantity;?>">
											<small id="disponibilidade" style="color: red;"></small>
										</div>
										<div class="input-group" style="width:100%;margin-top:10px;">
											<label>Cor:</label>
											<select name="color" style="width: 100%; border:none; background:#eee;padding:8px;">
												<?php
													$product = $_GET['product'];
													$colors = productDetailsColor($product); 
													foreach($colors as $color):
												?>
												<option value="<?php echo $color->id;?>"><?php echo $color->color;?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<div class="input-group" style="width:100%;margin-top:10px;">
											<label>Tamanho:</label>
											<select name="size" style="width: 100%; border:none; background:#eee;padding:8px;">
												<?php
													$product = $_GET['product'];
													$sizes = productDetailsSize($product); 
													foreach($sizes as $size):
												?>
												<option value="<?php echo $size->id;?>"><?php echo $size->size;?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="total_area">
										<ul>
											<li style="width: 100%; border:none; background:#eee;padding:8px;">Carinha Sub Total <span id="span-sub-total"><?php echo number_format($price).".00Mzn";?></span></li>
											<input type="hidden" id="sub-total" value="<?php echo $price;?>">
											<li style="width: 100%; border:none; background:#eee;padding:8px;">Iva : <span>0Mzn</span></li>
											<li style="width: 100%; border:none; background:#eee;padding:8px;">Taxa de entrega <span id="span-frete">Gratis</span></li>
											<li style="width: 100%; border:none; background:#eee;padding:8px;">Total <input style="float: right; border:none; text-align:right;background:#eee;" type="text" name="total" id="total" value="<?php echo number_format($price).'.00Mzn';?>"/></li>
										</ul>
										<div class="input-group" style="width:90%;margin-top:10px;float:right;">
											<label>Numero de Telefone:</label>
											<input type="text" style="width: 100%; border:none; background:#eee;padding:8px; float:right;" name="telefone" placeholder="258 84 (***) (****)" value="25884" id="contact" onkeyup="validar();">
											<span style="margin-top:-26px; margin-right:10px;">M-PESA</span>
											<small id="cantacto" style="color: red;"></small>
										</div>
										<button type="reset" class="btn btn-default update" href="">Cancelar</button>
										<button type="submit" id="submit" name="finish-buy" class="btn btn-default check_out" href="">Terminar Compra</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			
		</div>
	</section><!--/#do_action-->

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
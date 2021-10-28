
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index"><img src="images/home/logo.png" alt="" /></a>
						</div>
						<div class="btn-group pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									MOZ
									<span class="caret"></span>
								</button>
							</div>
							
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									MZN
									<span class="caret"></span>
								</button>
							</div>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">

                            <?php 
                                if(isset($_SESSION['login'])):
                                    $typeuser = $_SESSION['typeuser'];
                                    $email = $_SESSION['email'];
                                    $firstName = $_SESSION['first_name'];
                                    $lastName = $_SESSION['last_name'];
									$user_id = $_SESSION['user_id'];
                            ?>
                            <ul class="nav navbar-nav">
								<li><a href="user?profile=<?php echo $user_id;?>"><i class="fa fa-user"></i> <?php echo $firstName; ?></a></li>
								<li>
									<?php 
										$wishilists = countWishilist();
										foreach($wishilists as $wishilist):
									?>
									<a href="withslist">
										<i class="fa fa-star"></i> 
										Lista de desejos
										<span class="badge badge-danger"><?php echo $wishilist->wishilist_shopping;?></span>
									</a>
									<?php endforeach; ?>
								</li>
								<li>
									<?php 
										$buys = countBuy();
										foreach($buys as $buy):
									?>
									<a href="my-sales">
										<i class="fa fa-crosshairs"></i> 
										Minhas Compras<span class="badge badge-success"><?php echo $buy->all_sale;?></span>
									</a>
									<?php endforeach; ?>
								</li>
								<li>
									<?php 
										$carts = countCart();
										foreach($carts as $cart):
									?>
									<a href="cart">
										<i class="fa fa-shopping-cart"></i> 
										Carinha
										<span class="badge badge-danger"><?php echo $cart->cart_shopping;?></span>
									</a>
									<?php endforeach; ?>
								</li>
								<li><a href="logout"><i class="fa fa-unlock"></i> Sair</a></li>
							</ul>
                            <?php endif; ?>

                            <?php  if(!isset($_SESSION['login'])):?>
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-user"></i> Minha Conta</a></li>
								<li><a href="#"><i class="fa fa-star"></i> Lista de Desejos</a></li>
								<li><a href="checkout"><i class="fa fa-crosshairs"></i> Minhas Compras</a></li>
								<li><a href="cart"><i class="fa fa-shopping-cart"></i> Carinha</a></li>
								<li><a href="login"><i class="fa fa-lock"></i> Entrar</a></li>
							</ul>
                            <?php endif;?>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
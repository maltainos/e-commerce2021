		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index" class="active">Inicio</a></li>
								<li class="dropdown"><a href="shop">Mercado<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="shop">Products</a></li>
										<li><a href="cart">Cart</a></li>

										<?php  if(isset($_SESSION['login'])): ?>
										<li><a href="logout">Termiar Seccao</a></li>
										<?php endif; ?>
										<?php  if(!isset($_SESSION['login'])): ?> 
										<li><a href="login">Login</a></li> 
										<?php endif; ?>
                                    </ul>
                                </li> 
								<li><a href="promotional">Promocoes</a></li>
								<li><a href="about-us">Sobre Eshopper</a></li>
								<li><a href="contact-us">Contacto</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<input style="font-size:18px;" type="text" placeholder="Procurar"/>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
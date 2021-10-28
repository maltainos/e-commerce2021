                    <div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">Itens Recomendados</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
							<?php
								$counter = 1; 
								for($i = 0; $i < 3; $i++):
								if($counter == 1):
							?>
								<div class="item active">
								<?php endif;?>

								<?php if($counter != 1):?>
								<div class="item">
								<?php endif;?>
								
								<?php
									$products = findAllAndJoinTablesSortedLimit("products","category","sub_categories",3);
									foreach($products as $product):
								?>
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img  height="240px;" src="users/assets/images/products/<?php echo $product->image_url;?>" alt="<?php echo $product->name;?>" />
													<h2><?php echo number_format($product->units_price).".00Mzn";?></h2>
													<p><?php echo $product->name;?></p>
													<a href="product-details?product=<?php echo $product->product_id;?>" class="btn btn-default add-to-cart">
														<i class="fa fa-shopping-cart"></i>
													Adicionar Carinha</a>
												</div>
												
											</div>
										</div>
									</div>
									<?php $counter++; endforeach;?>
								</div>
								<?php endfor; ?>
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
                    <div class="left-sidebar">
						<h2>Categorias</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
                            <?php 
                                $categories = findAll("category");
                                foreach($categories as $category):
                            ?>
                            <div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#<?php echo $category->category_id;?>">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											<?php echo $category->category_name;?>
										</a>
									</h4>
								</div>
								<div id="<?php echo $category->category_id;?>" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>
                                            <?php 
                                                $subCategories = findOneCondiction("sub_categories","category_id",$category->id);
                                                foreach($subCategories as $subCategory):
                                            ?>
											<li><a href="shop?category=<?php echo $category->category_name;?>&sub-category=<?php echo $subCategory->sub_category_id;?>"><?php echo $subCategory->sub_category_name;?></a></li>
                                            <?php endforeach; ?>
										</ul>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
						</div><!--/category-products-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>Sub-Categorias</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									<?php 
										$marcas = marcas();
										foreach($marcas as $marca):
									?>
									<li><a href="shop?sub-category=<?php echo $marca->marca;?>&key=<?php echo $marca->id;?>"> <span class="pull-right">(<?php echo $marca->registro?>)</span><?php echo $marca->marca;?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div><!--/brands_products-->
						
						<div class="price-range"><!--price-range-->
							<h2>Price Range</h2>
							<div class="well text-center">
								 <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
								 <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
							</div>
						</div><!--/price-range-->
						
						<div class="shipping text-center"><!--shipping-->
							<img src="images/home/shipping.jpg" alt="" />
						</div><!--/shipping-->
					
					</div>
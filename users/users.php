<?php
    session_start();
    include 'includes/header.php';
    include 'includes/preloader.php';
    include 'includes/top.php';
    include 'includes/sidebar.php';
    include 'function.php';
    if(isset($_POST['products']) && isset($_POST['store'])){
        $product = $_POST['producto'];
        $image_url = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];  
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $made_in = $_POST['made_in'];
        $category = $_POST['category'];
        $sub_category = $_POST['sub_category'];
        $sql_create = "INSERT INTO products(product_id, name, image_url, 
            image2_url, image3_url, units_price, quantity, descriptions, 
            made_in, category_id, sub_category_id) VALUES (:product_id,
            :product,:image_url,:image2_url,:image3_url,:units_price,
            :quantity,:descriptions,:made_in,:category_id,:sub_category_id)";
        $image_url = saveImage($image_url, $image_tmp);
        $statement = $conn->prepare($sql_create);
        $product_id = "123mhjdsknskhsfcmsdfdskjdyfdbfjd";
        $statement->bindParam(':product_id',$product_id, PDO::PARAM_STR);
        $statement->bindParam(':product',$product, PDO::PARAM_STR);
        $statement->bindParam(':image_url',$image_url, PDO::PARAM_STR);
        $statement->bindParam(':image2_url',$image_url, PDO::PARAM_STR);
        $statement->bindParam(':image3_url',$image_url, PDO::PARAM_STR);
        $statement->bindParam(':units_price',$price);
        $statement->bindParam(':quantity',$quantity, PDO::PARAM_INT);
        $statement->bindParam(':descriptions',$description, PDO::PARAM_STR);
        $statement->bindParam(':made_in',$made_in, PDO::PARAM_STR);
        $statement->bindParam(':category_id',$category, PDO::PARAM_INT);
        $statement->bindParam(':sub_category_id',$sub_category, PDO::PARAM_INT);
        $statement->execute();
        if($conn->lastInsertId()){
            $_SESSION['success'] = "<strong>Producto</strong> guardado com sucesso!";
        }else{
            $_SESSION['unsuccess'] = "<strong>Producto</strong> nao salvo com sucesso";
        }
    }
?>
    <div class="page-wrapper">

        <div class="page-breadcrumb bg-white">
            <!--row align-items-center begin-->
            <div class="row align-items-center">
                <!-- ============================================== --> 
                <!--col-lg-3 col-md-4 col-sm-4 col-xs-12 begin-->
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title text-uppercase font-medium font-14">GUEST/apresentacao</h4>
                </div><!--col-lg-3 col-md-4 col-sm-4 col-xs-12 end-->
                <!-- ============================================== -->
                <!--col-lg-9 col-sm-8 col-md-8 col-xs-12 begin-->
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <div class="d-md-flex">
                        <ol class="breadcrumb ml-auto">
                            <li>SA-Epsilon Administracao</li>
                        </ol>
                    </div>
                </div><!--col-lg-9 col-sm-8 col-md-8 col-xs-12 end-->
                <!-- ============================================== -->
            </div>
        </div><!--row align-items-center end-->
        <!-- ============================================================== -->

        <!-- container-fluid  begin-->
        <div class="container-fluid">
                <!-- row  begin-->
                <div class="row"> 
                    <!-- column begin-->
                    <div class="col-lg-12 col-xlg-12 col-md-12">
                        <?php if(isset($_SESSION['success'])):?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']);?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif;?>
                        <?php if(isset($_SESSION['unsuccess'])):?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['unsuccess']; unset($_SESSION['unsuccess']);?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif;?>
                        <button title="Adicionar" type="button" class="btn btn-primary col-md-3 my-2" data-toggle="modal" data-target="#product-modal">
                            <i class="fa fa-plus"></i> Usuario
                        </button>
                        <!-- Modal Begin-->
                        <div class="modal fade col-md-4 " id="product-modal" tabindex="-1" role="dialog" aria-labelledby="product-label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="product-label">ADICIONAR NOVO PRODUCTO</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal form-material" name="form-products" action="products" method="post" enctype="multipart/form-data">
                                            <div class="form-group mb-4">
                                                <label class="col-md-12 p-0" for="producto">Nome do producto</label>
                                                <div class="col-md-12 p-0">
                                                    <input type="text" name="producto" placeholder="Nome do producto"
                                                        class="form-control p-2 border rounded" id="producto"> 
                                                </div>
                                            </div> 
                                            <div class="custom-file mb-4">
                                                <input type="file" name="image" class="custom-file-input" id="file" required onmouseout="changeText();">
                                                <label class="custom-file-label overflow-hidden" for="file" id="label-image">Selecione uma imagem...</label>
                                            </div>                              
                                            <div class="form-group mb-4">
                                                <label for="description" class="col-md-12 p-0">Descricao producto</label>
                                                <div class="col-md-12 p-0">
                                                    <textarea rows="6" name="description" class="form-control p-2 border rounded" id="description">
                                                    </textarea> 
                                                </div>
                                            </div>
                                            <div class="form-group row mb-4">
                                                <div class="col-sm">
                                                    <label for="quantity" class="col-md-12 p-0">Quantidade</label>
                                                    <div class="col-md-12 border-bottom p-0">
                                                        <input type="number" name="quantity" placeholder="0" class="form-control p-2 border rounded" id="quantity">
                                                    </div> 
                                                </div>
                                                <div class="col-sm">
                                                    <label for="price" class="col-md-12 p-0">Preco Unitario</label>
                                                    <div class="col-md-12 border-bottom p-0">
                                                        <input type="number" name="price" placeholder="0.00" class="form-control p-2 border rounded" id="price">
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="made-in" class="col-md-12 p-0">Fabricado em:</label>
                                                <div class="col-md-12 border-bottom p-0">
                                                    <input type="text" name="made_in" placeholder="Fabricado em" class="form-control p-2 border rounded" id="made-in">
                                                </div> 
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="category" class="col-md-12 p-0">Selecione a categoria</label>
                                                <div class="col-md-12 border-bottom p-0">
                                                    <select name="category" class="form-control p-2 border rounded" id="category">
                                                        <?php 
                                                            $categories = findAll("category");
                                                            foreach($categories as $category):
                                                        ?>
                                                        <option id="category_field" value="<?php echo $category->id;?>"><?php echo $category->category_name;?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div> 
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="sub_category" class="col-md-12 p-0">Selecine a sub categoria</label>
                                                <div class="col-md-12 border-bottom p-0">
                                                    <select name="sub_category" class="form-control p-2 border rounded" id="sub_category">
                                                        <?php
                                                            $sub_categories = findAllToOne("sub_categories",2);
                                                            foreach($sub_categories as $sub_category):
                                                        ?>
                                                        <option value="<?php echo $sub_category->id; ?>"><?php echo $sub_category->sub_category_name;?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div> 
                                            </div>

                                            <input type="hidden" name="store" value="soniatlam"/>
                                            <button type="submit" name="products" class="btn btn-primary float-right">Salvar</button>                                    
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div><!--Modal Finish-->  

                        <!-- ============================================================== -->
                        <!-- card begin -->
                        <div class="card">                             
                            <div class="card-body table-responsive">                               
                                <table id="products" class="display" width="100%">
                                    <thead>
                                        <tr>            
                                            <th class="border-top-0">Imagem</th>
                                            <th class="border-top-0 text-center">Nome</th>
                                            <th class="border-top-0 text-center">Apelido</th>
                                            <th class="border-top-0 text-center">Email</th>
                                            <th class="border-top-0 text-center">Criado</th>
                                            <th class="border-top-0 text-center">Actualizado</th>
                                            <th class="border-top-0 text-center">Accao</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $users = findAll("users");
                                            foreach($users as $user):
                                        ?>
                                        <tr class="border-bottom">
                                            <td>
                                                <img height="75px;" src="assets/images/users/<?php echo $user->image_url;?>" class="img-responsive" alt="<?php echo $user->image_url;?>">
                                            </td>
                                            <td class="txt-oflo text-left"><?php echo $user->first_name;?></td>
                                            <td class="txt-oflo text-left"><?php echo $user->last_name;?></td>
                                            <td class="txt-oflo text-left"><?php echo $user->email;?></td>
                                            <td class="txt-oflo text-center"><?php echo $user->create_on;?></td>
                                            <td class="txt-oflo text-center"><?php echo $user->update_on;?></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-lg-12 justify-content-center" style="display: inline-flex;">
                                                        <form action="usuario.php" method="post">
                                                            <input type="hidden" name="usuario" value="">
                                                            <button title="Activar ou Desactivar" class="btn btn-default" type="submit" name="detalhes"><i class="fa fa-eye"></i></button>
                                                        </form>
                                                        <form action="estudante.php" method="post">
                                                            <input type="hidden" name="estudante_id" value="">
                                                            <input type="hidden" name="status" value="">
                                                            <button title="Detalhes" class="btn btn-success" type="submit" name="detalhes"><i class="fa fa-plus"></i></button>
                                                        </form>
                                                        <form action="estudante.php" method="post">
                                                            <input type="hidden" name="estudante_id" value="">
                                                            <input type="hidden" name="status" value="">
                                                            <button title="Editar" class="btn btn-primary" type="submit" name="edit"><i class="fa fa-edit"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- card end -->

                    </div><!-- column end-->
                </div><!-- row end -->
                <!-- ============================================================== -->
        </div><!-- container-fluid  begin-->

        <!-- ============================================================== -->

    </div>
    <?php include 'includes/footer.php'?>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#products').DataTable({
                dom: 'Bfrtip',
                buttons: [
                  'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        } );
    </script> 
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="assets/js/saepsilon.js"></script>
</body>
</html>
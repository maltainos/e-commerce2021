<?php
    session_start();
    include 'includes/header.php';
    //include 'includes/preloader.php';
    include 'includes/top.php';
    include 'includes/sidebar.php';
    include 'function.php';
    if(isset($_POST['categories']) && isset($_POST['store'])){
        $category = $_POST['category'];
        $sql_create = "INSERT INTO category(category_id, category_name) VALUES (:category_id,
            :category)";
        $statement = $conn->prepare($sql_create);
        $category_id = "123mhjdsknskhsfcmsdfdsrjdyfdbfjd";
        $statement->bindParam(':category_id',$category_id, PDO::PARAM_STR);
        $statement->bindParam(':category',$category, PDO::PARAM_STR     );
        $statement->execute();
        if($conn->lastInsertId()){
            $_SESSION['success'] = "<strong>Categoria</strong> guardado com sucesso!";
        }else{
            $_SESSION['unsuccess'] = "<strong>Categoria</strong> nao salvo com sucesso";
        }
    }

    if(isset($_POST['categories-update']) && isset($_POST['update'])){
        $category = $_POST['category'];
        $category_id = $_POST['category_id'];
        $sql_create = "UPDATE category SET category_name =
            :category WHERE category_id =:category_id";
        $statement = $conn->prepare($sql_create);
        $statement->bindParam(':category_id',$category_id, PDO::PARAM_STR);
        $statement->bindParam(':category',$category, PDO::PARAM_STR     );
        $statement->execute();
        $_SESSION['success'] = "<strong>Categoria</strong> actualizado com sucesso!";
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
                    <div class="col-lg-12 col-xlg-12 col-md-12 justify-content-center">
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

                        <?php 
                            if((isset($_POST['edit']) || isset($_GET['edit']))):
                            $category_id = $_GET['edit'];
                            $categories = findOneCondiction("category","category_id",$category_id);
                            foreach($categories as $category):
                        ?>

                        <form class="form-horizontal form-material" name="form-category" action="categories" method="post">
                            <legend>Actualizacao categoria</legend>
                            <hr>
                            <div class="row form-group mb-4">
                                <label class="col-sm-2 col-form-label" for="category">Nome da categoria:</label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="category_id" value="<?php echo $category->category_id?>"
                                        class="form-control p-2 border rounded" id="category" > 
                                    <div class="col-md-12 p-0">
                                        <input required type="text" name="category" value="<?php echo $category->category_name?>"
                                        class="form-control p-2 border rounded" id="category" > 
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input type="hidden" name="update" value="soniatlam"/>
                                    <button type="submit" name="categories-update" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>                                   
                        </form>
                        <?php  
                            endforeach; endif;
                            if(!((isset($_POST['edit']) || isset($_GET['edit'])))):
                        ?> 
                        <form class="form-horizontal form-material" name="form-products" action="categories" method="post" enctype="multipart/form-data">
                            <legend>Adicionar nova categoria</legend>
                            <hr>
                            <div class="row form-group mb-4">
                                <label class="col-sm-2 col-form-label" for="category">Nome da categoria:</label>
                                <div class="col-sm-8">
                                    <div class="col-md-12 p-0">
                                        <input required type="text" name="category" placeholder="Nome da categoria"
                                        class="form-control p-2 border rounded" id="category" > 
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input type="hidden" name="store" value="soniatlam"/>
                                    <button type="submit" name="categories" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>                                   
                        </form>
                        <?php endif; ?>
                        <hr/>
                        <!-- ============================================================== -->
                        <div class="row">
                            <!-- card begin -->
                            <div class="card col-sm">                             
                                <div class="card-body table-responsive">
                                    <legend>Lista de Categorias</legend>                            
                                    <table id="categories" class="display" width="100%">
                                        <thead>
                                            <tr>            
                                                <th class="border-top-0">No.</th>
                                                <th class="border-top-0 text-center">Categoria</th>
                                                <th class="border-top-0 text-center">Accao</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $categories = findAll("category");
                                                $count = 1;
                                                foreach($categories as $category):
                                            ?>
                                            <tr class="border-bottom">
                                                <td><?php echo $count; ?></td>
                                                <td class="txt-oflo text-center"><?php echo $category->category_name;?></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-lg-12 justify-content-center" style="display: inline-flex;">
                                                            
                                                            <form action="categories?sub-category=<?php echo $category->category_id;?>" method="post">
                                                                <input type="hidden" name="category" value="<?php echo $category->id;?>">
                                                                <button title="Ver Sub-Categorias" class="btn btn-success" type="submit" name="sub-category"><i class="fa fa-eye"></i></button>
                                                            </form>
                                                            
                                                            <form action="categories?edit=<?php echo $category->category_id;?>" method="post">
                                                                <input type="hidden" name="edit" value="<?php echo $category->category_id;?>">
                                                                <input type="hidden" name="status" value="">
                                                                <button title="Editar" class="btn btn-primary" type="submit" name="edit"><i class="fa fa-edit"></i></button>
                                                            </form>
                                                            <form action="categories?remove=<?php echo $category->category_id;?>" method="post">
                                                            <input type="hidden" name="category_id" value="<?php echo $category->category_id;?>">
                                                                <input type="hidden" name="status" value="">
                                                                <button title="Editar" class="btn btn-danger" type="submit" name="remove"><i class="fa fa-trash"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $count++; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- card end -->

                            <!-- card begin -->
                            <div class="card col-sm">                             
                                <div class="card-body table-responsive">
                                    <?php
                                    if(isset($_POST['sub-category'])):
                                        $category = $_POST['category'];
                                        $categories = findOne("category",$category);
                                        foreach($categories as $category):
                                       
                                    ?>         
                                    <legend>Lista de Sub Categorias da <?php echo $category->category_name;?></legend> 
                                    <?php endforeach; endif;?>
                                    <?php
                                    if(!isset($_POST['sub-category'])):?>         
                                    <legend>Lista de Sub Categorias</legend> 
                                    <?php endif;?>                          
                                    <table id="subcategories" class="display" width="100%">
                                        <thead>
                                            <tr>            
                                                <th class="border-top-0">No.</th>
                                                <th class="border-top-0 text-center">Sub-categoria</th>
                                                <th class="border-top-0 text-center">Accao</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(isset($_POST['sub-category'])){
                                                    $category = $_POST['category'];
                                                    $subCategories = findAllToOne("sub_categories",$category);
                                                }else
                                                    $subCategories = findAll("sub_categories");
                                                $count = 1;
                                                foreach($subCategories as $subCategory):
                                            ?>
                                            <tr class="border-bottom">
                                                <td><?php echo $count; ?></td>
                                                <td class="txt-oflo text-center"><?php echo $subCategory->sub_category_name;?></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-lg-12 justify-content-center" style="display: inline-flex;">
                                                            <form action="sub-categories?edit=<?php echo $subCategory->sub_category_id;?>" method="post">
                                                                <input type="hidden" name="sub-category" value="<?php echo $subCategory->sub_category_id;?>">
                                                                <button title="Editar" class="btn btn-primary" type="submit" name="edit"><i class="fa fa-edit"></i></button>
                                                            </form>
                                                            <form action="sub-categories?edit=<?php echo $subCategory->sub_category_id;?>" method="post">
                                                                <input type="hidden" name="estudante_id" value="">
                                                                <button title="Eliminar" class="btn btn-danger" type="submit" name="remove"><i class="fa fa-trash"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $count++; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- card end -->
                        </div>
                </div><!-- column end-->
            </div><!-- row end -->
            <!-- ============================================================== -->
        </div><!-- container-fluid  begin-->

        <!-- ============================================================== -->

    </div>
    <?php include 'includes/footer.php'?>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#categories').DataTable({
            });
            $('#subcategories').DataTable({
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
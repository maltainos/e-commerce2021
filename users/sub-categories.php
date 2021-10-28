<?php
    session_start();
    include 'includes/header.php';
    //include 'includes/preloader.php';
    include 'includes/top.php';
    include 'includes/sidebar.php';
    include 'function.php';
    if(isset($_POST['sub_categories']) && isset($_POST['store'])){
        $sub_category = $_POST['sub_category'];
        $category = $_POST['category'];
        $sql_create = "INSERT INTO sub_categories(sub_category_id,
            sub_category_name,category_id) VALUES (:sub_category_id,
            :sub_category_name,:category_id)";
        $statement = $conn->prepare($sql_create);
        $sub_category_id = "123mhjdsknskhsfcmsdfdsrjdyfdbfjd";
        $statement->bindParam(':sub_category_id',$sub_category_id, PDO::PARAM_STR);
        $statement->bindParam(':sub_category_name',$sub_category, PDO::PARAM_STR);
        $statement->bindParam(':category_id',$category, PDO::PARAM_INT);
        $statement->execute();
        if($conn->lastInsertId()){
            $_SESSION['success'] = "<strong>Sub categoria</strong> guardado com sucesso!";
        }else{
            $_SESSION['unsuccess'] = "<strong>Sub categoria</strong> nao salvo com sucesso";
        }
    }

    if(isset($_POST['sub_categories-update']) && isset($_POST['update'])){
        $sub_category_id = $_POST['sub-category-id'];
        $sub_category = $_POST['sub_category'];
        $category = $_POST['category'];
        $sql_create = "UPDATE sub_categories SET sub_category_name = :sub_category_name, 
            category_id =:category_id WHERE sub_category_id = :sub_category_id";
        $statement = $conn->prepare($sql_create);
        $statement->bindParam(':sub_category_id',$sub_category_id, PDO::PARAM_STR);
        $statement->bindParam(':sub_category_name',$sub_category, PDO::PARAM_STR);
        $statement->bindParam(':category_id',$category, PDO::PARAM_INT);
        $statement->execute();
        $_SESSION['success'] = "<strong>Sub categoria</strong> actualizado com sucesso!";
    }
?>
    <div class="page-wrapper">

        <div class="page-breadcrumb bg-white">
            <!--row align-items-center begin-->
            <div class="row align-items-center">
                <!-- ============================================== --> 
                <!--col-lg-3 col-md-4 col-sm-4 col-xs-12 begin-->
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title text-uppercase font-medium font-14">Moz Fashion Shop Store</h4>
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
                        <?php if(!(isset($_POST['edit']) || isset($_GET['edit']))):?>
                        <form class="form-horizontal form-material" name="form-products" action="sub-categories" method="post" enctype="multipart/form-data">
                            <legend>Adicionar nova sub-categoria</legend>
                            <hr>
                            <div class="row form-group mb-4">
                                <label class="col-sm-1 col-form-label" for="sub_category">Nome:</label>
                                <div class="col-sm-4">
                                    <div class="col-md-12 p-0">
                                        <input required type="text" name="sub_category" placeholder="Nome da sub categoria"
                                        class="form-control p-2 border rounded" id="sub_category" > 
                                    </div>
                                </div>
                                <label class="col-sm-1 col-form-label" for="sub_category">Categoria:</label>
                                <div class="col-sm-4">
                                    <div class="col-md-12 p-0">
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
                                <div class="col-sm-2">
                                    <input type="hidden" name="store" value="soniatlam"/>
                                    <button type="submit" name="sub_categories" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>                                   
                        </form>
                        <?php endif; ?>

                        <?php 
                            if(isset($_POST['edit']) || isset($_GET['edit'])):
                                if(isset($_POST['sub-category']))
                                    $sub_category = $_POST['sub-category'];
                                $sub_category = $_GET['edit'];
                                $sub_categories = findOneCondiction("sub_categories","sub_category_id",$sub_category);
                                foreach($sub_categories as $subCategory):
                        ?>
                        <form class="form-horizontal form-material" name="form-products" action="sub-categories" method="post" enctype="multipart/form-data">
                            <legend>Actualizacao da sub-categoria</legend>
                            <hr>
                            <div class="row form-group mb-4">
                                <label class="col-sm-1 col-form-label" for="sub_category">Nome:</label>
                                <div class="col-sm-4">
                                    <div class="col-md-12 p-0">
                                        <input required type="hidden" name="sub-category-id" value="<?php echo $subCategory->sub_category_id;?>"> 
                                        <input required type="text" name="sub_category" placeholder="Nome da sub categoria"
                                        class="form-control p-2 border rounded" id="sub_category" value="<?php echo $subCategory->sub_category_name;?>"> 
                                    </div>
                                </div>
                                <label class="col-sm-1 col-form-label" for="sub_category">Categoria:</label>
                                <div class="col-sm-4">
                                    <div class="col-md-12 p-0">
                                        <select name="category" class="form-control p-2 border rounded" id="category">
                                        <?php 
                                            $categories = findAll("category");
                                            foreach($categories as $category):
                                                if($category->id == $subCategory->category_id):
                                        ?>
                                            <option selected value="<?php echo $category->id;?>">
                                                <?php echo $category->category_name;?>
                                            </option>
                                            <?php endif; if($category->id != $subCategory->category_id):?>
                                            <option value="<?php echo $category->id;?>">
                                                <?php echo $category->category_name;?>
                                            </option>
                                            <?php endif; endforeach; ?>
                                        </select> 
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input type="hidden" name="update" value="soniatlam"/>
                                    <button type="submit" name="sub_categories-update" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>                                   
                        </form>
                        <?php endforeach; endif; ?>

                        <hr/>
                        <!-- ============================================================== -->
                        <div class="row">

                            <!-- card begin -->
                            <div class="card col-sm">                             
                                <div class="card-body table-responsive">
                                    <legend>Lista de Sub Categorias</legend>                         
                                    <table id="products" class="display" width="100%">
                                        <thead>
                                            <tr>            
                                                <th class="border-top-0">No.</th>
                                                <th class="border-top-0 text-center">Sub-categoria</th>
                                                <th class="border-top-0 text-center">Categoria</th>
                                                <th class="border-top-0 text-center">Accao</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $subCategories = findAllAndJoin("category","sub_categories");
                                                $count = 1;
                                                foreach($subCategories as $subCategory):
                                            ?>
                                            <tr class="border-bottom">
                                                <td><?php echo $count; ?></td>
                                                <td class="txt-oflo text-center"><?php echo $subCategory->sub_category_name;?></td>
                                                <td class="txt-oflo text-center"><?php echo $subCategory->category_name;?></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-lg-12 justify-content-center" style="display: inline-flex;">
                                                            <form action="sub-categories?edit=<?php echo $subCategory->sub_category_id;?>" method="post">
                                                                <input type="hidden" name="sub-category" value="<?php echo $subCategory->sub_category_id;?>">
                                                                <button title="Editar" class="btn btn-primary" type="submit" name="edit"><i class="fa fa-edit"></i></button>
                                                            </form>
                                                            <form action="estudante.php" method="post">
                                                                <input type="hidden" name="estudante_id" value="">
                                                                <input type="hidden" name="status" value="">
                                                                <button title="Editar" class="btn btn-danger" type="submit" name="edit"><i class="fa fa-trash"></i></button>
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
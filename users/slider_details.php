<?php
    include 'includes/header.php';
    if(isset($_GET['id'])){           
        $id = $_GET['id'];
        $sql = "SELECT * FROM slider WHERE id=:sid";                                            
        $query = $conn->prepare($sql);
        $query->bindParam(':sid',$id,PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
    }
    include 'includes/preloader.php';
    include 'includes/top.php';
    include 'includes/sidebar.php';
?>
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title text-uppercase font-medium font-14">GUEST/Dashboard</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ml-auto">
                                <li>SA-Epsilon GUEST-USER</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- RECENT SALES -->
                <!-- ============================================================== -->
                <div class="row justify-content-md-center">
                                                     
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <div class="d-md-flex mb-3 border-bottom">
                                <h3 class="box-title mb-0">DETALHES SLIDER</h3>
                            </div>
                            <div class="d-md-flex mb-3">
                                <div class="row">
                                    <?php foreach($results as $result):?>
                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                        <h3 class="mb-0">TITULO :</h3>
                                        <h4 class="box-title mb-2 py-2"><?php echo $result->titulo;?></h4>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                        <h3 class="mb-0">CONTEUDO :</h3>
                                        <p class="text-dark py-2"><?php echo $result->conteudo;?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                        <a title="Activar Slider Principla" class="btn btn-default" href="slider_active.php?id=<?php echo $result->id?>">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a title="Editar" class="btn btn-primary" href="slider_edit.php?id=<?php echo $result->id?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a title="Remover" class="btn btn-danger" href="slider_delete.php?id=<?php echo $result->id?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div> 
                                   <?php endforeach;?>                       
                                </div>

                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <div class="white-box">
                                        <div class="d-md-flex">
                                            <?php foreach($results as $result):?>
                                            <img class='img-fluid' src="images/slider/<?php echo$result->imagem;?>" alt="<?php echo $result->titulo?>">
                                            <?php endforeach;?>                      
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                                     
                </div>
                <!-- ============================================================== -->
                <!-- Recent Comments -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

<?php    
    include 'includes/footer.php' 
?>
<?php
    include 'includes/header.php';
    if(isset($_GET['id'])){           
        $id = $_GET['id'];
        $sql = "SELECT * FROM slider WHERE id=:sid";                                            
        $query = $conn->prepare($sql);
        $query->bindParam(':sid',$id,PDO::PARAM_INT);
        $query->execute();
        $resultSet = $query->fetchAll(PDO::FETCH_OBJ);
        $result;
        foreach($resultSet as $res){
            $result = $res;
        }
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
                                                     
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="white-box">
                            <div class="d-md-flex mb-3">
                                <h3 class="box-title mb-0">EDITAR SLIDER</h3>
                            </div>
                            <div class="d-md-flex mb-3">
                                <form class="form-horizontal form-material" method="post" action="slider_edit_store.php?id=<?php echo $result->id;?>" enctype="multipart/form-data">
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" for="name">Titulo</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="Titulo" name="titulo"
                                                class="form-control p-0 border-0" value="<?php echo $result->titulo;?>" id="titulo" required> 
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="short_desc" class="col-md-12 p-0">Descricao Curta</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="Esta descricao sera mostrada logo no inicio"
                                                class="form-control p-0 border-0" name="conteudo"
                                                id="short_desc" required value="<?php echo $result->conteudo;?>">
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" for="image">Imagem</label>
                                        <div class="col-sm-12 custom-file">
                                            <input type="file" name="image" value="<?php echo $result->imagem;?>" id="image" onmouseover="trocarImagem();">
                                        </div>
                                    </div>
                                    <input type="hidden" class="custom-file-input" name="imagem" value="<?php echo $result->imagem;?>">                                    
                                    <input type="hidden" class="custom-file-input" name="id" value="<?php echo $result->id;?>">                                    
                                    <input type="hidden" class="custom-file-input" name="create_at" value="<?php echo $result->create_at;?>">                                    
                                    <input type="hidden" class="custom-file-input" name="ms12rvw" value="soniatlam">                                    
                                    <button type="submit" name="submit" class="btn btn-primary float-right">Salvar</button>
                                </form>                        
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="white-box">
                            <div class="d-md-flex mb-3">
                                <h3 class="box-title mb-0">SLIDER IMAGEM</h3>
                            </div>
                            <div class="d-md-flex mb-3">
                                <img id="imagem" src="images/slider/<?php echo $result->imagem; ?>" class="img-fluid">
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
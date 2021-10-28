<?php
    include 'includes/header.php';
    if(isset($_POST['ms12rvw']) && isset($_POST['submit'])){           
            $titulo = $_POST['titulo'];
            $conteudo = $_POST['conteudo'];
            $imagem = $_FILES['image']['name'];
            $imagem_tmp = $_FILES['image']['tmp_name'];        
            $confirmation = $_POST['ms12rvw']; 
            $user_id = $_SESSION['user_id'];
            if($confirmation == "soniatlam"){
                $sql = "INSERT INTO slider(titulo,conteudo,imagem,user_id) VALUES(:titulo,:conteudo,:imagem,:user_id)";
                $query =  $conn->prepare($sql);
                $imagem = date('y-m-d')."".time()."".$imagem;
                move_uploaded_file($imagem_tmp,"images/slider/$imagem");
                $query->bindParam(':titulo',$titulo, PDO::PARAM_STR);
                $query->bindParam(':conteudo',$conteudo, PDO::PARAM_STR);
                $query->bindParam(':imagem',$imagem, PDO::PARAM_STR);
                $query->bindParam(':user_id',$user_id, PDO::PARAM_INT);
                $result = $query->execute();
                $ultimoId = $conn->lastInsertId();
                if($ultimoId){
                    header("location:slider.php?result=SUCESSO!");
                }else{
                    echo "ERROR AO REGISTRAR SERVICO!";
                }
            }else{
                header("location:../login.php");
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
                                <h3 class="box-title mb-0">ADICIONAR NOVO SLIDER</h3>
                            </div>
                            <div class="d-md-flex mb-3">
                                <form class="form-horizontal form-material" method="post" action="" enctype="multipart/form-data">
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" for="name">Titulo</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="Titulo" name="titulo"
                                                class="form-control p-0 border-0" id="titulo" required> 
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="short_desc" class="col-md-12 p-0">Descricao Curta</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="Esta descricao sera mostrada logo no inicio"
                                                class="form-control p-0 border-0" name="conteudo"
                                                id="short_desc" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0" for="image">Imagem</label>
                                        <div class="col-sm-12 custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="image" required>
                                            <label class="custom-file-label" for="validatedCustomFile">SELECIONE UMA IMAGEM</label>
                                        </div>
                                    </div>
                                    <input type="hidden" class="custom-file-input" name="ms12rvw" value="soniatlam">                                    
                                    <button type="submit" name="submit" class="btn btn-primary float-right">Salvar</button>
                                </form>                        
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
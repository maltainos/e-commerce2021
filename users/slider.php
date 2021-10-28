<?php 
    include 'includes/header.php';
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
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <a href="slider_add.php" class="btn btn-primary my-2"><i class="fa fa-plus"></i> NOVO SLIDER</a>
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <div class="d-md-flex mb-3">
                                <h3 class="box-title mb-0">SLIDES ACTIVOS</h3>                   
                            </div>
                            <div class="table-responsive">
                                <table id="table_id" class="display" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">No.</th>
                                            <th class="border-top-0 text-center">IMAGEM</th>
                                            <th class="border-top-0">TITULO</th>
                                            <th class="border-top-0 text-center">ESTADO</th>
                                            <th class="border-top-0 text-center">ACCAO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM slider";                                            
                                            $query = $conn->prepare($sql);
                                            $query->execute();
                                            $resultSet = $query->fetchAll(PDO::FETCH_OBJ);
                                            $count = 1;
                                            foreach($resultSet as $result):?>
                                                <tr>
                                                    <td><?php echo $count ?></td>
                                                    <td class='txt-oflo text-center'>
                                                        <img class='img-fluid' width='60' 
                                                        src="images/slider/<?php echo$result->imagem;?>" alt="<?php echo $result->titulo?>">
                                                    </td>
                                                    <td class="txt-oflo">
                                                        <?php echo $result->titulo ?></td>
                                                    <td class='txt-oflo text-center'>
                                                        <?php echo $result->status ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="btn btn-default" title="Activar Slider Principal" href="slider_active.php?id=<?php echo $result->id ?>">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-success" title="Detalhes" href="slider_details.php?id=<?php echo $result->id;?>">
                                                            <i class="fa fa-plus"></i>
                                                        </a>  
                                                        <a class="btn btn-primary" title="Editar" href="slider_edit.php?id=<?php echo $result->id ?>">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a class="btn btn-danger" title="Remover" href="slider_delete.php?id=<?php echo $result->id ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php $count++; endforeach; ?>
                                    </tbody>
                                </table>
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
<?php include 'includes/footer.php'?>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#table_id').DataTable({
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
</body>

</html>
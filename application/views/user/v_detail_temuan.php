<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/dist/css/bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/adminlte/dist/css/adminlte.min.css">
  <style>
    .img-audit{
      height: 100px !important;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url(); ?>home/form" class="nav-link" target="_blank">Form Audit 5R</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Pemberitahuan</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 15 update audit baru
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>auth/logout" role="button">
          <i class="fas fa-power-off"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="<?= base_url(); ?>assets/adminlte/index3.html" class="brand-link">
      <img src="<?= base_url(); ?>assets/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">User AUDIT 5R</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        
      <!-- Sidebar user -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url(); ?>assets/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="" class="d-block"><?= strtoupper($this->session->userdata("username")); ?></a>
        </div>
      </div>
      <!-- /.Sidebar user -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="<?= base_url(); ?>user/" class="nav-link active">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Data Audit
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>user/ref_audit" class="nav-link">
              <i class="nav-icon fas fa-random"></i>
              <p>
                Temuan Referensi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>user/jadwal" class="nav-link">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Jadwal Audit
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>user/lk" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Ketidaksesuaian
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>user/ranking" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Ranking
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- /.Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Data Audit 5R</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('user/'); ?>">Data Audit</a></li>
              <li class="breadcrumb-item active">Detail Data Audit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Detail Data Audit Per Temuan</h3>
              </div>
              <!-- /.card-header -->

              <?php foreach($temuan as $row): ?>

              <!-- form start -->
              <form class="form-horizontal">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Tanggal Audit</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" disabled value="<?= $row->tgl_audit; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Area Audit</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" disabled value="<?= $row->kd_lok_audit; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Kategori 5R Audit</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" disabled value="<?= $row->kd_5r_audit; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Aspek Temuan Audit</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" disabled value="<?= $row->desk_aspek; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Temuan Audit</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" disabled value="<?= $row->desk_pt; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Keterangan/Lokasi Audit</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" disabled value="<?= $row->ket_audit; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Jumlah Temuan Audit</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" disabled value="<?= $row->jlh_tem_audit; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Gambar Temuan & Sesudah Audit</label>
                    <div class="col-sm-4">
                      <button id="img-temuan" type="button" data-toggle="modal" data-target="#exampleModal" data-id="<?= $row->id_audit; ?>">
                        <img id="img_audit" class="img-thumbnail rounded" src="<?= $SITE_URL.'/temuan_audit/' ?><?= json_decode($row->gambar,true)[0]; ?>" alt="gambar-temuan">
                      </button>
                    </div>
                    <div class="col-sm-4">
                      <?php if($row->gambar_sesudah != '0') { ?>
                        <button id="img-temuan2" type="button" data-toggle="modal" data-target="#exampleModal1" data-id2="<?= $row->id_audit; ?>">
                          <img id="img_audit2" class="img-thumbnail rounded" src="<?= $SITE_URL.'/temuan_audit/' ?><?= json_decode($row->gambar_sesudah,true)[0]; ?>" alt="gambar-sesudah">
                        </button>
                      <?php } else { ?>
                        <img id="img_audit" class="img-thumbnail rounded" src="" alt="gambar-sesudah-belum-ada">
                      <?php }  ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Rekomendasi</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" disabled><?= $row->rekomendasi; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Auditor</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" disabled value="<?php
                        $i=0;
                        $auditors = json_decode($row->tim_audit);
                        while($i < count($auditors)){
                          echo ($i+1).". ".$auditors[$i].", ";
                          $i++;
                        }
                        ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Status Temuan Audit</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" disabled value="<?= ($row->status == 'f') ? "OPEN" : "CLOSED" ; ?>">
                    </div>
                  </div>
                </div>
              </form>

              <?php endforeach; ?>

            </div>
            <!-- /.card -->

          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <?php include (APPPATH.'views/footer/footer.php'); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Modal Detail Gambar Temuan -->
  <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Gambar Temuan</h5>
          <button type="button" class="close btnClose" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div id="imgSlide" class="carousel-inner">
              <div class="carousel-item active">
                <img id="firstImg" class="d-block w-100" src="" alt="Gambar Temuan">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btnClose" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Detail Gambar Temuan -->

  <!-- Modal Detail Gambar Sesudah -->
  <div class="modal fade bd-example-modal-lg" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Gambar Sesudah</h5>
          <button type="button" class="close btnClose" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
          <div id="carouselExampleControls1" class="carousel slide" data-ride="carousel">
            <div id="imgSlide2" class="carousel-inner">
              <div class="carousel-item active">
                <img id="firstImg2" class="d-block w-100" src="" alt="Gambar Temuan">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls1" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls1" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btnClose" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Detail Gambar Temuan -->
  
  

  <!-- Modal Update Rekomendasi -->
  <div class="modal fade bd-example-modal-lg" id="update-gs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Rekomendasi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url(); ?>user/update_gbr" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="rekom">Gambar Sesudah</label>
              <input type="hidden" name="id_audit" class="form-control" id="id_audit">
              <input type="file" class="form-control" name="gambar" id="gambar_sesudah" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="simpanUK">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Update Rekomendasi -->

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url(); ?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(); ?>assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url(); ?>assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/adminlte/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url(); ?>assets/adminlte/dist/js/demo.js"></script>
<!-- Sweetalert -->
<script src="<?= base_url(); ?>assets/sweetalert/sweetalert.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  $(document).on("click", "#img-temuan", function () {
    const bu = window.location.origin + "/temuan_audit/";
    const base_url = window.location.origin + "/audit/";
    var idImg = $(this).data("id");

    $.ajax({
      type: 'POST',
      url: base_url + "user/getImg",
      data: {data: idImg},
      cache: false,
      success: function(msg){
        var data_gbr = JSON.parse(msg);
        var iter = 0;
        while (iter < JSON.parse(data_gbr).length) {
          $("#imgSlide").append(
            "<div class='carousel-item s_img'><img class='d-block w-100' src='"+bu+JSON.parse(data_gbr)[iter]+"' alt='Gambar Temuan "+iter+"'></div>"
          );
          iter++;
        }
        $("#firstImg").attr("src", bu+JSON.parse(data_gbr)[0]);
      }
    });
  });

  $(document).on("click", ".btnClose", function () {
    location.reload();
  });

  $(document).on("click", "#img-temuan2", function () {
    const bu = window.location.origin + "/temuan_audit/";
    const base_url = window.location.origin + "/audit/";
    var idImg = $(this).data("id2");

    $.ajax({
      type: 'POST',
      url: base_url + "user/getImgSesudah",
      data: {data: idImg},
      cache: false,
      success: function(msg){
        var data_gbr = JSON.parse(msg);
        var iter = 0;
        while (iter < JSON.parse(data_gbr).length) {
          $("#imgSlide2").append(
            "<div class='carousel-item s_img'><img class='d-block w-100' src='"+bu+JSON.parse(data_gbr)[iter]+"' alt='Gambar Temuan "+iter+"'></div>"
          );
          iter++;
        }
        $("#firstImg2").attr("src", bu+JSON.parse(data_gbr)[0]);
      }
    });
  });


  $(document).on("click", "#img-sesudah", function () {
    const bu1 = window.location.origin + "/temuan_audit/";
    var id1 = $(this).data("id_");
    var gambar = bu1+id1;

    $("#img-sesudah-if").attr("src", gambar);
  });

  

  $(document).on("click", "#update-temuan", function () {
    var id_aud = $(this).data("id_aud");
    var gs = $(this).data("gs");

    $("#id_audit").val(id_aud);
    $("#gambar_sesudah").val(gs);
  });

  $('#simpanUK').click(function(){
    return confirm('Apakah anda yakin update rekomendasi?');
  });
</script>
</body>
</html>

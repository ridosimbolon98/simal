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
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/adminlte/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/custom/st_dm.css">

  <style>
    .img-audit{
      height: 100px !important;
      width: 100px !important;
    }
    .ib_success:hover{
      background-color: #28A745 !important;
      color: #fff !important;
    }
    .ib_warning:hover{
      color: #fff !important;
      background-color: #ffc107 !important;
    }
    .ib_info:hover{
      color: #fff !important;
      background-color: #46A2B8 !important;
    }

    .ib_info a:hover {
      color:#fff !important;
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
            <h1>Data Audit 5R</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
              <li class="breadcrumb-item active">Data Audit</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="mb-3">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box ib_success">
                <span class="info-box-icon bg-success"><i class="fas fa-unlock-alt"></i></span>
                <a class="bg_mt" href="<?= base_url('user/otorisasi'); ?>">
                  <div id="dept-widget" class="info-box-content">
                    <span class="info-box-text">Halaman Otorisasi Audit</span>
                    <span class="info-box-number"><?= $jlh_otor; ?> Item Temuan</span>
                  </div>
                </a>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box ib_warning">
                <span class="info-box-icon bg-warning"><i class="fas fa-random"></i></span>
                <a class="bg_mt" href="<?= base_url('user/ref_temuan'); ?>">
                  <div id="dept-widget" class="info-box-content">
                    <span class="info-box-text">Halaman Referensi Audit</span>
                    <span class="info-box-number"><?= $jlh_refa ?> Referensi</span>
                  </div>
                </a>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box ib_info">
                <span class="info-box-icon bg-info"><i class="fas fa-book"></i></span>
                <a class="bg_mt" href="<?= base_url('user/'); ?>">
                  <div id="dept-widget" class="info-box-content">
                    <span class="info-box-text">Halaman Temuan Audit</span>
                    <span class="info-box-number"><?= $jlh_temuan[0]->total ?> Temuan Open</span>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Table Audit 5R Area <?= $area; ?> | <span class="text-info">(Sudah di Otorisasi)</span></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Tgl Audit</th>
                      <th>Temuan</th>
                      <th>Keterangan</th>
                      <th>Gbr Temuan</th>
                      <th>Tim Audit</th>
                      <th>Status</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($audit as $row): ?>
                    <tr>
                      <td class="text-center"><?= $no++; ?></td>
                      <td><?= substr($row->tgl_audit,0,16) ?></td>
                      <td><?= $row->desk_pt ?></td>
                      <td><?= $row->ket_audit ?></td>
                      <td class="text-center">
                        <button id="img-temuan" type="button" data-toggle="modal" data-target="#exampleModal" data-id="<?= $row->id_audit; ?>">
                          <img id="img_audit" class="img-audit" src="<?= $SITE_URL.'/temuan_audit/' ?><?= json_decode($row->gambar,true)[0]; ?>" alt="gambar-temuan">
                        </button>
                      </td>
                      <td>
                        <?php
                        $i=0;
                        $auditors = json_decode($row->tim_audit);
                        while($i < count($auditors)){
                          echo ($i+1).". ".$auditors[$i]."<br>";
                          $i++;
                        }
                        ?>
                      </td>
                      <td class="text-center"><?= ($row->status == 'f') ? "OPEN" : "CLOSED" ; ?></td>
                      <td class="text-center d-flex justify-content-between">
                        <a id="btn-rt" class="btn btn-sm btn-info mr-1" href="javascript:;" data-toggle="modal" data-target="#ref-temuan" data-id_aud="<?= $row->id_audit; ?>"><i class="fa fa-random text-white" data-toogle="tooltip" title="Referensi Temuan"></i> </a> 
                        <a class="btn btn-sm btn-success" href="<?= base_url(); ?>user/detail_temuan/<?= $row->id_audit; ?>" data-toogle="tooltip" title="Detail Temuan"><i class="fa fa-list text-white"></i></a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
              </div>
            </div>
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
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img class="img-fluid rounded" id="img-sesudah-if" src="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Detail Gambar Temuan -->
  
  <!-- Modal Update Refensi Temuan -->
  <div class="modal fade bd-example-modal-lg" id="ref-temuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Referensi Temuan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url(); ?>user/add_ref" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="rekom">Referensi Bagian</label>
              <input type="hidden" name="id_audit" class="form-control" id="id_audit">
              <select name="referensi" id="" class="form-control" required>
                <option value="" disabled selected>--Pilih Referensi Bagian--</option>
                <?php foreach ($dept as $row): ?>
                  <option value="<?= $row->bagian_dept ?>" ><?= $row->bagian_dept ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="rekom">Alasan Referensi</label>
              <textarea class="form-control" name="alasan" id="" cols="30" rows="10" required></textarea>
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
  <!-- End Update Refensi Temuan -->

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
<!-- Toastr -->
<script src="<?= base_url(); ?>assets/adminlte/plugins/toastr/toastr.min.js"></script>
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

  $(document).on("click", "#img-sesudah", function () {
    const bu1 = window.location.origin + "/temuan_audit/";
    var id1 = $(this).data("id_");
    var gambar = bu1+id1;

    $("#img-sesudah-if").attr("src", gambar);
  });

  $(document).on("click", "#btn-rt", function () {
    var id_aud = $(this).data("id_aud");
    $("#id_audit").val(id_aud);
  });

  $('#simpanUK').click(function(){
    return confirm('Apakah anda yakin tambah referensi temuan?');
  });
</script>

<script>
  <?php if($this->session->flashdata('success')){ ?>
    toastr.success("<?php echo $this->session->flashdata('success'); ?>");
  <?php }else if($this->session->flashdata('error')){  ?>
    toastr.error("<?php echo $this->session->flashdata('error'); ?>");
  <?php }else if($this->session->flashdata('warning')){  ?>
    toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
  <?php }else if($this->session->flashdata('info')){  ?>
    toastr.info("<?php echo $this->session->flashdata('info'); ?>");
  <?php } ?>
</script>
</body>
</html>

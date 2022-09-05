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
  <!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/multi-select/dist/css/BsMultiSelect.min.css"> -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/custom/bootstrap/css/bootstrap-select.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/adminlte/plugins/toastr/toastr.min.css">
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
    <a href="<?= base_url(); ?>" class="brand-link">
      <img src="<?= base_url(); ?>assets/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin AUDIT 5R</span>
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
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url(); ?>admin" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url(); ?>admin/db2" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">MASTER DATA</li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/pabrik" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Audit Pabrik
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/non_pabrik" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Audit Non-Pabrik
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/user" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Data User
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/auditor" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Data Auditor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/jadwal" class="nav-link active">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Data Jadwal
              </p>
            </a>
          </li>
          <li class="nav-header">LAPORAN</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Monitoring Audit
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url(); ?>admin/mt_pabrik" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pabrik</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url(); ?>admin/mt_nonpabrik" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Non-Pabrik</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/lap" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Ketidaksesuaian
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/pareto" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Pareto Temuan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/ranking" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Ranking
              </p>
            </a>
          </li>
        </ul>
      </nav>

    </div>
  </aside>
  <!-- /.Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Jadwal Audit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
              <li class="breadcrumb-item active">Data Jadwal</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="mb-1">
          <button class="btn btn-info mr-2 mb-2" data-toggle="modal" data-target="#add-jadwal"><i class="fa fa-plus"></i> Tambah Jadwal Audit Baru</button>
          <a href="http://192.168.10.30:8000/send-jadwal" class="btn btn-success mr-2 mb-2" target="_blank">Kirim Notif Whatsapp Jadwal Audit</a>
        </div>
        <div class="my-1">
          <!-- Filter Periode -->
          <form class="form-inline" action="<?= base_url(); ?>admin/jadwal" method="post">
            <div class="form-group mb-2">
            <label class="mr-2 mb-2">Pilih Periode</label>
            <input type="month" name="periode" class="form-control form-control-sm mr-2 mb-2" required>
            <button type="submit" class="btn btn-info btn-sm mb-2"><i class="fa fa-filter"></i> Tampilkan</button>
            </div>
          </form>
        </div>

        <div class="mb-2">
          <div class="row">
            <div class="col-md-6">
              <!-- Pabrik Donut Chart -->
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    Chart Jadwal Pabrik
                  </h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div id="p-chart" style="height: 200px;"></div>
                </div>
              </div>
              <!-- End Pabrik Donut Chart -->
            </div>
            <div class="col-md-6">
              <!-- Non Pabrik Donut Chart -->
              <div class="card card-warning card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    Chart Jadwal Non-Pabrik
                  </h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div id="np-chart" style="height: 200px;"></div>
                </div>
              </div>
              <!-- End Non Pabrik Donut Chart -->
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Jadwal Audit Pabrik Periode: <?= $periode; ?></h3>
              </div>

              <div class="card-body">
                <table id="jap" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                      <th>Kode</th>
                      <th>Jadwal</th>
                      <th>Area</th>
                      <th>Realisasi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($jap as $row): ?>
                    <tr class="text-center">
                      <td class="text-center"><?= $row->kd_jadwal; ?></td>
                      <td><?= $row->tgl_audit ?></td>
                      <td><?= $row->area_dept ?></td>
                      <td><?= $row->realisasi_audit ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Jadwal Audit Non-Pabrik Periode: <?= $periode; ?></h3>
              </div>

              <div class="card-body">
                <table id="janp" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                      <th>Kode</th>
                      <th>Tgl & Waktu</th>
                      <th>Area</th>
                      <th>Realisasi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($janp as $row): ?>
                    <tr class="text-center">
                      <td class="text-center"><?= $row->kd_jadwal; ?></td>
                      <td><?= $row->tgl_audit ?></td>
                      <td><?= $row->area_dept ?></td>
                      <td><?= $row->realisasi_audit ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Detail Jadwal Audit Periode: <?= $periode; ?></h3>
              </div>

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                      <th>Kode</th>
                      <th>Jadwal</th>
                      <th>Area</th>
                      <th>Auditie</th>
                      <th>Auditor</th>
                      <th>Realisasi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($jadwal as $row): ?>
                    <tr class="text-center">
                      <td class="text-center"><?= $row->kd_jadwal; ?></td>
                      <td><?= $row->tgl_audit ?></td>
                      <td><?= $row->area ?></td>
                      <td><?= $row->area_dept ?></td>
                      <td><?= $row->username . ',' . preg_replace("/[^a-zA-Z0-9,]/", "", $row->auditor); ?></td>
                      <td><?= ($row->realisasi == 'f') ? "<span class='text-danger'>BELUM</span>" : "<span class='text-success'>SUDAH</span>" ; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->


  <?php include (APPPATH.'views/footer/footer.php'); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  
  <!-- Modal Add Jadwal -->
  <div class="modal fade bd-example-modal-lg" id="add-jadwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url(); ?>admin/addJadwal" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="date_time">Tanggal Audit</label>
              <input type="date" name="date_time" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="area">Area Audit</label>
              <select id="area" class="form-control" name="area" required>
                <option value="" disabled-selected>--Pilih Area Audit--</option>
                  <option value="PABRIK">PABRIK</option>
                  <option value="NON-PABRIK">NON-PABRIK</option>
              </select>
            </div>
            <div class="form-group">
              <label for="auditee">Section Auditee</label>
              <select id="section" class="form-control" name="auditee" required>
                <option value="" disabled-selected>--Pilih Section--</option>
              </select>
              <small id="ds"></small>
            </div>
            <div class="form-group">
              <label for="koordinator">Koordinator</label>
              <select name="koordinator" class="form-control" id="koordinator" aria-label="koordinator" required>
                <option value="" disabled selected>--Pilih Koordinator Audit--</option>
                <?php foreach($user as $row): ?>
                  <option value="<?= $row->id_user; ?>"><?= strtoupper($row->nama); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="auditor">Auditor</label>
              <div id="auditor" class="form-check">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Add Jadwal -->

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url(); ?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/bootstrap/dist/js/popper.min.js"></script>
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
<!-- <script src="<?= base_url(); ?>assets/multi-select/dist/js/BsMultiSelect.min.js"></script> -->
<script src="<?= base_url(); ?>assets/custom/bootstrap/js/bootstrap-select.min.js"></script>
<!-- FLOT CHARTS -->
<script src="<?= base_url(); ?>assets/adminlte/plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?= base_url(); ?>assets/adminlte/plugins/flot/plugins/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?= base_url(); ?>assets/adminlte/plugins/flot/plugins/jquery.flot.pie.js"></script>
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
    $("#jap").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });
    $("#janp").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });
  });
</script>

<script>
  let base_url = window.location.origin + "/audit/";
  let area     = document.getElementById("area");
  let section  = document.getElementById("section");
  let koor     = document.getElementById("koordinator");

  area.addEventListener("input", () => {
      $(".s_sect").remove();
      var data_lok = area.value;
      $.ajax({
          type: 'POST',
          url: base_url + "admin/getSect",
          data: {data: data_lok},
          cache: false,
          success: function(msg){
              var data = JSON.parse(msg);
              var iter = 0;
              while (iter < data.length) {
                  $("#section").append(
                      "<option class='s_sect' value='" +
                          data[iter].kd_section +
                          "'>" +
                          data[iter].nama_section + " - " + data[iter].area_section +
                          "</option>"
                  );
                  iter++;
              }
          }
      });
  });

  section.addEventListener("input", () => {
      $(".s_dept").remove();
      var data_sect = section.value;
      $.ajax({
          type: 'POST',
          url: base_url + "admin/getDept",
          data: {data: data_sect},
          cache: false,
          success: function(msg){
              var data = JSON.parse(msg);
              var iter = 0;
              while (iter < data.length) {
                  $("#ds").append(
                    "<span class='text-info font-weight-light s_dept'>"+ data[iter].area_dept +', '+"</span>"
                  );
                  iter++;
              }
          }
      });
  });

  koor.addEventListener("input", () => {
      $(".s_auditor").remove();
      var data_koor = koor.value;
      $.ajax({
          type: 'POST',
          url: base_url + "admin/getAuditor",
          data: {data: data_koor},
          cache: false,
          success: function(msg){
              console.log(msg);
              var data = JSON.parse(msg);
              var iter = 0;
              console.log(data[0].id_auditor);
              console.log(data[0].nama_auditor);
              while (iter < data.length) {
                  $("#auditor").append(
                    "<input id='auditor"+iter+"' type='checkbox' class='form-check-input' name='auditor[]' value='"+data[iter].nama_auditor+"'>"+
                    "<label class='form-check-label' for='auditor"+iter+"'>"+data[iter].nama_auditor+"</label>"+
                    "<br>"
                  );
                  iter++;
              }
          }
      });
  });

</script>
<script>
  var pData = [
    {
      label: 'Sudah',
      data : <?= $jp_true ?>,
      color: '#3c8dbc'
    },
    {
      label: 'Belum',
      data : <?= $jp_false ?>,
      color: '#0073b7'
    }
  ];

  var npData = [
    {
      label: 'Sudah',
      data : <?= $jnp_true ?>,
      color: '#d39e33'
    },
    {
      label: 'Belum',
      data : <?= $jnp_false ?>,
      color: '#8e6410'
    }
  ];

    $.plot('#p-chart', pData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.3,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    });

    $.plot('#np-chart', npData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.3,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    });

  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }
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

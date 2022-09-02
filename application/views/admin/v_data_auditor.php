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
            <a href="<?= base_url(); ?>admin/auditor" class="nav-link active">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Data Auditor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/jadwal" class="nav-link">
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
            <h1>Data Auditor</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
              <li class="breadcrumb-item active">Data Auditor</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="mb-3">
          <button class="btn btn-info mr-2" data-toggle="modal" data-target="#add-auditor"><i class="fa fa-plus"></i> Tambah Auditor</button>
          <button class="btn btn-secondary mr-2" data-toggle="modal" data-target="#map-auditor"><i class="fa fa-share"></i> Mapping Auditor</button>
        </div>

        <div class="row">

          <!-- Data Auditor -->
          <div class="col-md-6 col-sm-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Tabel Data Auditor</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Nama</th>
                      <th>Area</th>
                      <th>Level</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($auditor as $row): ?>
                    <tr>
                      <td class="text-center"><?= $no++; ?></td>
                      <td><?= $row->nama_auditor ?></td>
                      <td><?= $row->area_auditor ?></td>
                      <td><?= $row->level_auditor ?></td>
                      <td class="text-center">
                        <a id="update_auditor" class="btn btn-sm btn-primary" href="javascript:;" data-toggle="modal" data-target="#update-auditor" data-id="<?= $row->id_auditor; ?>" data-nama="<?= $row->nama_auditor; ?>" data-area="<?= $row->area_auditor; ?>" data-level="<?= $row->level_auditor; ?>"> Edit</a>
                        <a class="btn btn-sm btn-danger" href="<?= base_url(); ?>admin/deleteAuditor/<?= $row->id_auditor; ?>" onclick="return confirm('Apakah anda yakin hapus Auditor ini?');"> Delete</a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
              </div>
            </div>
          </div>
          <!-- End Data Auditor -->

          <!-- Data Mapped Auditor -->
          <div class="col-md-6 col-sm-12">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Tabel Data Mapping Auditor</h3>
              </div>
              <div class="card-body">
                <table id="map_auditor" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Nama</th>
                      <th>Koordinator</th>
                      <th>Area</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($map_adt as $row): ?>
                    <tr>
                      <td class="text-center"><?= $no++; ?></td>
                      <td><?= $row->nama_auditor ?></td>
                      <td><?= $row->nama ?></td>
                      <td><?= $row->area_ma ?></td>
                      <td class="text-center">
                        <a id="update_map_aud" class="btn btn-sm btn-primary" href="javascript:;" data-toggle="modal" data-target="#update-map-aud" data-idmap="<?= $row->id_ma; ?>" data-id_auditor="<?= $row->id_auditor; ?>" data-id_koor="<?= $row->id_koor; ?>"> Edit</a>
                        <a class="btn btn-sm btn-danger" href="<?= base_url(); ?>admin/deleteMapAuditor/<?= $row->id_ma; ?>" onclick="return confirm('Apakah anda yakin hapus map auditor ini?');"> Delete</a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
              </div>
            </div>
          </div>
          <!-- End Data Mapped Auditor -->

        </div>

      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->


  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0 Beta
    </div>
    <strong>Developt by IT NBI &copy; 2022 </strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  
  <!-- Modal Add Auditor -->
  <div class="modal fade bd-example-modal-lg" id="add-auditor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Auditor Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url(); ?>admin/addAuditor" method="post">
          <div class="modal-body">
            <div class="card card-info">
              <div class="card-body">
                <div class="form-group">
                  <label for="nama">Nama Auditor</label>
                  <input type="text" name="nama" class="form-control" placeholder="Input nama user" required autofocus>
                </div>
                <div class="form-group">
                  <label for="area">Area Auditor</label>
                  <select class="form-control" name="area" id="" required>
                    <option value="" disabled-selected>--Pilih Area--</option>
                    <option value="PABRIK" >PABRIK</option>
                    <option value="NON-PABRIK" >NON-PABRIK</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="level">Level Auditor</label>
                  <select class="form-control" name="level" id="" required>
                    <option value="" disabled-selected>--Pilih Level Auditor--</option>
                    <option value="KOORDINATOR" >KOORDINATOR</option>
                    <option value="ANGGOTA" >ANGGOTA</option>
                  </select>
                </div>
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
  <!-- End Modal Add Auditor -->

  <!-- Modal Update Data Auditor -->
  <div class="modal fade bd-example-modal-lg" id="update-auditor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="exampleModalLabel">Update Data Auditor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url(); ?>admin/editAuditor" method="post">
          <div class="modal-body">
            <div class="card card-info">
              <div class="card-body">
                <div class="form-group">
                  <label for="nama">Nama Auditor</label>
                  <input type="hidden" name="id_auditor" class="form-control" id="id_auditor">
                  <input type="text" name="nama" class="form-control" id="nama" required autofocus>
                </div>
                <div class="form-group">
                  <label for="area">Area Auditor</label>
                  <select class="form-control" name="area" id="area" required>
                    <option value="" disabled-selected>--Pilih Area--</option>
                    <option value="PABRIK" >PABRIK</option>
                    <option value="NON-PABRIK" >NON-PABRIK</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="level">Level Auditor</label>
                  <select class="form-control" name="level" id="level" required>
                    <option value="" disabled-selected>--Pilih Level Auditor--</option>
                    <option value="KOORDINATOR" >KOORDINATOR</option>
                    <option value="ANGGOTA" >ANGGOTA</option>
                  </select>
                </div>
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
  <!-- End Modal Update Data Auditor -->

  <!-- Modal Map Auditor -->
  <div class="modal fade bd-example-modal-lg" id="map-auditor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-secondary">
          <h5 class="modal-title" id="exampleModalLabel">Mapping Auditor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url(); ?>admin/mapAuditor" method="post">
          <div class="modal-body">
            <div class="card card-info">
              <div class="card-body">
                <div class="form-group">
                  <label for="auditor">Auditor</label>
                  <select class="form-control" name="auditor" id="" required>
                    <option value="" disabled-selected>--Pilih Auditor--</option>
                    <?php foreach($auditor as $row): ?>
                      <option value="<?= $row->id_auditor ?>" ><?= strtoupper($row->nama_auditor) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="koordinator">Koordinator Auditor</label>
                  <select class="form-control" name="koordinator" id="" required>
                    <option value="" disabled-selected>--Pilih Koordinator--</option>
                    <?php foreach($koor_aud as $row): ?>
                      <option value="<?= $row->id_user ?>" ><?= strtoupper($row->nama) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
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
  <!-- End Modal Map Auditor -->

  <!-- Modal Update Map Auditor -->
  <div class="modal fade bd-example-modal-lg" id="update-map-aud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-secondary">
          <h5 class="modal-title" id="exampleModalLabel">Update Data Mapping Auditor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url(); ?>admin/updateMapAuditor" method="post">
          <div class="modal-body">
            <div class="card card-info">
              <div class="card-body">
                <div class="form-group">
                  <label for="auditor">Auditor</label>
                  <input type="hidden" name="id_map" class="form-control" id="id_map">
                  <select class="form-control" name="auditor" id="auditor" required>
                    <option value="" disabled-selected>--Pilih Auditor--</option>
                    <?php foreach($auditor as $row): ?>
                      <option value="<?= $row->id_auditor ?>" ><?= strtoupper($row->nama_auditor) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="koordinator">Koordinator Auditor</label>
                  <select class="form-control" name="koordinator" id="koordinator" required>
                    <option value="" disabled-selected>--Pilih Koordinator--</option>
                    <?php foreach($koor_aud as $row): ?>
                      <option value="<?= $row->id_user ?>" ><?= strtoupper($row->nama) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
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
  <!-- End Modal Update Map Auditor -->

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
<!-- Toastr -->
<script src="<?= base_url(); ?>assets/adminlte/plugins/toastr/toastr.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#map_auditor').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>

<script>
$(document).on("click", "#update_auditor", function () {
	var id       = $(this).data("id");
	var nama     = $(this).data("nama");
	var area     = $(this).data("area");
	var level    = $(this).data("level");

	$("#id_auditor").val(id);
	$("#nama").val(nama);
	$("#area").val(area);
	$("#level").val(level);
});

$(document).on("click", "#update_map_aud", function () {
	var idmap      = $(this).data("idmap");
	var id_auditor = $(this).data("id_auditor");
	var id_koor    = $(this).data("id_koor");

	$("#id_map").val(idmap);
	$("#auditor").val(id_auditor);
	$("#koordinator").val(id_koor);
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

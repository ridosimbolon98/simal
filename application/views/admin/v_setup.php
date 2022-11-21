<?php include (APPPATH.'views/admin/components/header.php'); ?>

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
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="">
          <i class="fas fa-user"></i> 
          <?= strtoupper($this->session->userdata('username')) ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>auth/logout" role="button" onclick="return confirm('Apakah anda yakin untuk keluar dari sistem?')">
          <i class="fas fa-power-off"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="<?= base_url('admin'); ?>" class="brand-link">
      <img src="<?= base_url(); ?>assets/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin SIMAL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-header">MASTER DATA</li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/user" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Data Admin
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/customer" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Pelanggan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/setup" class="nav-link active">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Pengaturan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/griya" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Griya
              </p>
            </a>
          </li>
          <li class="nav-header">LAPORAN</li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/kartu" class="nav-link">
              <i class="nav-icon far fa-file-pdf"></i>
              <p>
                Kartu Pelanggan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(); ?>admin/aka" class="nav-link">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                Input AKA
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- sidebar-menu -->

    </div>
    <!-- Sidebar -->
  </aside>
  <!-- Main Sidebar Container -->

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Pengaturan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Data Pengaturan</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tabel Data Pengaturan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                      <th>ID</th>
                      <th>Jenis</th>
                      <th>Tipe</th>
                      <th>Nilai</th>
                      <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($setup as $row): ?>
                    <tr class="text-center">
                      <td><?= $row->sid ?></td>
                      <td><?= $row->trx ?></td>
                      <td><?= $row->tipe ?></td>
                      <td>
                      <?php 
                        if($row->trx == 'BIAYA'){
                          echo "Rp ". number_format($row->nilai,2,",","."); 
                        } else {
                          echo $row->nilai; 
                        }
                      ?>
                      </td>
                      <td class="text-center">
                        <a id="update_setup" class="btn btn-sm btn-primary" href="javascript:;" data-toggle="modal" data-target="#update-setup" data-sid="<?= $row->sid; ?>" data-trx="<?= $row->trx; ?>" data-tipe="<?= $row->tipe; ?>" data-nilai="<?= $row->nilai; ?>"><i class="fa fa-pen-square text-light"></i> Edit</a>
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

  
  
</div>
<!-- ./wrapper -->


<!-- Modal Update Setup -->
<div class="modal fade bd-example-modal-lg" id="update-setup" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Pengaturan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url(); ?>admin/update_setup" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="nama">ID</label>
            <input type="hidden" name="sid" class="form-control" id="sid">
            <input type="text" class="form-control" disabled id="sid1">
          </div>
          <div class="form-group">
            <label for="trx">Jenis</label>
            <input type="text" name="trx" class="form-control" id="trx" required>
          </div>
          <div class="form-group">
            <label for="tipe">Tipe</label>
            <input type="text" name="tipe" class="form-control" id="tipe" required>
          </div>
          <div class="form-group">
            <label for="nilai">Nilai</label>
            <input type="text" name="nilai" class="form-control" id="nilai" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin update data setup ini?')"><i class="fa fa-save text-white"></i> Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle text-white"></i> Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Update User -->


<!-- Script File -->
<?php include (APPPATH.'views/admin/components/scripts.php'); ?>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });

</script>

<script>
$(document).on("click", "#update_setup", function () {
	var sid   = $(this).data("sid");
	var trx   = $(this).data("trx");
	var tipe  = $(this).data("tipe");
	var nilai = $(this).data("nilai");

	$("#sid").val(sid);
	$("#sid1").val(sid);
	$("#trx").val(trx);
	$("#tipe").val(tipe);
	$("#nilai").val(nilai);
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

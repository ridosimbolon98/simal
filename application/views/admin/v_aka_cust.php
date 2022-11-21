<?php include (APPPATH.'views/admin/components/header.php'); ?>

<style>
  .img-audit{
    height: 100px !important;
  }
  .btn-aka{
    min-width: 100px;
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
            <a href="<?= base_url(); ?>admin/setup" class="nav-link">
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
            <a href="<?= base_url(); ?>admin/aka" class="nav-link active">
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
            <h1>Data AKA Pelanggan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Data AKA Pelanggan</li>
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
                <h3 class="card-title">Tabel Data AKA Pelanggan</h3>
              </div>

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                      <th>No.</th>
                      <th>Nama</th>
                      <th>Griya</th>
                      <th>Alamat</th>
                      <th>Golongan</th>
                      <th>Periode</th>
                      <th>AKA Lalu</th>
                      <th>AKA Akhir</th>
                      <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;foreach($aka_cust as $row): ?>
                    <tr class="text-center">
                      <td><?= $no++ ?></td>
                      <td><?= $row->nama_cust ?></td>
                      <td><?= $row->nama_griya ?></td>
                      <td><?= $row->alamat_cust.', '.$row->alamat_griya ?></td>
                      <td><?= $row->golongan ?></td>
                      <td><?= $row->bulan.'-'.$row->periode ?></td>
                      <td><?= $row->aka_lalu ?></td>
                      <td><?= $row->aka_akhir ?></td>
                      <td class="text-center btn-aka">
                        <a id="input_aka" class="btn btn-sm btn-primary" 
                          href="javascript:;" 
                          data-toggle="modal" 
                          data-target="#input-aka" 
                          data-id_aka="<?= $row->id_aka; ?>" 
                          data-cid="<?= $row->cid; ?>" 
                          data-nama="<?= $row->nama_cust; ?>" 
                          data-griya_id="<?= $row->id_griya; ?>" 
                          data-griya_name="<?= $row->nama_griya; ?>" 
                          data-alamat_c="<?= $row->alamat_cust; ?>" 
                          data-alamat_g="<?= $row->alamat_griya; ?>" 
                          data-aka_akhir="<?= $row->aka_akhir; ?>" 
                          data-golongan="<?= $row->golongan; ?>">
                          <i class="fa fa-pen-square text-light"></i> Input AKA
                        </a>
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

<!-- Modal Add Aka -->
<div class="modal fade bd-example-modal-lg" id="input-aka" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Input AKA Pelanggan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('admin/input_new_aka') ?>" method="post">
        <div class="modal-body">
          <div class="form-group row">
            <label for="nama_cust" class="col-sm-2 col-form-label">ID Pelanggan</label>
            <div class="col-sm-10">
              <input type="hidden" name="cust_id" class="form-control" id="cust_id">
              <input type="text" readonly class="form-control" id="id_cust">
            </div>
          </div>
          <div class="form-group row">
            <label for="nama_cust" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control" id="nama_cust">
            </div>
          </div>
          <div class="form-group row">
            <label for="harga_pm" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
              <textarea type="text" readonly class="form-control" row="3" id="alamat_cust"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="biaya_mtc" class="col-sm-2 col-form-label">AKA Lalu</label>
            <div class="col-sm-10">
              <input type="number" readonly class="form-control" id="aka_lalu">
            </div>
          </div>
          <div class="form-group row">
            <label for="alamat_cust" class="col-sm-2 col-form-label">Periode</label>
            <div class="col-sm-10">
              <input type="text" hidden name="tahun" id="tahun1">
              <input type="text" hidden name="bulan" id="bulan1">
              <input type="text" readonly class="form-control"  id="periode_aka">
            </div>
          </div>
          <div class="form-group row">
            <label for="periode" class="col-sm-2 col-form-label">AKA Akhir</label>
            <div class="col-sm-10">
              <input type="number" name="aka_akhir" step="1" class="form-control" id="aka_akhir">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id=""><i class="fa fa-save text-light"></i> Submit</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle text-light"></i> Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Add Aka -->



<!-- Script File -->
<?php include (APPPATH.'views/admin/components/scripts.php'); ?>
<script src="<?= base_url(); ?>assets/js/moment-with-locales.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });

</script>

<script>
let base_url = window.location.origin + "/simal/";
$(document).on("click", "#input_aka", function () {
  var year        = "<?= $tahun ?>";
	var aka_id      = $(this).data("aka_id");
	var cid         = $(this).data("cid");
	var nama        = $(this).data("nama");
	var alamat_g    = $(this).data("alamat_g");
	var alamat_c    = $(this).data("alamat_c");
	var griya_id    = $(this).data("griya_id");
	var aka_akhir   = $(this).data("aka_akhir");

  $.ajax({
    type: 'POST',
    url: base_url + "admin/last_cust_aka",
    data: {cid: cid, tahun: year},
    cache: false,
    success: function(msg){
      var kmp_data = JSON.parse(msg);
      if ((kmp_data.length + 1) <= 12) {
        var next_month = (kmp_data.length + 1);
        var thn = year;
      } else {
        var next_month = '01';
        var thn = (parseInt(year)+1);
      }
      var per = moment().format(thn+'-'+next_month, 'YYYY-mm');
      $("#periode_aka").val(per);
      $("#bulan1").val(next_month);
      $("#tahun1").val(thn);
      $("#id_cust").val(cid);
      $("#cust_id").val(cid);
      $("#id_aka").val(aka_id);
      $("#nama_cust").val(nama);
      $("#alamat_cust").val(alamat_c +', '+ alamat_g);
      $("#aka_lalu").val(aka_akhir);
    }
  });
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

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
            <a href="<?= base_url(); ?>admin/kartu" class="nav-link active">
              <i class="nav-icon far fa-file-pdf"></i>
              <p>
                Kartu Pelanggan
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
            <h1>Data Kartu Pelanggan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
              <li class="breadcrumb-item active">Data Kartu Pelanggan</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="pb-2 px-2">
        <form action="<?= base_url('admin/kartu') ?>" method="post">
          <div class="row">
            <div class="col-sm-3">
              <input class="form-control form-sm" type="month" name="tahun" required>
            </div>
            <div class="col-sm-3">
              <select class="form-control form-sm" name="griya" id="griyaid" required>
                <option value="" disabled selected>-- Pilih Griya --</option>
                <?php foreach ($griya as $gry): ?>
                  <option value="<?= $gry->id ?>"><?= $gry->nama ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-sm-3">
              <select class="form-control form-sm" name="customer" id="idcust" required>
                <option value="" disabled selected>-- Pilih Pelanggan --</option>
              </select>
            </div>
            <div class="col-sm-2">
              <button type="submit" class="form-control btn btn-primary btn-sm">Filter</button>
            </div>
          </div>
        </form>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Kartu Palanggan Griya: <span id="flt_griya"><?= $filter_griya ?></span>, Tahun: <span id="flt_thn"><?= $tahun ?></span></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="py-3">
                  <?php 
                  if ($is_filter) {
                    foreach($customer as $cst): ?>
                    <div class="form-group row">
                      <label for="biaya" class="col-sm-2 col-form-label">Aksi</label>
                      <div class="col-sm-10">
                        <button id="btn_input_aka" class="btn btn-sm btn-info" 
                        data-cid="<?= $cst->cid ?>"
                        data-toggle="modal" 
                        data-target="#input-aka">
                        <i class="fa fa-plus-square text-white"></i> Input AKA</button>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext form-sm" id="nama" value="<?= $cst->nama ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                      <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext form-sm" id="alamat" value="<?= $cst->alamat ?>">
                      </div>
                    </div>
                    <?php endforeach; ?>
                  <div class="form-group row">
                    <label for="biaya" class="col-sm-2 col-form-label">Biaya (m3)</label>
                    <div class="col-sm-10">
                      <input type="text" readonly class="form-control-plaintext form-sm" id="biaya" value="<?php echo 'Rp '. number_format((int)$setup[0]->nilai,2,",","."); ?>">
                    </div>
                  </div>
                  <?php } ?>
                </div>
                <table id="kartu" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                      <th>Nomor</th>
                      <th>Bulan</th>
                      <th>Pelanggan</th>
                      <th>Griya</th>
                      <th>AKA Lalu</th>
                      <th>AKA Akhir</th>
                      <th>Jlh Pakai</th>
                      <th>Biaya (Rp)</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($kartu as $row): ?>
                        <tr class="text-center">
                          <td><?= $no++; ?></td>
                          <td><?= $row->bulan ?>/<?= $row->periode ?></td>
                          <td><?= $row->nama_cust ?></td>
                          <td><?= $row->nama_griya ?></td>
                          <td><?= $row->aka_lalu ?></td>
                          <td><?= $row->aka_akhir ?></td>
                          <td><?= $row->jlh_pakai ?></td>
                          <td><?php echo number_format($row->jlh_biaya,2,",","."); ?></td>
                          <td class="text-center">
                            <a id="detail_kartu" class="btn btn-sm btn-primary" href="javascript:;" data-toggle="modal" data-target="#detail-kartu" data-id="<?= $row->id; ?>" data-harga_pm="<?= $setup[0]->nilai; ?>"><i class="fa fa-receipt text-light"></i> Detail</a>
                            <a class="btn btn-sm btn-secondary" href=""><i class="fa fa-print text-light"></i> Cetak</a>
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

<!-- Modal Input AKA -->
<div class="modal fade bd-example-modal-lg" id="input-aka" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Input AKA (Angka Kedudukan Air)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url(); ?>admin/input_new_aka" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="nama">ID Pelanggan</label>
            <input type="text" hidden name="cust_id" id="csid1">
            <input type="text" disabled class="form-control" id="csid">
          </div>
          <div class="form-group">
            <label for="nama">Periode</label>
            <input type="text" hidden name="tahun" value="<?= $tahun ?>">
            <input type="text" hidden name="bulan" id="bulan1">
            <input type="text" disabled class="form-control" id="bulan">
          </div>
          <div class="form-group">
            <label for="nama">AKA (Angka Kedudukan Air) Akhir (M3)</label>
            <input type="number" name="aka_akhir" class="form-control" placeholder="Input jumlah AKA Akhir" required autofocus>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id=""><i class="fa fa-save text-light"></i> Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle text-light"></i> Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Add AKA -->

<!-- Modal Detail AKA -->
<div class="modal fade bd-example-modal-lg" id="detail-kartu" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Tagihan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label for="nama_cust" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="nama_cust">
          </div>
        </div>
        <div class="form-group row">
          <label for="harga_pm" class="col-sm-2 col-form-label">Harga / M3</label>
          <div class="col-sm-10">
            <input type="number" readonly class="form-control-plaintext" id="harga_pm">
          </div>
        </div>
        <div class="form-group row">
          <label for="biaya_mtc" class="col-sm-2 col-form-label">B. Perawatan</label>
          <div class="col-sm-10">
            <input type="number" readonly class="form-control-plaintext"   id="biaya_mtc">
          </div>
        </div>
        <div class="form-group row">
          <label for="alamat_cust" class="col-sm-2 col-form-label">Alamat</label>
          <div class="col-sm-10">
            <input type="text"  readonly class="form-control-plaintext"  id="alamat_cust">
          </div>
        </div>
        <div class="form-group row">
          <label for="periode" class="col-sm-2 col-form-label">Periode (Bln / Thn)</label>
          <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="periode">
          </div>
        </div>
        <div class="form-group row">
          <label for="stand_meter" class="col-sm-2 col-form-label">Stand Meter</label>
          <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="stand_meter">
          </div>
        </div>
        <div class="form-group row">
          <label for="pemakaian" class="col-sm-2 col-form-label">Pemakaian (M3)</label>
          <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="pemakaian">
          </div>
        </div>
        <div class="form-group row">
          <label for="total_bayar" class="col-sm-2 col-form-label">Total Bayar (Rp)</label>
          <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="total_bayar">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id=""><i class="fa fa-save text-light"></i> Cetak</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle text-light"></i> Batal</button>
      </div>
    </div>
  </div>
</div>
<!-- End Detail AKA -->


<!-- Script File -->
<?php include (APPPATH.'views/admin/components/scripts.php'); ?>
<script src="<?= base_url(); ?>assets/js/moment-with-locales.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#kartu").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "colvis"]
    }).buttons().container().appendTo('#kartu_wrapper .col-md-6:eq(0)');
  });
</script>

<script>
  let base_url = window.location.origin + "/simal/";
  let gid = document.getElementById("griyaid");
  gid.addEventListener("input", () => {
    $(".s_cust").remove();
    $.ajax({
      type: 'POST',
      url: base_url + "admin/get_cust",
      data: {gryid: gid.value},
      cache: false,
      success: function(msg){
        var cust_data = JSON.parse(msg);
        var iter = 0;
        while (iter < cust_data.length) {
          $("#idcust").append(
            "<option class='s_cust' value='" + cust_data[iter].cid +"'>" + cust_data[iter].nama + "</option>"
          );
          iter++;
        }
      }
    });
  });

  $(document).on("click", "#btn_input_aka", function () {
    var cid = $(this).data("cid");
    var year = "<?= $tahun ?>";

    $.ajax({
      type: 'POST',
      url: base_url + "admin/last_cust_aka",
      data: {cid: cid, tahun: year},
      cache: false,
      success: function(msg){
        var kmp_data = JSON.parse(msg);
        var next_month = (kmp_data.length + 1);
        var bln = moment().format(year+'-'+next_month, 'YYYY-mm');
        $("#csid").val(cid);
        $("#csid1").val(cid);
        $("#bulan").val(bln);
        $("#bulan1").val(bln);
      }
    });
  });

  $(document).on("click", "#detail_kartu", function () {
    var id = $(this).data("id");
    var harga_pm = $(this).data("harga_pm");

    $.ajax({
      type: 'POST',
      url: base_url + "admin/get_kartu_byid",
      data: {kid: id},
      cache: false,
      success: function(msg){
        var kartu_byid = JSON.parse(msg);
        console.log(kartu_byid);
        $("#nama_cust").val(kartu_byid[0].nama_cust);
        $("#harga_pm").val(harga_pm);
        $("#biaya_mtc").val(kartu_byid[0].biaya_mtc);
        $("#alamat_cust").val(kartu_byid[0].alamat_cust+', '+kartu_byid[0].alamat_griya);
        $("#periode").val(kartu_byid[0].bulan+'-'+kartu_byid[0].periode);
        $("#stand_meter").val(kartu_byid[0].stand_meter);
        $("#pemakaian").val(kartu_byid[0].jlh_pakai);
        $("#total_bayar").val(kartu_byid[0].jlh_biaya);
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

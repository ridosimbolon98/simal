<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title> Login Page  | Audit 5R </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons CDN Link -->
    <link href='<?= base_url(); ?>assets/boxicons/css/boxicons.min.css' rel='stylesheet'>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/uikit/css/uikit.min.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- Animate CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/animate/css/animate.min.css"/> 
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style_login.css"/> 
    <link rel="stylesheet" href="<?= base_url(); ?>assets/multi-select/dist/css/BsMultiSelect.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/adminlte/plugins/toastr/toastr.min.css">

  </head>
<body>

<div class="uk-container uk-flex uk-flex-center uk-flex-middle">
    <form class="form-login uk-box-shadow-large">
        <div class="uk-text-center">
            <h2 class="uk-text-lead animate__animated animate__fadeInDown">Apakah ada temuan <span class="text-orange uk-text-bolder">5R</span>?</h2>
            <hr class="uk-divider-icon">
        </div>
        <div class="uk-margin">
            <button type="button" class="uk-button uk-button-small uk-input uk-form-small uk-margin-top ubl" uk-toggle="target: #modal-add">Ada Temuan</button>
        </div>
        <div class="uk-margin">
            <button type="button" class="uk-button uk-button-secondary uk-button-small uk-input uk-form-small uk-margin-top" uk-toggle="target: #no-temuan">Tidak Ada Temuan</button>
        </div>
        <div class="uk-margin">
            <a href="<?= base_url('auditor'); ?>" class="uk-button uk-button-default uk-button-small uk-input uk-form-small uk-margin-top">Masuk ke Halaman Auditor</a>
        </div>
    </form>
</div>
    
<!-- Modal Ada Temuan -->
<div id="modal-add" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Pilih Tim Audit dan Area Audit</h2>
        </div>
        <form class="uk-form-stacked" method="post" action="<?= base_url('home/form'); ?>">
            <div class="uk-modal-body">
                <div class="uk-margin">
                    <label for="tim_audit">TIM AUDIT</label>
                    <div class="uk-form-controls">
                        <select name="tim_audit[]" class="form-select form-select-sm" id="tim_audit" aria-label="tim_audit" multiple="multiple" required>
                            <option value="" disabled selected>--Pilih Tim Audit--</option>
                            <?php foreach($auditor as $row): ?>
                                <option value="<?= $row->nama_auditor; ?>"><?= $row->nama_auditor; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="uk-margin">
                    <label for="lokasi">LOKASI AUDIT</label>
                    <div class="uk-form-controls">
                        <select name="lokasi" class="uk-select uk-form-small" id="lokasi" required>
                            <option value="" disabled selected data-live-search="true">--Pilih Lokasi Audit--</option>
                            <option value="PABRIK">PABRIK</option>
                            <option value="NON-PABRIK">NON-PABRIK</option>
                        </select>
                    </div>
                </div>
                <div class="uk-margin">
                    <label for="area">AREA AUDIT</label>
                    <div class="uk-form-controls">
                        <select name="area" class="uk-select uk-form-small" id="area" required>
                            <option value="" disabled selected data-live-search="true">--Pilih Area & Bagian--</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Batal</button>
                <button class="uk-button uk-button-primary" type="submit">Lanjutkan</button>
            </div>
        </form>
    </div>
</div>
<!-- End Modal Ada Temuan -->

<!-- Modal Tidak Ada Temuan -->
<div id="no-temuan" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Pilih Tim Audit dan Area Audit (NO)</h2>
        </div>
        <form class="uk-form-stacked" method="post" action="<?= base_url('home/formno'); ?>">
            <div class="uk-modal-body">
                <div class="uk-margin">
                    <label for="tim_audit">TIM AUDIT</label>
                    <div class="uk-form-controls">
                        <select name="tim_audit2[]" class="form-select form-select-sm" id="tim_audit2" aria-label="tim_audit" multiple="multiple" required>
                            <option value="" disabled selected>--Pilih Tim Audit--</option>
                            <?php foreach($auditor as $row): ?>
                                <option value="<?= $row->nama_auditor; ?>"><?= $row->nama_auditor; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="uk-margin">
                    <label for="lokasi">LOKASI AUDIT</label>
                    <div class="uk-form-controls">
                        <select name="lokasi2" class="uk-select uk-form-small" id="lokasi2" required>
                            <option value="" disabled selected data-live-search="true">--Pilih Lokasi Audit--</option>
                            <option value="PABRIK">PABRIK</option>
                            <option value="NON-PABRIK">NON-PABRIK</option>
                        </select>
                    </div>
                </div>
                <div class="uk-margin">
                    <label for="area">AREA AUDIT</label>
                    <div class="uk-form-controls">
                        <select name="area2" class="uk-select uk-form-small" id="area2" required>
                            <option value="" disabled selected data-live-search="true">--Pilih Area & Bagian--</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Batal</button>
                <button class="uk-button uk-button-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- End Modal Tidak Ada Temuan -->

<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/bootstrap/dist/js/popper.min.js"></script>
<script src="<?= base_url(); ?>assets/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- UIkit JS -->
<script src="<?= base_url(); ?>assets/uikit/js/uikit.min.js"></script>
<script src="<?= base_url(); ?>assets/uikit/js/uikit-icons.min.js"></script>
<script src="<?= base_url(); ?>assets/multi-select/dist/js/BsMultiSelect.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url(); ?>assets/adminlte/plugins/toastr/toastr.min.js"></script>

<script>
    $(document).ready(function(){
        $('#tim_audit').bsMultiSelect();
    });
    $(document).ready(function(){
        $('#tim_audit2').bsMultiSelect();
    });
</script>
<script>
    let base_url = window.location.origin + "/audit/";
    let lok1     = document.getElementById("lokasi");
    let lok2     = document.getElementById("lokasi2");
    
    lok1.addEventListener("input", () => {
        $(".s_area").remove();
        var data_lok = lok1.value;
        $.ajax({
            type: 'POST',
            url: base_url + "home/getArea",
            data: {data1: data_lok},
            cache: false,
            success: function(msg){
                var data = JSON.parse(msg);
                var iter = 0;
                while (iter < data.length) {
                    $("#area").append(
                        "<option class='s_area' value='" +
                            data[iter].id_dept +
                            "'>" +
                            data[iter].area_dept + " - " + data[iter].bagian_dept +
                            "</option>"
                    );
                    iter++;
                }
            }
        });
    });

    lok2.addEventListener("input", () => {
        $(".s_area2").remove();
        var data_lok = lok2.value;
        $.ajax({
            type: 'POST',
            url: base_url + "home/getArea",
            data: {data1: data_lok},
            cache: false,
            success: function(msg){
                var data = JSON.parse(msg);
                var iter = 0;
                while (iter < data.length) {
                    $("#area2").append(
                        "<option class='s_area2' value='" +
                            data[iter].id_dept +
                            "'>" +
                            data[iter].area_dept + " - " + data[iter].bagian_dept +
                            "</option>"
                    );
                    iter++;
                }
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

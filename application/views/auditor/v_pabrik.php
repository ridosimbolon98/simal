<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/multi-select/dist/css/BsMultiSelect.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/su_index.css">
</head>
<body>
    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <!-- <img src="https://placeholder.pics/svg/150x50/888888/EEE/Logo" alt="..." height="36"> -->
                Audit 5R
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url(); ?>home/np">NON-PABRIK</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url(); ?>home">PABRIK</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        AUTENTIKASI</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= base_url(); ?>auth">Login</a></li>
                            <li><a class="dropdown-item" href="<?= base_url(); ?>auth/logout">Logout</a></li>
                            <li>
                            <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Lupa Password</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar Section -->

    <!-- Form Audit -->
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="card my-3">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h4>FORM AUDIT 5R</h4>
                        </div>
                        <form action="<?= base_url(); ?>home/send" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="tim_audit" class="form-label">Tim Audit</label>
                                <input name="k_lok" type="hidden" class="form-control" value="PABRIK">
                                <select name="tim_audit[]" id="tim_audit" class="form-select form-select-sm" aria-label="tim_audit" multiple="multiple" required>
                                    <option value="" disabled selected>--Pilih Tim Audit--</option>
                                    <?php foreach($audit as $row): ?>
                                        <option value="<?= $row->nama_auditor; ?>"><?= $row->nama_auditor; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="area" class="form-label">Area & Bagian</label>
                                <select name="area" id="area" class="form-select form-select-sm" aria-label="area" required>
                                    <option value="" disabled selected data-live-search="true">--Pilih Area & Bagian--</option>
                                    <?php foreach ($area as $row) : ?>
                                        <option value="<?= $row->id_dept ?>"><?= $row->area_dept ?> - <?= $row->bagian_dept ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tgl_audit" class="form-label">Tanggal Temuan</label>
                                <input name="tanggal" type="date" class="form-control" id="tgl_audit" required>
                            </div>
                            <div class="mb-3">
                                <label for="k_5r" class="form-label">Kategori 5R</label>
                                <select name="k_5r" id="k_5r" class="form-select form-select-sm" aria-label="k_5r" required>
                                    <option value="" disabled selected>--Pilih Kategori 5R--</option>
                                    <option value="RINGKAS">RINGKAS</option>
                                    <option value="RAPI">RAPI</option>
                                    <option value="RESIK">RESIK</option>
                                    <option value="RAWAT">RAWAT</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="a_tem" class="form-label">Aspek Temuan</label>
                                <select name="a_tem" id="a_tem" class="form-select form-select-sm" aria-label="" required>
                                    <option value="" disabled selected>--Pilih Aspek--</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="k_tem" class="form-label">Kategori Temuan</label>
                                <select name="k_tem" id="k_tem" class="form-select form-select-sm" aria-label="" required>
                                    <option value="" disabled selected>--Pilih Kategori Temuan--</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Lokasi/Keterangan</label>
                                <input name="keterangan" class="form-control form-control-sm" type="text" placeholder="Input lokasi/keterangan temuan.." aria-label="lokasi temuan" required>
                            </div>
                            <div class="mb-3">
                                <label for="jlh_temuan" class="form-label">Jumlah Temuan</label>
                                <input name="jlh_temuan" class="form-control form-control-sm" type="number" placeholder="Input jumlah temuan.." aria-label="jumlah temuan" required>
                            </div>
                            <div class="mb-3">
                                <label for="formFileSm" class="form-label">Gambar Temuan</label>
                                <input class="form-control form-control-sm" id="formFileSm" type="file" name="gambar" required>
                            </div>
                            <button type="submit" class="btn btn-success" onclick="return confirm('Apakah anda yakin submit audit ini?');">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card my-3">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h4>PANDUAN PENGGUNAAN</h4>
                        </div>
                        <ul>
                            <li>
                                <p>Pertama, lakukan autentikasi atau login sesuai dengan user auditor masing-masing.</p>
                            </li>
                            <li>
                                <p>Setelah itu, silakan pilih pada menu form Pabrik atau Non-Pabrik. Jika audit dilakukan di area Pabrik, maka silakan klik menu Pabrik. Jika audit dilakukan di area Non-Pabrik, silakan klik menu Non-Pabrik.</p>
                            </li>
                            <li>
                                <p>Lalu, akan muncul form Audit 5R dengan isian (field) Tim Audit, Area dan Bagian, Tanggal Temuan, Kategori 5R, Aspek Temuan, Kategori Temuan, Lokasi/Keterangan, Jumlah Temuan, dan Gambar Temuan.</p>
                            </li>
                            <li>
                                <p>Silakan pilih Tim Audit yang melakukan audit pada saat itu. Setelah itu silakan pilih Area & Bagian yang dilakukan audit. Pilih tanggal sesuai dengan tanggal audit. Pilih Kategori 5R, Aspek Temuan dan Kategori Temuan yang terdapat temuan. Setelah itu, isi Lokasi/Keterangan yang jelas mengenai temuan tersebut. Isi jumlah temuan sesuai dengan kondisi di lapangan. Lalu ambil gambar evidence temuan.</p>
                            </li>
                            <li>
                                <p>Pastikan semua isian form sudah terisi dengan benar, jika sudah silakan klik Submit.</p>
                            </li>
                            <li>
                                <p>Jika ada temuan lain aspek pada area yang sama, silakan isi kembali dengan pilihan aspek yang berbeda sesuai temuan.</p>
                            </li>
                            <li>
                                <p>Setelah selesai melakukan Audit, pastikan untuk logout dari sistem.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Form Audit -->

    <!-- Script Section -->
    <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/bootstrap/dist/js/popper.min.js"></script>
    <script src="<?= base_url(); ?>assets/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>assets/multi-select/dist/js/BsMultiSelect.min.js"></script>

    <!-- End Script Section -->

    <script type="text/javascript">
        let base_url = window.location.origin + "/audit/";
        let k_lok  = document.getElementById("k_lok");
        let s_5r   = document.getElementById("k_5r");
        let s_atem = document.getElementById("a_tem");

        $(document).ready(function() {
            $(".s_ta").remove();
            var data_lok = "PABRIK";
            $.ajax({
                type: 'POST',
                url: base_url + "home/get_ta",
                data: {data1: data_lok},
                cache: false,
                success: function(msg){
                    var data = JSON.parse(msg);
                    var iter = 0;
                    while (iter < data.length) {
                        $("#tim_audit").append(
                            "<option class='s_ta' value='" +
                                data[iter].id_auditor +
                                "'>" +
                                data[iter].nama_auditor + " - " + data[iter].area_dept +
                                "</option>"
                        );
                        iter++;
                    }
                }
            });
        });

        s_5r.addEventListener("input", () => {
            $(".s_aspek").remove();
            var data_5r = s_5r.value;
            var data_lok = "PABRIK";
            $.ajax({
                type: 'POST',
                url: base_url + "home/get_at",
                data: {data1: data_5r, data2: data_lok},
                cache: false,
                success: function(msg){
                    var data = JSON.parse(msg);
                    var iter = 0;
                    while (iter < data.length) {
                        $("#a_tem").append(
                            "<option class='s_aspek' value='" +
                                data[iter].id_aspek +
                                "'>" +
                                data[iter].desk_aspek +
                                "</option>"
                        );
                        iter++;
                    }
                }
            });
        });

        s_atem.addEventListener("input", () => {
            $(".s_kt").remove();
            var data_tem = $("#a_tem").val();
            var data_5r = $("#k_5r").val();
            var data_lok = "PABRIK";
            $.ajax({
                type: 'POST',
                url: base_url + "home/get_kt",
                data: {a_tem: data_tem, k_5r: data_5r, k_lok: data_lok},
                cache: false,
                success: function(msg){
                    var data2 = JSON.parse(msg);
                    var iter = 0;
                    while (iter < data2.length) {
                        $("#k_tem").append(
                            "<option class='s_kt' value='" +
                                data2[iter].id_pt +
                                "'>" +
                                data2[iter].desk_pt +
                                "</option>"
                        );
                        iter++;
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#tim_audit').bsMultiSelect();
        });
    </script>
    
</body>
</html>
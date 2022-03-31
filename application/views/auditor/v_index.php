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
    <style>
        body, .container {
            min-height: 100vh !important;
        }
        .cb {
            min-width: 150px !important;
        }
    </style>
</head>
<body>

    <!-- Form Audit -->
    <div class="container d-flex justify-content-around align-items-center">
        <div class="card my-3 cb">
            <div class="card-body">
                <div class="text-center">
                    <a href="<?= base_url(); ?>home/pabrik" class="btn btn-primary">Ada Temuan</a>
                </div>
            </div>
        </div>
        <div class="card my-3 cb">
            <div class="card-body">
                <div class="text-center">
                    <a href="" class="btn btn-outline-info">Tidak Ada Temuan</a>
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

 
    
</body>
</html>
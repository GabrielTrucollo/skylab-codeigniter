<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
    <meta charset="UTF-8">
    <title>Skylab - Plataforma de Controle de Atendimentos </title>
    <link rel="icon" href="<?= base_url('images/favicon.ico'); ?>">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/css/mdb.min.css'); ?>">
    <!-- Toaster -->
    <link rel="stylesheet" href="<?= base_url('assets/css/toastr.min.css'); ?>">
    <!-- Custom styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
</head>

<?= $this->renderSection('content') ?>

<!-- jQuery -->
<script type="text/javascript" src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?= base_url('assets/js/mdb.min.js'); ?>"></script>
<!-- Moment core JavaScript -->
<script type="text/javascript" src="<?= base_url('assets/js/moment-with-locales.js'); ?>"></script>
<!-- JqueryMask core JavaScript -->
<script type="text/javascript" src="<?= base_url('assets/js/jquery.mask.min.js'); ?>"></script>
<!-- Toaster core JavaScript -->
<script type="text/javascript" src="<?= base_url('assets/js/toastr.min.js'); ?>"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
<!-- DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<!-- Custom scripts -->
<script type="text/javascript" src="<?= base_url('assets/js/utils/mask.js'); ?>"></script>
<script>
    new WOW().init();
</script>
<script>
    $(document).ready(function() {
        // SideNav Button Initialization
        $(".button-collapse").sideNav('show');

        // SideNav Scrollbar Initialization
        var sideNavScrollbar = document.querySelector('.custom-scrollbar');
        var ps = new PerfectScrollbar(sideNavScrollbar, {
            wheelSpeed: 2,
            wheelPropagation: true,
            minScrollbarLength: 20
        });

        // Material Select Initialization
        $(document).ready(function () {
            $('.mdb-select').materialSelect();
        });
    });
</script>
<script type="text/javascript">
    toastr.options = {
        "positionClass": "toast-bottom-right"
    };

    <?php if(session()->getFlashdata('success')){ ?>
    toastr.success("<?=  session()->getFlashdata('success'); ?>");


    <?php }else if(session()->getFlashdata('error')){  ?>

    toastr.error("<?= session()->getFlashdata('error'); ?>");

    <?php }else if(session()->getFlashdata('warning')){  ?>
    toastr.warning("<?= session()->getFlashdata('warning')?>");


    <?php }else if(session()->getFlashdata('info')){  ?>
    toastr.info("<?php echo session()->getFlashdata('info'); ?>");

    <?php } ?>
</script>
</body>
</html>

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
            var ps = new PerfectScrollbar(sideNavScrollbar);
        });
    </script>
</body>
</html>
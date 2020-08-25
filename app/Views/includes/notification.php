
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
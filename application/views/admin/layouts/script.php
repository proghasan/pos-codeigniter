<!-- Bootstrap core JavaScript-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- simplebar js -->
<!-- <script src="assets/plugins/simplebar/js/simplebar.js"></script> -->
<!-- sidebar-menu js -->
<script src="assets/js/sidebar-menu.js"></script>

<!-- Custom scripts -->
<script src="assets/js/app-script.js"></script>
<?php if($this->uri->segment(1) == "product-purchase"): ?>
<script>
    $(document).ready(function(){ 
       $("#wrapper").toggleClass("toggled");
    })
</script>
<?php endif;?>
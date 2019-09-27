<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view('admin/layouts/head')?>
</head>

<body>
  <!-- start loader -->
  <div id="pageloader-overlay" class="visible incoming">
    <div class="loader-wrapper-outer">
      <div class="loader-wrapper-inner">
        <div class="loader"></div>
      </div>
    </div>
  </div>
  <!-- end loader -->
  <!-- Start wrapper-->
  <div id="wrapper">

    <!--Start sidebar-wrapper-->
    <?php $this->load->view('admin/layouts/left_menu')?>
    <!--End sidebar-wrapper-->

    <!--Start topbar header-->
    <?php $this->load->view('admin/layouts/top_head')?>
    <!--End topbar header-->
    <div class="clearfix"></div>

    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
          <div class="col-sm-9">
            <!-- <h4 class="page-title">Dashboard</h4> -->
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="javaScript:void();">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="javaScript:void();"><?php echo isset($bread) ? $bread : '';?></a>
              </li>
            </ol>
          </div>
        </div>
        <!-- End Breadcrumb-->

        <?php echo $content;?>

      </div>
      <!-- End container-fluid-->

    </div>
    <!--End content-wrapper-->
    <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->

    <!--Start footer-->
    <?php $this->load->view('admin/layouts/footer')?>
    <!--End footer-->

    <!--start color switcher-->
    <?php $this->load->view('admin/layouts/theme')?>
    <!--end color cwitcher-->

  </div>
  <!--End wrapper-->
  <?php $this->load->view('admin/layouts/script')?>
</body>

</html>
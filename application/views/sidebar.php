<?php 
$CI =& get_instance();
$CI->load->model('Commonmodel');
$setting_view = $CI->Commonmodel->singleAllData('b_settings',array());
?>
<style>
  .nav-item{
    cursor: pointer;
  }
</style>
<body>
  <div class="d-flex m-view">
    <div class="col-lg-2">
        <nav class="navbar navbar-dark bg-dark">
              <div class="navbar-logo" href="#">
                <img src="<?php echo base_url(); ?>assets/images/main-logo.png"/>
              </div>
              <div class="d-flex justify-content-center">
                <ul class="navbar-nav">
                  <?php if($setting_view->enable_location == 1) {?>
                  <li class="nav-item">
                    <a class="nav-list">
                      <div class="nav-list-img-box">
                        <img src="<?php echo base_url(); ?>assets/images/location.png"/>
                      </div>
                      <p class="nav-link">Location</p>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($setting_view->enable_staff == 1) {?>
                  <li class="nav-item">
                    <a class="nav-list">
                      <div class="nav-list-img-box">
                        <img src="<?php echo base_url(); ?>assets/images/profile.png"/>
                      </div>
                      <p class="nav-link">Staff</p>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($setting_view->enable_service == 1) {?>
                  <li class="nav-item">
                    <a class="nav-list">
                      <div class="nav-list-img-box">
                        <img src="<?php echo base_url(); ?>assets/images/task-square.png"/>
                      </div>
                      <p class="nav-link">Service</p>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($setting_view->enable_date_time == 1) {?>
                  <li class="nav-item">
                    <a class="nav-list">
                      <div class="nav-list-img-box">
                        <img src="<?php echo base_url(); ?>assets/images/calendarT.png"/>
                      </div>
                      <p class="nav-link">Date & Time</p>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($setting_view->enable_cart == 1) {?>
                  <li class="nav-item">
                    <a class="nav-list">
                      <div class="nav-list-img-box">
                        <img src="<?php echo base_url(); ?>assets/images/Shop.png"/>
                      </div>
                      <p class="nav-link">Cart</p>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($setting_view->enable_information == 1) {?>
                  <li class="nav-item">
                    <a class="nav-list">
                      <div class="nav-list-img-box">
                        <img src="<?php echo base_url(); ?>assets/images/personalcard.png"/>
                      </div>
                      <p class="nav-link">Information</p>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($setting_view->enable_finish == 1) {?>
                  <li class="nav-item">
                    <a class="nav-list">
                      <div class="nav-list-img-box">
                        <img src="<?php echo base_url(); ?>assets/images/import.png"/>
                      </div>
                      <p class="nav-link">Finish</p>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
        </nav>
    </div>
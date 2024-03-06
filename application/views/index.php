<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<style>
  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

  .main-container {
    max-height: 100% !important;
    height: auto !important;
  }

  a {
    text-decoration: none !important;
    color: #fff !important;
  }

  .fc .fc-daygrid-day-number {
    color: #333 !important;

  }

  .card-body {
    font-size: 13px;
    padding: 7px 1px 6px 18px;
  }
  thead {
    background: blue !important;
  }
</style>
    <div class="col-lg-10" id="main_html">

    </div>
<?php include("footer.php"); ?>
<script src="<?php echo base_url(); ?>assets/js/script.js?rand=<?php echo rand(); ?>"></script>

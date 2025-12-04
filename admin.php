<?php require 'components/header.php'; ?>
<link rel="stylesheet" href="resources/css/admin.css">
<div id="xcontent"></div>
<div class="preloader-wrap">
  <div class="background"></div>
  <div class="loader">
    <i class="fa fa-spinner fa-spin fa-5x preloader"></i>
  </div>
</div>
<script src="/resources/js/Admin.js"></script>
<?php require 'components/footer.php'; ?>
<script>sendOptRequest({url: '/admin/dashboard'});</script>
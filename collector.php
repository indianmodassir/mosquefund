<?php require 'components/header.php'; ?>
<link rel="stylesheet" href="resources/css/admin.css">
<div id="xcontent"></div>
<div class="preloader-wrap">
  <div class="background"></div>
  <div class="loader">
    <svg class="preloader" width="100" height="100" viewBox="0 0 19 19" fill="none"><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path></svg>
  </div>
</div>
<script src="/resources/js/ManageMember.js"></script>
<?php require 'components/footer.php'; ?>
<script>
  sendOptRequest({url: '/collector/dashboard'});
</script>
<div id="popstate" class="loading" style="display:none;" popover>
  <img src="/resources/assets/loader_b.gif" alt="Loader" draggable="false" width="20px">
  <i class="fa fa-circle-exclamation err"></i>
  <i class="fa fa-check check"></i>
  <span></span>
</div>
<style>body{background:#f1efef;}</style>
<div style="padding-top:6px;">
  <div class="db-section" data-label="Secretary Request Table">
    <div class="fgroup">
      <div class="lbl">Secretary Request / सचिव अनुरोध</div>
      <button popovertarget="popstate" onclick="manageDatabase(this, 'request')">
        <i class="fa fa-arrow-rotate-right"></i>
        <span>Reset</span>
      </button>
    </div>
  </div>
</div>
<style>body{background:#f1efef;}</style>
<div style="padding-top:6px;">
  <div class="db-section" data-label="Expenses Record Table">
    <div class="fgroup">
      <div class="lbl">Expenses Records / खर्चे का रिकॉर्ड</div>
      <button popovertarget="popstate" onclick="manageDatabase(this, 'spent')">
        <i class="fa fa-arrow-rotate-right"></i>
        <span>Reset</span>
      </button>
    </div>
  </div>
</div>
<script>
  let timeoutTimer;
  function manageDatabase(button, table) {
    $('#popstate')[0].showPopover();
    clearTimeout(timeoutTimer);
    $(button).attr('disabled', true);
    $('#popstate').show();
    $('#popstate').removeClass('dberror').addClass('loading').find('span').html('Loading please wait...');
    post('/admin/truncate', {data: 'table=' + table}).then(res => {
      $('#popstate')[0].showPopover();
      if (res.dberror) {
        $('#popstate').removeClass('loading').addClass('dberror').find('span').html(res.message);
      } else {
        $('#popstate').removeClass('loading dberror').find('span').html(res.message);
      }
      timeoutTimer = setTimeout(() => $('#popstate')[0].hidePopover(), 3000);
      $(button).attr('disabled', null);
    }).catch(() => {
      $('#popstate')[0].showPopover();
      $(button).attr('disabled', null);
      $('#popstate').removeClass('loading').addClass('dberror').find('span').html('Internal Server Error!');
    });
  }
</script>
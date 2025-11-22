<div class="find">
  <strong style="
    display: block;
    margin: 18px auto;
    width: 100%;
    text-align: center;
  ">Search Member / सदस्य खोजें</strong>
  <form>
    <div style="
      display:flex;
      align-items:center;
      max-width: 500px;
      margin: 22px auto;
      position:relative;
    ">
      <div style="
        position:absolute;
        left: 11px;
        color: #999393;
        z-index: 1;
      ">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      </div>
      <input type="number" name="number" id="search" autocomplete="on" placeholder="Member mobile number / सदस्य का मोबाइल नंबर" style="
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
        padding: 0 11px 0 43px;
        height: 42px;
      " oninput="$(this).parent().find('button').attr('data-uid', this.value)">
      <button type="button" style="
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
        padding: 0 18px;
        height: 42px;
      " data-fetch-type="all" id="btn_search" onclick="fetchMemberInfo(this);$('#search').val('');">SEARCH</button>
    </div>
  </form>
  <br/><br/><br/>
  <div class="notice">
    <p style="margin-bottom:8px;">Content on this website is owned, by the General Administration Department, Developer of Bihar</p>
    <p style="margin-bottom:8px;">Site is technically designed, hosted and maintained by Indian Modassir Developer (IMD)</p>
    <p>Powered By — IndianModassir</p>
  </div>
</div>
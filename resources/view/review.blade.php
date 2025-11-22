<style>
  tr td:first-child {
    max-width: auto;
  }
</style>
<div class="wrap bg" style="padding:11px;background:#fbfbfb;">
  <table class="f-review">
    <tr>
      <td colspan="2"><label>आवेदक का विवरण / Details of Applicant</label></td>
    </tr>
    <tr>
      <td>Fullname of Applicant *</td>
      <td>{{session()->get('fullname')}}</td>
    </tr>
    <tr>
      <td>Mobile No. of Applicant *</td>
      <td>{{session()->get('number')}}</td>
    </tr>
    <tr>
      <td>Email Adress. of Applicant *</td>
      <td><a href="{{session()->get('email')}}">{{session()->get('email')}}</a></td>
    </tr>
    <tr>
      <td>Registration Date *</td>
      <td>{{session()->get('regdate')}}</td>
    </tr>
    <tr>
      <td>Collector ID</td>
      <td>{{session()->get('collector_id')}}</td>
    </tr>
    <tr>
      <td>Email Verification *</td>
      <td>Not Verified</td>
    </tr>
    <tr>
      <td>जिला / District *</td>
      <td>{{session()->get('district')}}</td>
    </tr>
    <tr>
      <td>प्रखंड / Block *</td>
      <td>{{session()->get('circle')}}</td>
    </tr>
    <tr>
      <td>ग्राम (Village) / मोहल्ला (Town) *</td>
      <td>{{session()->get('village')}}</td>
    </tr>
    <tr>
      <td>Stree Address. of Applicant *</td>
      <td>{{session()->get('address')}}</td>
    </tr>
  </table>
</div>
<div class="wrap bg" style="background:#fbfbfb;">
  <form action="/registration" method="post" onsubmit="registration(event)" style="padding:0;">
    <div class="field" style="padding:12px 22px;flex-direction:row;justify-content:flex-end;max-width:100%;gap:6px;flex-wrap:wrap;">
      <button style="width:max-content;padding:0 14px;display:flex;justify-content:center;align-items:center;column-gap:5px;">
        <svg class="preloader" viewBox="0 0 19 19" fill="none"><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path></svg>
        <span>COMPLETE REGISTRATION</span>
      </button>
      <button type="button" data-type="edit" style="width:max-content;padding:0 14px;" data-action="/admin/create" onclick="sendOptRequest(this)">EDIT</button>
      <button data-action="/admin/dashboard" onclick="sendOptRequest(this)" type="button" style="width:max-content;background:#e54a4a;padding:0 14px;">CLOSE</button>
    </div>
  </form>
</div>
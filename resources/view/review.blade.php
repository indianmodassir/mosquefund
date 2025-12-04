<style>tr td:first-child {max-width: fit-content}</style>
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
    <div class="field btn-wrap" style="padding:12px 22px;flex-direction:row;justify-content:flex-end;max-width:100%;gap:6px;flex-wrap:wrap;">
      <button style="width:max-content;padding:0 14px;display:flex;justify-content:center;align-items:center;column-gap:5px;">
        <img class="preloader" src="/resources/assets/loader.gif" draggable="false" alt="loader" width="17px">
        <i class="fa fa-floppy-o"></i>
        <span>COMPLETE REGISTRATION</span>
      </button>
      <button type="button" data-type="edit" style="width:max-content;padding:0 14px;background:#3c8dbc;" data-action="/admin/create" onclick="sendOptRequest(this)">EDIT DETAILS</button>
      <button data-action="/admin/dashboard" onclick="sendOptRequest(this)" type="button" style="width:max-content;padding:0 14px;display:flex;justify-content:center;align-items:center;column-gap:5px;background:#e54a4a;">
        <i class="fa fa-times-circle"></i>
        <span>CLOSE</span>
      </button>
    </div>
  </form>
</div>
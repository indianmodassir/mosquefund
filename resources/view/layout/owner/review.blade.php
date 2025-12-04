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
      <td>Gender of Applicant</td>
      <td>{{session()->get('gender')}}</td>
    </tr>
    <tr>
      <td>Upload Profile. of Applicant *</td>
      <td><img src="{{session()->get('profile')}}" alt="Profile" draggable="false" style="max-width:80px;"></td>
    </tr>
    <tr>
      <td>Village Name. of Applicant *</td>
      <td>{{session()->get('village')}}</td>
    </tr>
    <tr>
      <td>Email Adress. of Applicant *</td>
      <td>N/A</td>
    </tr>
    <tr>
      <td>Registration Date *</td>
      <td>{{session()->get('regdate')}}</td>
    </tr>
    <tr>
      <td>UID of Applicant *</td>
      <td>N/A</td>
    </tr>
    <tr>
      <td>Email Verification *</td>
      <td>Not Required</td>
    </tr>
    <tr>
      <td>Owner ID</td>
      <td>{{$owner_id}}</td>
    </tr>
    <tr>
      <td>अंतिम भुगतान / Paid Amount *</td>
      <td>{{$amount}}</td>
    </tr>
  </table>
</div>
<div class="wrap bg" style="background:#fbfbfb;">
  <form action="/member/registration" method="post" onsubmit="registration(event)" style="padding:0;">
    <div class="field btn-wrap" style="padding:12px 22px;flex-direction:row;justify-content:flex-end;max-width:100%;column-gap:6px;">
      <button style="width:max-content;padding:0 14px;display:flex;justify-content:center;align-items:center;gap:6px;flex-wrap:wrap;">
        <img src="/resources/assets/loader.gif" alt="Loader" style="display:none;"/>
        <i class="fa fa-location-arrow"></i>
        <span>FINALIZE</span>
      </button>
      <button type="button" data-type="edit" style="width:max-content;padding:0 14px;background:#3c8dbc;" data-action="/owner/addmember" onclick="sendOptRequest(this)">EDIT DETAILS</button>
      <button data-action="/owner/dashboard" onclick="sendOptRequest(this)" type="button" style="width:max-content;background:#e54a4a;padding:0 14px;display:flex;justify-content:center;align-items:center;column-gap:5px;">
        <i class="fa fa-times-circle"></i>
        <span>CLOSE</span>
      </button>
    </div>
  </form>
</div>
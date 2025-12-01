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
        <svg class="preloader" viewBox="0 0 19 19" fill="none"><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path></svg>
        <span>FINALIZE</span>
      </button>
      <button type="button" data-type="edit" style="width:max-content;padding:0 14px;" data-action="/owner/addmember" onclick="sendOptRequest(this)">EDIT</button>
      <button data-action="/owner/dashboard" onclick="sendOptRequest(this)" type="button" style="width:max-content;background:#e54a4a;padding:0 14px;">CLOSE</button>
    </div>
  </form>
</div>
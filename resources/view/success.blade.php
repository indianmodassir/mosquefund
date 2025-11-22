<div class="success-page" style="margin-top:33px;">
  <div style="margin-top:18px;">
    <img src="/resources/assets/checklist.png" alt="Check" draggable="false" width="100">
  </div>
  <div class="text-label">
    <h1>{{$fullname}}, Your Registration has been Successful.</h1>
    <strong>Registered by {{\ucwords($role)}} ({{$controller}})</strong>
  </div>
  <form>
    <button data-action="/{{$role}}/dashboard" type="button" style="width:max-content;padding:0 18px;font-size:14px;" onclick="sendOptRequest(this)">GO TO DASHBOARD</button>
  </form>
</div>
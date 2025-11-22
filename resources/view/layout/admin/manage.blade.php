<div id="members-list" style="overflow-y:hidden;">
  @if (count($owner))
    <table class="vtable" style="table-layout:initial;">
      <tr style="background:#e9eef1;">
        <th style="white-space:nowrap;">क्र० स०</th>
        <th>सचिव का नाम</th>
        <th>सचिव का मोबाइल नंबर</th>
        <th>सचिव का ईमेल आईडी</th>
        <th>सचिव का गाँव/मोहल्ला</th>
        <th>स्थिति</th>
        <th style="width:0;text-align:center;">कार्रवाई</th>
      </tr>
      @foreach($owner as $i => $s_owner)
        <tr>
          <td style="width:0px;">{{$i + 1}}</td>
          <td style="white-space:nowrap;">{{$s_owner['fullname']}}</td>
          <td>{{$s_owner['number']}}</td>
          <td>{{$s_owner['email']}}</td>
          <td style="white-space:nowrap;">{{$s_owner['village']}}</td>
          <td>{{$s_owner['disabled'] ? 'Disabled' : 'Enabled'}}</td>
          <td>
            <button onclick="ManagePopup({{$s_owner['disabled']}}, {{$s_owner['number']}})" style="
              display: flex;
              column-gap: 5px;
              background: none;
              border: none;
              padding: 0;
              color: #6262c7;
              align-items: center;
              justify-content: center;
              text-shadow: none;
              box-shadow: none!important;
            ">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
              <span style="color:inherit!important;font-weight:normal;">Manage</span>
            </button>
          </td>
        </tr>
      @endforeach
    </table>
  @else
    <h1 class="not-found">Account Not Found!</h1>
  @endif
</div>
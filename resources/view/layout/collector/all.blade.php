@php $i = 0; @endphp
@if (!$ownerAuthorized)
  <ul style="
    margin-bottom:22px;
    flex-wrap: wrap;
    gap: 11px;
    display:flex;
    justify-content:space-between;
    ">
    <li style="
      color:#323232;
      border:1px solid #ccc;
      padding:8px 11px;
      font-size:15px;
    ">Collected Members <span>{{$collected_members}}</span></li>
    <li style="
      color:#323232;
      border:1px solid #ccc;
      padding:8px 11px;
      font-size:15px;
    ">Collected Money <span>₹{{$collected}}</span></li>
  </ul>
@endif
<div id="members-list">
  <table class="vtable fixed" style="table-layout:initial;">
    <tr style="background:#e9eef1;">
      <th style="white-space:nowrap;">क्र० स०</th>
      <th>सदस्य का नाम</th>
      <th class="en-label">सदस्य का लिंग</th>
      <th class="en-label">सदस्य का गाँव</th>
      <th>सदस्य का मोबाइल नंबर</th>
      @if (!$ownerAuthorized)
        <th>भुगतान स्थिति</th>
      @endif
      <th>देखें</th>
      @if ($ownerAuthorized)
        <th style="width:0;">हटाएं</th>
      @endif
    </tr>
    @foreach($members as $member)
      <tr>
        <td style="width:0px;">{{++$i}}</td>
        <td style="white-space:nowrap;">{{$member['fullname']}}</td>
        <td class="en-label">{{$member['gender']}}</td>
        <td class="en-label">{{$member['village']}}</td>
        <td style="white-space:nowrap;">{{$member['number']}}</td>
        @if (!$ownerAuthorized)
          <td>
            @if (\in_array($member['number'], $paid_data))
              <div class="tbl-status">
                <span>Paid</span>
                <svg class="success" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"/></svg>
              </div>
            @else
              <div class="tbl-status">
                <span class="waiting">Dues</span>
                <svg class="error" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              </div>
            @endif
          </td>
        @endif
        @if (!$ownerAuthorized)
          <td style="width:0px;">
            <button class="btn-see" data-fetch-type="self" data-uid="{{$member['number']}}" onclick="fetchMemberInfo(this)">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </td>
        @else
          <td style="width:0;color:#09a909;cursor:pointer;">
            <svg data-uid="{{$member['number']}}" data-fetch-type="all" onclick="fetchMemberInfo(this);" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </td>
          <td style="color:#e32929;cursor:pointer;">
            <svg data-uid="{{$member['number']}}" onclick="deleteMember(this);" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
          </td>
        @endif
      </tr>
    @endforeach
  </table>
</div>
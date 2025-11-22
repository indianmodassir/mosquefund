<div id="members-list">
@if (count($member))
  <table class="vtable" style="table-layout:initial;min-width:517px;">
    <tr style="background:#e9eef1;">
      <th style="white-space:nowrap;">क्र० स०</th>
      <th>सदस्य का नाम</th>
      <th>सदस्य का लिंग</th>
      <th>सदस्य का गाँव</th>
      <th>सदस्य का मोबाइल नंबर</th>
      <th>सचिव आईडी</th>
    </tr>
    @foreach($member as $i => $data)
      <tr>
        <td style="width:0px;">{{$i + 1}}</td>
        <td style="white-space:nowrap;">{{$data['fullname']}}</td>
        <td>{{$data['gender']}}</td>
        <td>{{$data['village']}}</td>
        <td style="white-space:nowrap;">{{$data['number']}}</td>
        <td>{{$data['owner_id']}}</td>
      </tr>
    @endforeach
  </table>
@else
  <h1 class="not-found">Member Not Found!</h1>
@endif
</div>
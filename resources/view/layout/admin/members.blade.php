<style>
  input, button {
    outline: none;
    padding: 0 8px;
    border: 1px solid #ced4da;
    border-radius: 4px;
  }
  button {
    padding: 0 15px;
    color: #fff;
    border: 1px solid #28a745;
    background: #28a745;
    text-shadow: 0 1px 1px #000000;
  }
</style>
<div class="group fixed" style="
  max-width: 100%;
  justify-content:flex-end;
  margin-bottom:18px;
  height: 38px;
  column-gap: 8px;
">
  <input type="number" id="reqId" autocomplete="off" oninput="reset(this.value)">
  <button onclick="filterRequest()" style="
    display: flex;
    justify-content: center;
    align-items: center;
    column-gap: 6px;
  ">
    <i class="fa fa-search"></i>
    <span>Find Member</span>
  </button>
</div>
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
        <td style="white-space:nowrap;" class="mem-number">{{$data['number']}}</td>
        <td>{{$data['owner_id']}}</td>
      </tr>
    @endforeach
  </table>
@else
  <h1 class="not-found">Member Not Found!</h1>
@endif
<h1 class="not-found" style="display:none;">Member Not Found!</h1>
</div>
<script>
  function reset(value) {
    if (!value) {
      $('.mem-number').parent().show();
      $('.not-found').hide();
      $('.vtable').show();
    }
  }
  function filterRequest() {
    const expect_uid = $('#reqId').val();
    if (!expect_uid) return;
    let matched = false;

    $('.mem-number').each((_, el) => {
      const tr = $(el).parent();
      expect_uid == $(el).text() ? ($(tr).show(), matched = true) : $(tr).hide();
    });

    matched ?
      ($('.not-found').hide(), $('.vtable').show())
      : ($('.not-found').show(), $('.vtable').hide());
  }
</script>
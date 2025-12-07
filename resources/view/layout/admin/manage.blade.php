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
    <span>Find Account</span>
  </button>
</div>
<div id="members-list" style="overflow-y:hidden;">
  @if (count($owner))
    <table class="vtable" style="table-layout:initial;min-width:900px;">
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
          <td class="secretary-number">{{$s_owner['number']}}</td>
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
              <i class="fa fa-wrench" style="font-size:15px;"></i>
              <span style="color:inherit!important;font-weight:normal;">Manage</span>
            </button>
          </td>
        </tr>
      @endforeach
    </table>
  @else
    <h1 class="not-found">Account Not Found!</h1>
  @endif
<h1 class="not-found" style="display:none;">Account Not Found!</h1>
</div>
<script>
  function reset(value) {
    if (!value) {
      $('.secretary-number').parent().show();
      $('.not-found').hide();
      $('.vtable').show();
    }
  }
  function filterRequest() {
    const expect_uid = $('#reqId').val();
    if (!expect_uid) return;
    let matched = false;

    $('.secretary-number').each((_, el) => {
      const tr = $(el).parent();
      expect_uid == $(el).text() ? ($(tr).show(), matched = true) : $(tr).hide();
    });

    matched ?
      ($('.not-found').hide(), $('.vtable').show())
      : ($('.not-found').show(), $('.vtable').hide());
  }
</script>
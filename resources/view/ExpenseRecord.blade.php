<div id="content" class="tbl-content" style="max-width:1120px;">
  <div class="header">
    <button type="button" class="close" onclick="closeModel();" style="box-shadow:none!important;">
      <span aria-hidden="true">×</span>
    </button>
    <h4>SECRETARY EXPENSE DETAILS / सचिव व्यय विवरण</h4>
  </div>
  <div class="form-container">
    <form id="paymentForm">
      <table class="vtable">
        <tr>
          <th style="width:235px;">Secretary Name / सचिव का नाम</th>
          <td>{{$fullname}}</td>
        </tr>
        <tr>
          <th>Mobile No / मोबाइल नं</th>
          <td>{{$number}}</td>
        </tr>
        <tr>
          <th>District / जिला</th>
          <td>{{$district}}</td>
        </tr>
        <tr>
          <th>Circle पोस्ट / अंचल</th>
          <td>{{$block}}</td>
        </tr>
        <tr>
          <th>Village ग्राम / मोहल्ला</th>
          <td>{{$village}}</td>
        </tr>
      </table>
      <div style="width:100%; overflow:auto;">
        <table class="vtable tbl-extends">
          <tr>
            <td class="theader center" colspan="2">समग्र एकत्रित निधि का विवरण / Overall Collected fund Details</td>
          </tr>
          <tr>
            <td style="max-width:inherit;">Total Deposit Balance / कुल जमा शेष राशि: ₹{{$collected}}</td>
            <td>Overall Collection Balance / कुल जमा राशि: ₹{{$total_balance}}</td>
          </tr>
        </table>
      </div>
      <div style="width:100%; overflow:auto;">
        <table class="vtable tbl-extends">
          <tr>
            <td class="theader center" colspan="4">सचिव द्वारा खर्च की गई राशि का विवरण / Details of Secretary spent Amount</td>
          </tr>
          <tr style="background:#e9eef1;">
            <th style="white-space:nowrap;width:80px;">क्र० स०</th>
            <th style="width:200px;">खर्च की गई राशि</th>
            <th>खर्च का विवरण</th>
            <th style="width:200px;">खर्चे की दिनांक</th>
          </tr>
          @if (count($expenses))
            @foreach($expenses as $i => $expense)
              <tr>
                <td>{{$i + 1}}</td>
                <td>{{$expense['amount']}}</td>
                <td>{{$expense['describe']}}</td>
                <td>{{$expense['date']}}</td>
              </tr>
            @endforeach
            <tr>
              <td colspan="3" style="text-align:end;">Total / कुल</td>
              <td>₹{{$total_expense}}</td>
            </tr>
          @else
          <tr>
            <td colspan="4" style="text-align:center;padding:33px 15px;">Record Not Found!</td>
          </tr>
          @endif
        </table>
      </div>
    </form>
  </div>
</div>
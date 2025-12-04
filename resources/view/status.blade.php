<div id="content" class="tbl-content" style="max-width:1120px;">
  <div class="header">
    <button type="button" class="close" onclick="closeModel();$('#btn_search').attr('data-uid', '');" style="box-shadow:none!important;">
      <span aria-hidden="true">×</span>
    </button>
    <h4>MEMBER DETAILS / सदस्य विवरण</h4>
  </div>
  <div class="form-container">
    <form id="paymentForm">
      <input type="hidden" name="uid" value="{{$request_number}}" autocomplete="off">
      <input type="hidden" name="csrf" value="{{csrf}}" autocomplete="off">
      <table class="vtable">
        <tr>
          <th style="width:0;white-space:nowrap;"><span class="en-label">Member name / </span>सदस्य का नाम</th>
          <td>{{$member->fullname}}</td>
          <td id="profile" rowspan="4"><img src="{{$member->profile}}" alt="{{$member->fullname}}" width="100" style="max-height:118px;" draggable="false"></td>
        </tr>
        <tr>
          <th style="width:0;white-space:nowrap;"><span class="en-label">Member mobile number / </span>सदस्य का मोबाइल नंबर</th>
          <td>{{$member->number}}</td>
        </tr>
        <tr>
          <th style="width:0;white-space:nowrap;"><span class="en-label">Gender of Member / </span>सदस्य का लिंग</th>
          <td>{{$member->gender}}</td>
        </tr>
        <tr>
          <th style="width:0;white-space:nowrap;"><span class="en-label">Village of Member / </span>सदस्य का गाँव</th>
          <td>{{$member->village}}</td>
        </tr>
        <tr>
          <td class="theader center" colspan="3">Last Payment Details / अंतिम भुगतान का विवरण</td>
        </tr>
      </table>
      <section style="width:100%;overflow:auto;">
        <table class="vtable tbl-extends">
          <tr style="background:#eef1f5;">
            <th style="white-space:nowrap;">क्र० स०</th>
            <th><span class="en-label">FRNo. / </span>शुल्क रसीद संख्या</th>
            <th><span class="en-label">Month From / </span>महीने से</th>
            <th><span class="en-label">Month To / </span>महीने तक</th>
            <th><span class="en-label">Payment Date / </span>भुगतान तिथि</th>
            <th style="width:0;white-space:nowrap;"><span class="en-label">Total / </span>कुल</th>
            <th style="width:0;white-space:nowrap;"><span class="en-label">Status / </span>स्थिति</th>
          </tr>
          <tbody id="payed">
            @foreach($payments as $i => $payment)
              <tr>
                <td>{{$i + 1}}</td>
                <td style="user-select:text;word-break:break-all;">{{$payment['frn']}}</td>
                <td>{{$payment['paid_from']}}</td>
                <td>{{$payment['paid_to']}}</td>
                <td>{{$payment['date']}}</td>
                <td>₹{{$payment['paid_amount']}}</td>
                <td><span>Success</span></td>
              </tr>
            @endforeach
          </tbody>
          <tr id="showMore" onclick="showMore()" hidden>
            <td colspan="6"></td>
            <td><a href="javascript:void(0)" style="font-size:14px;display:block;">See More</a></td>
          </tr>
        </table>
      </section>
      <table class="vtable">
        @if ($dues && !$authorized)
          <tr>
            <td class="theader center" colspan="8">Dues Payment Details / बकाया राशि का विवरण</td>
          </tr>
          <tbody style="width:100%;overflow:auto;">
            <tr style="background:#eef1f5;">
              <th style="white-space:nowrap;">क्र० स०</th>
              <th><span class="en-label">Month From / </span>महीने से</th>
              <th><span class="en-label">Month To / </span>महीने तक</th>
              <th><span class="en-label">Dues / </span>बकाया</th>
              <th><span class="en-label">Payment Date / </span>भुगतान तिथि</th>
              <th style="width:0;white-space:nowrap;"><span class="en-label">Total / </span>कुल</th>
              <th style="width:0;white-space:nowrap;"><span class="en-label">Status / </span>स्थिति</th>
            </tr>
            <tr>
              <td>1</td>
              <td>{{$member->last_paid_to}}</td>
              <td>{{$nextDate->format('d F Y')}}</td>
              <td>{{$accurate_due_month}} महीना</td>
              <td>{{$nextDate->format('d-m-Y h:i:s A')}}</td>
              <td>₹{{$dues}}</td>
              <td><span class="waiting">Waiting</span></td>
            </tr>
          </tbody>
        @else if(!$authorized)
          <tr>
            <td colspan="7" style="text-align:center;white-space:initial;"><span>प्रिय {{$member->fullname}}, आपका इस महीने का कोई बकाया राशि नहीं है। आपने इस महीने का ₹{{$last_payment['paid_amount']}} का भुगतान कर दिया है।</span></td>
          </tr>
        @endif
        <tbody>
          @if ($authorized)
            <tr>
              <td class="theader center" colspan="7">Dues Payment Details / बकाया राशि का विवरण</td>
            </tr>
            <tbody style="width:100%;overflow:auto;">
              <tr style="background:#eef1f5;">
                <th style="white-space:nowrap;">क्र० स०</th>
                <th><span class="en-label">Month From / </span>महीने से</th>
                <th><span class="en-label">Month To / </span>महीने तक</th>
                <th><span class="en-label">Dues / </span>बकाया</th>
                <th><span class="en-label">Payment Date / </span>भुगतान तिथि</th>
                <th style="width:0;white-space:nowrap;"><span class="en-label">Total / </span>कुल</th>
                <th style="width:0;white-space:nowrap;"><span class="en-label">Status / </span>स्थिति</th>
              </tr>
              <tr>
                <td>1</td>
                <td>{{$member->last_paid_to}}</td>
                <td>
                  <select name="due-month" id="dueMonth">
                    @for($i = 1; $i <= $dueMonth; $i++)
                      @php
                        $attr = $i === $dueMonth ? 'selected' : '';
                        $dateModifier = new \DateTime($member->last_date);
                        $dateModifier->modify(\sprintf('+%s month', $i));
                      @endphp
                      <option value="{{$i}}" data-date="{{$dateModifier->format('d-m-Y h:i:s A')}}" {{$attr}}>{{$dateModifier->format('d F Y')}}</option>
                    @endfor
                  </select>
                </td>
                <td id="total_dues_months">{{$accurate_due_month}} महीना</td>
                <td id="datePreview">{{$nextDate->format('d-m-Y h:i:s A')}}</td>
                <td style="white-space:nowrap;">₹<input type="number" name="due-fee" id="duesFee" value="{{$dues}}"></td>
                <td><span class="waiting">Holding</span></td>
              </tr>
            </tbody>
            <tr>
              <td class="nowrap" colspan="7">
                <p>*NOTE:</p>
                <p>यदि एक बार भुगतान हो चुका है, किंतु भुगतान रसीद नहीं मिल पा रहा है तो पिछले भुगतान की स्थिति स्पष्ट होने से पहले पुनः भुगतान ना करें| पिछले भुगतान की स्थिति स्पष्ट करने के लिए “लंबित राशि का विवरण देखेँ” बटन का उपयोग करें| कृपया किसी प्रकार की शिकायत के लिए "{{$owner_email}}" पर ईमेल करें या "+91 {{$owner_number}}" पर कॉल करें|</p>
                <br/>
                <p>During online payment of mosque fund, if amount got debited and you have not received the payment receipt. Please do not go for re-payment, until previous payment status is cleared. To know the status of previous payment, please use “लंबित राशि का विवरण देखेँ” option of this Portal. For any further queries please write to us at [{{$owner_email}}] mentioning the Depostior ID and Transaction ID or Call Mobile No. "+91 {{$owner_number}}".</p>
              </td>
            </tr>
            <tr>
              <td id="tc" class="nowrap" colspan="7">
                <input type="checkbox" name="declaration" id="declaration">&nbsp;&nbsp;<span>I agree to <a href="">Terms & Conditions</a></span>
                <div class="error"></div>
              </td>
            </tr>
          @else
            <tr>
              <td id="bnote" class="nowrap" colspan="7">
                <p>*NOTE:</p>
                <p>यह कंप्यूटर द्वारा तैयार की गई प्रति केवल सूचनात्मक उद्देश्यों के लिए जारी की गई है। हालाँकि डेटा को अत्यंत सावधानी से संसाधित किया गया है, फिर भी अनजाने में त्रुटियाँ या अशुद्धियाँ हो सकती हैं। सत्यापन, सुधार या किसी भी संबंधित समस्या के लिए, कृपया निकटतम मस्जिद के प्रमुख या अधिकृत समिति के प्रतिनिधि से संपर्क करें या {{$owner_email}}" पर ईमेल करें या "+91 {{$owner_number}}" पर कॉल करें|</p>
                <br/>
                <p>This is a computer-generated copy issued for informational purposes only. Although the data has been processed with utmost care, unintentional errors or inaccuracies may still exist. For verification, corrections, or any related concerns, kindly reach out to the head of the nearest mosque or the authorized committee representative. or write to us at [{{$owner_email}}] mentioning the Depostior ID and Transaction ID or Call Mobile No. "+91 {{$owner_number}}".</p>
              </td>
            </tr>
          @endif
        </tbody>
        <tr>
          <td colspan="7">
            <div class="flex-box">
              @if ($authorized)
                <button type="button" id="btnPaid" onclick="openConfirmationPopup(this)">
                  <i class="fa fa-credit-card"></i>
                  &nbsp;PAID NOW
                </button>
              @endif
              <button type="button" data-action="/collector/all" id="btnSearch" data-csrf="{{csrf}}" data-login="member" style="color:#fff;" onclick="{{$searchFn}}(this);$('#btn_search').attr('data-uid', '');">
                <i class="fa fa-search"></i>
                SEARCH AGAIN
              </button>
              <button type="button" style="color:#fff;" id="btnPrint" onclick="Print('form', true)">
                <i class="fa fa-print"></i>
                &nbsp;PRINT
              </button>
            </div>
          </td>
        </tr>
      </table>
    </form>
  </div>
  <script>
  function leadZero(val){ return val <=9 ? '0' + val : val;}
  $('#dueMonth').on('change', ()=>{ const dueDate=$('#dueMonth')[0].selectedOptions[0].dataset['date']; const selectedIndex=$('#dueMonth')[0].selectedIndex + 1; $('#datePreview').text(dueDate); $('#duesFee').val(selectedIndex * 100);$('#total_dues_months').text(leadZero($('#dueMonth option').length - selectedIndex) + '\x20महीना');}); </script>
  <script src="/resources/js/print.min.js"></script>
</div>
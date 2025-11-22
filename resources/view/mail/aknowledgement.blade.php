<!-- Applied -->
@if ($state === 2)
<p style="margin-bottom:11px;">प्रिय <span style="font-weight:600;">{{$applicant}}</span>,</p>
<p style="margin-bottom:11px;">आपका आवेदन <span style="font-weight:600;">{{$applyDate}}</span> तारीख को प्राप्त हुआ जिसका आवेदन क्रमांक संख्या <span style="font-weight:600;">{{$appRef}}</span> है तथा निर्गत करने की संभावित तिथि <span style="font-weight:600;">{{$dueDate}}</span> है|</p>
<p style="margin-bottom:11px;">धन्यवाद,</p>
<p style="margin-bottom:11px;">प्रशासक (इंडियन मोदस्सीर)</p>
<!-- Delivered -->
@elseif ($state === 1)
<p style="margin-bottom:11px;">प्रिय <span style="font-weight:600;">{{$applicant}}</span>,</p>
<p style="margin-bottom:11px;">आपका पंजीकरण आवेदन सफल हुआ जिसका आवेदन क्रमांक संख्या <span style="font-weight:600;">{{$appRef}}</span> है तथा यूजर आईडी <span style="font-weight:600;">{{$userId}}</span> और पासवर्ड <span style="font-weight:600;">{{$password}}</span> है|</p>
<p style="margin-bottom:11px;">धन्यवाद,</p>
<p style="margin-bottom:11px;">प्रशासक (इंडियन मोदस्सीर)</p>
<!-- Rejected -->
@else
<p style="margin-bottom:11px;">प्रिय <span style="font-weight:600;">{{$applicant}}</span>,</p>
<p style="margin-bottom:11px;">आपका पंजीकरण आवेदन अस्वीकार कर दिया गया है जिसका आवेदन क्रमांक संख्या <span style="font-weight:600;">{{$appRef}}</span> है| कृपया ट्रैक स्टेटस पर जाएं और अस्वीकृति का कारण जांचें|</p>
<p style="margin-bottom:11px;">धन्यवाद,</p>
<p style="margin-bottom:11px;">प्रशासक (इंडियन मोदस्सीर)</p>
@endif
<div style="overflow-y:hidden;">
  @if (count($expenses))
    <table class="vtable fixed" style="table-layout:initial;">
      <tr style="background:#e9eef1;">
        <th style="white-space:nowrap;width:80px;">क्र० स०</th>
        <th style="width:200px;">खर्च की गई राशि</th>
        <th>खर्च का विवरण</th>
        <th style="width:200px;">खर्चे की दिनांक</th>
      </tr>
      @foreach($expenses as $i => $expense)
        <tr>
          <td>{{$i + 1}}</td>
          <td>₹{{$expense['amount']}}</td>
          <td>{{$expense['describe']}}</td>
          <td>{{$expense['date']}}</td>
        </tr>
      @endforeach
    </table>
  @else
    <h1 class="not-found">Expense Not Found!</h1>
  @endif
</div>
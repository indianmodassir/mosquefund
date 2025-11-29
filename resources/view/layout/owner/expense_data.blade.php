<div style="overflow-y:hidden;">
  @if (count($expenses))
    <table class="vtable" style="table-layout:initial;">
      <tr style="background:#e9eef1;">
        <th style="white-space:nowrap;">क्र० स०</th>
        <th>खर्च की गई राशि</th>
        <th>खर्च का विवरण</th>
      </tr>
      @foreach($expenses as $i => $expense)
        <tr>
          <td>{{$i + 1}}</td>
          <td>₹{{$expense['amount']}}</td>
          <td>{{$expense['describe']}}</td>
        </tr>
      @endforeach
    </table>
  @else
    <h1 class="not-found">Expense Not Found!</h1>
  @endif
</div>
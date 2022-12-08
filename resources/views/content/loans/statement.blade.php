<div style="display:flex; justify-content:space-around">
    <div>
        <p class="mb-2"><span class="fw-bold">Account no: </span> {{$loan->client->client_id}}</p>
        <p class="mb-2"><span class="fw-bold">Account name: </span> <a href="{{ url('/clients/'.$loan->client->id) }}">{{Str::upper($loan->client->account_name)}}</a></p>
        <p class="mb-2"><span class="fw-bold">Area: </span> {{Str::upper($loan->client->area->name)}}</p>
        <p class="mb-2"><span class="fw-bold">Loan Cycle:</span> {{Str::upper($loan->cycle)}}</p>
    </div>
    <div>
        <p class="mb-2"><span class="fw-bold">Principal Amount: </span> &#8369; {{number_format($loan->principle_amount,2)}}</p>
        <p class="mb-2"><span class="fw-bold">Release Date: </span>{{date('F d, Y',strtotime($loan->rel_date))}}</p>
        <p class="mb-2"><span class="fw-bold">Maturity Date: </span>{{date('F d, Y',strtotime($loan->end_date))}}</p>
        <p class="mb-2"><span class="fw-bold">Close Date: </span>
        @if($loan->close_date="")
            -----------
        @else
            {{date('F d, Y',strtotime($loan->close_date))}}
        @endif
        </p>
    </div>
</div>
<div class="divider">
        <div class="divider-text">
                Index of Payments
        </div>
</div>
<table class="table table-bordered">
        <tr>
            <th width="30"><b>No</b></th>
            <th width="180"><b>Date of Payment</b></th>
            <th width="70"><b>OR #</b></th>
            <th width="70"><b>Amount</b></th>
        </tr>
        
        @if( count($loan->payments) > 0)
            @foreach ($loan->payments as $key=>$payment)
            <tr>
                <td>{{$key +1}}</td>
                <td>{{date('F d, Y', strtotime($payment->date))}}</td>
                <td>{{$payment->or_number}}</td>
                <td>&#8369; {{number_format($payment->amount,2)}}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" align="center">---- No payments made ----</td>
            </tr>
        @endif
        <tr>
            <td colspan="3"><b>Total Payment:</b></td>
            <td align="right">&#8369; {{number_format($loan->payments->sum('amount'),2)}}</td>
        </tr>
        <tr>
            <td colspan="3"><b>Balance:</b></td>
            <td align="right">&#8369; {{number_format($loan->principle_amount - $loan->payments->sum('amount'),2)}}</td>
        </tr>
</table>



<table>
    <tr>
        <td colspan="2" style="background-color: #73b9b6;">Annual Interest Rate (%)</td>
        <td style="background-color: #73b9b6;text-align: left">{{$loanConfData['interest_rate']}}</td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: #73b9b6;">Disbursement Date</td>
        <td style="background-color: #73b9b6;text-align: left">{{$headerCalcData['disbursement_date']}}</td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: #73b9b6;">Provision Start Date</td>
        <td style="background-color: #73b9b6;text-align: left">{{$headerCalcData['provision_start_date']}}</td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: #73b9b6;">Monthly Payment</td>
        <td style="background-color: #73b9b6;text-align: left">{{$headerCalcData['monthly_payment']}}</td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: #73b9b6;">Total Interest</td>
        <td style="background-color: #73b9b6;text-align: left">{{$headerCalcData['total_interest']}}</td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: #73b9b6;">Total Realizable</td>
        <td style="background-color: #73b9b6;text-align: left">{{$headerCalcData['total_realizable']}}</td>
    </tr>
</table>

<table class="table table-sm">
    <thead>
    <tr>
        <th style="width: 50px;background-color: #73b9b6;">No.</th>
        <th style="width: 130px;background-color: #73b9b6;">Payment Date</th>
        <th style="width: 130px;background-color: #73b9b6;">Beginning Balance</th>
        <th style="width: 130px;background-color: #73b9b6;">Payment</th>
        <th style="width: 130px;background-color: #73b9b6;">Principal</th>
        <th style="width: 130px;background-color: #73b9b6;">No of Days</th>
        <th style="width: 130px;background-color: #73b9b6;">Interest</th>
        <th style="width: 130px;background-color: #73b9b6;">Ending Balance</th>
    </tr>
    </thead>
    <tbody>
    @php
        $count = 0;
    @endphp
    @foreach($allScheduleData as $singleSchedule)
        <tr>
            <td style="width: 50px;text-align: center;">{{$singleSchedule['sl']}}</td>
            <td style="width: 130px;text-align: center;">{{$singleSchedule['payment_date']}}</td>
            <td style="width: 130px;text-align: center;">{{$singleSchedule['beginning_balance']}}</td>
            <td style="width: 130px;text-align: center;"><span class="badge bg-info">BDT {{$singleSchedule['payment']}}</span></td>
            <td style="width: 130px;text-align: center;">{{$singleSchedule['principal']}}</td>
            <td style="width: 130px;text-align: center;">{{$singleSchedule['no_of_days']}}</td>
            <td style="width: 130px;text-align: center;">{{$singleSchedule['interest']}}</td>
            <td style="width: 130px;text-align: center;">{{$singleSchedule['ending_balance']}}</td>
        </tr>
        @php
            $count+=$singleSchedule['interest']
        @endphp
    @endforeach
    </tbody>
</table>


<style>
    .tableFixHead          { overflow: auto; height: 400px; }
    .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

    /* Just common table stuff. Really. */
    table  { border-collapse: collapse; width: 100%; }
    th, td { padding: 8px 16px; }
    th     { background-color: #009A93;color: white; }
</style>

<div class="row col-md-12">
    <div class="card col-md-6">
        <div class="card-header">
            <h3 class="card-title">Factors</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0" style="display: block;">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle text-warning"></i> Annual Interest Rate
                        <span class="badge bg-info float-right" style="font-size: large">{{$loanConfData['interest_rate']}} %</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle text-warning"></i> Disbursement Date
                        <span class="badge bg-info float-right" style="font-size: large">{{$headerCalcData['disbursement_date']}}</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle text-warning"></i> Provision Start Date
                        <span class="badge bg-info float-right" style="font-size: large">{{$headerCalcData['provision_start_date']}}</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.card-body -->
    </div>


    <div class="card col-md-6">
        <div class="card-header">
            <h3 class="card-title">Factors</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0" style="display: block;">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle text-warning"></i> Monthly Payment
                        <span class="badge bg-info float-right" style="font-size: large">{{$headerCalcData['monthly_payment']}}</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle text-warning"></i> Total Interest
                        <span class="badge bg-info float-right" style="font-size: large">{{$headerCalcData['total_interest']}}</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle text-warning"></i> Total Realizable
                        <span class="badge bg-info float-right" style="font-size: large">{{$headerCalcData['total_realizable']}}</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<div class="row col-md-12 tableFixHead">
    <table class="table table-sm">
        <thead>
        <tr style="background-color: #009A93;color: white;">
            <th>No.</th>
            <th>Payment Date</th>
            <th>Beginning Balance</th>
            <th>Payment</th>
            <th>Principal</th>
            <th>No of Days</th>
            <th>Interest</th>
            <th>Ending Balance</th>
        </tr>
        </thead>
        <tbody>
        @php
        $count = 0;
        @endphp
        @foreach($allScheduleData as $singleSchedule)
        <tr style="text-align: center;">
            <td>{{$singleSchedule['sl']}}</td>
            <td>{{$singleSchedule['payment_date']}}</td>
            <td>{{$singleSchedule['beginning_balance']}}</td>
            <td><span class="badge bg-info">BDT {{$singleSchedule['payment']}}</span></td>
            <td>{{$singleSchedule['principal']}}</td>
            <td>{{$singleSchedule['no_of_days']}}</td>
            <td>{{$singleSchedule['interest']}}</td>
            <td>{{$singleSchedule['ending_balance']}}</td>
        </tr>
        @php
            $count+=$singleSchedule['interest']
        @endphp
        @endforeach
        </tbody>
    </table>
</div>


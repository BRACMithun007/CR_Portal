
<div class="row">
    <div class="col-md-10 offset-md-1">
        <table class="table table-bordered table-sm" style="margin-top: 10px;">
            <thead>
            <tr>
                <th style="background-color: #57726d;color: white;">Key Name</th>
                <th style="background-color: #57726d;color: white;">Value</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Borrower age</td>
                <td>{{$resultDataArray['displayBorrowerAge']}}</td>
            </tr>
            <tr>
                <td>Borrower age slab</td>
                <td>{{$resultDataArray['borrowerAgeSlab']}}</td>
            </tr>
            <tr>
                <td style="text-align: right;color: black;font-weight: bold;">Premium rate (per thousand per year)</td>
                <td style="text-align: left;color: black;font-weight: bold;">{{$resultDataArray['premiumRateInThousand']}} Taka</td>
            </tr>
            <tr>
                <td style="text-align: right;color: black;font-weight: bold;">Premium amount</td>
                <td style="text-align: left;color: black;font-weight: bold;">{{$resultDataArray['premiumAmountOverLoan']}} Taka</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>







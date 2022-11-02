

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-sm" style="margin-top: 10px;">
            <thead>
                <tr>
                    <th style="background-color: #57726d;color: white;text-align: center;" colspan="2">Borrower</th>
                    <th style="background-color: #57726d;color: white;text-align: center;" colspan="2">Second Insurer</th>
                </tr>
                <tr>
                    <th style="background-color: #57726d;color: white;">Key Name</th>
                    <th style="background-color: #57726d;color: white;">Value</th>
                    <th style="background-color: #57726d;color: white;">Key Name</th>
                    <th style="background-color: #57726d;color: white;">Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Age</td>
                    <td>{{$resultDataArray['displayBorrowerAge']}}</td>
                    <td>Age</td>
                    <td>{{$resultDataArray['displaySecondInsureAge']}}</td>
                </tr>
                <tr>
                    <td>Age slab</td>
                    <td>{{$resultDataArray['borrowerAgeSlab']}}</td>
                    <td>Age slab</td>
                    <td>{{$resultDataArray['secondInsureAgeSlab']}}</td>
                </tr>
                <tr>
                    <td>Premium rate (per thousand per year)</td>
                    <td>{{$resultDataArray['premiumRateInThousandForBorrower']}} Taka</td>
                    <td>Premium rate (per thousand per year)</td>
                    <td>{{$resultDataArray['premiumRateInThousandForSecondInsure']}} Taka</td>
                </tr>
                <tr>
                    <td style="text-align: right;color: black;font-weight: bold;" colspan="2">Total premium rate (per thousand per year)</td>
                    <td style="text-align: left;color: black;font-weight: bold;" colspan="2"> {{$resultDataArray['totalPremiumRateInThousand']}} Taka</td>
                </tr>
                <tr>
                    <td style="text-align: right;color: black;font-weight: bold;" colspan="2">Total premium amount</td>
                    <td style="text-align: left;color: black;font-weight: bold;" colspan="2"> {{$resultDataArray['premiumAmountOverLoan']}} Taka</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>





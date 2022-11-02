
<table>
    <thead>
    <tr>
        <th style="width: 100px;background-color: #73b9b6;">JIRA ID</th>
        <th style="width: 300px;background-color: #73b9b6;">CR Item Name</th>
        <th style="width: 100px;background-color: #73b9b6;">Created At</th>
        <th style="width: 70px;background-color: #73b9b6;">Priority</th>
        <th style="width: 130px;background-color: #73b9b6;">Requester Team</th>
        <th style="width: 120px;background-color: #73b9b6;">MF Tech Team</th>
        <th style="width: 120px;background-color: #73b9b6;">MF Focal</th>
        <th style="width: 110px;background-color: #73b9b6;">Delivery Date</th>
        <th style="width: 110px;background-color: #73b9b6;">Current Status</th>
        <th style="width: 380px;background-color: #73b9b6;">Last Update</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reportData as $data)
        <tr>
            <td style="width: 100px;word-wrap: break-word;">
                {{ trim($data->jira_id) }}
            </td>
            <td style="width: 300px;word-wrap: break-word;">{{ trim($data->cr_item_name) }}</td>
            <td style="width: 100px;word-wrap: break-word;">
                @if($data->jira_created != null && $data->jira_created != "" && $data->jira_created != '0000-00-00')
                {{\Carbon\Carbon::parse($data->jira_created)->format('d M Y')}}
                @else
                    Not mentioned
                @endif
            </td>
            <td style="width: 70px;word-wrap: break-word;text-align: center;">
                @if($data->priority != 99 )
                    {{ trim($data->priority) }}
                @else
                    Not set
                @endif
            </td>
            <td style="width: 130px;word-wrap: break-word;">{{ trim($data->requester_team) }}</td>
            <td style="width: 120px;word-wrap: break-word;text-align: center;">{{ trim($data->team_name) }}</td>
            <td style="width: 120px;word-wrap: break-word;text-align: center;">{{ trim($data->mf_focal) }}</td>
            <td style="width: 110px;word-wrap: break-word;">
                @if($data->vendor_proposed_timeline != null && $data->vendor_proposed_timeline != '' && $data->vendor_proposed_timeline != '0000-00-00')
                    {{\Carbon\Carbon::parse($data->vendor_proposed_timeline)->format('d M Y')}}
                @else
                    Not set
                @endif
            </td>
            <td style="width: 110px;word-wrap: break-word;">{{ trim($data->cr_status) }}</td>
            <td style="width: 380px;word-wrap: break-word;">{{ trim($data->last_update) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@component('mail::message')
#  Hello {{ $body->vendor->name ?? '' }}, <br/>
Your Requisiton has been created.This is Your Requisition No : <strong>{{ $body->requisition_no??'' }}</strong>.<br/>
Please check and Let us Know if you have any queries.

@component('mail::table')
<table style="width: 100%;">
    <thead>
        <tr style="text-align:center;">
            <th>Item</th>
            <th>Size</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody style="background-color: #FFFFFF;border-bottom: 1px solid #EDEFF2;border-top: 1px solid #EDEFF2;margin: 0; padding: 0;width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
        @if(count($items)>0)
        @foreach($items as $item)
        <tr style="text-align:center;">
            <td>{{ $item->item_title }}</td>
            <td>{{ $item->req_size }}</td>
            <td>{{ $item->req_qty }}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="3">
                <strong>No Data Found!</strong>
            </td>
        </tr> 
        @endif
    </tbody>
</table>
@endcomponent

 
@component('mail::button', ['url' => env('APP_URL').'/dashboard/stores/requisitions'])
Visit Our Sites
@endcomponent

Thanks,<br>
{{ env('APP_NAME') }}
@endcomponent

{{-- @dd($body,$items) --}}

    <table width="100%" id="header">
        @php
            $start_date = date('Y-m-d', strtotime(request()->input('start-date')));
            $end_date   = date('Y-m-d', strtotime(request()->input('end-date')));
            $branch_id = request()->input('branch-id');
            $customer_id = request()->input('customer-id');
            $user_id = request()->input('user-id');
            $attribute_id = request()->input('attribute-id');
    
            // Fetch branch name based on branch_id
            $branch = $branch_id ? \App\Models\Branch::find($branch_id)->name : null;
    
            // Fetch customer name based on customer_id
            $customer = $customer_id ? \App\Models\Customer::find($customer_id)->name : null;
    
            // Fetch user name based on user_id
            $user = $user_id ? \App\Models\User::find($user_id)->name : null;

            // Fetch attribute name based on attribute_id
            $attribute = $attribute_id ? \App\Models\Attribute::find($attribute_id)->title : null;
        @endphp
       <tbody>
        <tr>
            <td width="10%" valign="top">
                <h3 style="margin: 0">Search :</h3>
            </td>
            <td width="90%">
                <table width="100%">
                    <tr>
                        <td>
                            @if(request()->filled('start-date') && request()->filled('end-date'))
                                <strong>Start Date:</strong> {{ $start_date }} &nbsp;&nbsp;
                                <strong>End Date:</strong> {{ $end_date }} &nbsp;&nbsp;
                            @endif
                        </td>
                        <td align="right">
                            @if(request()->filled('branch-id'))
                                <strong>Branch:</strong> {{ $branch }} &nbsp;&nbsp;
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @if(request()->filled('customer-id'))
                                <strong>Customer:</strong> {{ $customer }} &nbsp;&nbsp;
                            @endif
                        </td>
                        <td align="right">
                            @if(request()->filled('user-id'))
                                <strong>User:</strong> {{ $user }} &nbsp;&nbsp;
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @if(request()->filled('attribute-id'))
                                <strong>Attribute:</strong> {{ $attribute }} &nbsp;&nbsp;
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
    
    </table>
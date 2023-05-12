
        <body style="font-size:14px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0;padding: 0;">
 
        <table cellpadding="0" cellspacing="0">
            <table style="width:100%;">
            <tr><td colspan="2" align="center"><b>SMARTWAY ACADEMY</b></td></tr>    
            <tr><td colspan="2" align="center" style="font-size:12px;">Address, 396360</td></tr>
            <tr><td colspan="2" align="center" style="font-size:12px;"><b>Contact:</b> +91 90994 95757</td></tr>
            <tr><td></td></tr>
            <tr><td><b>Student:</b>{{ $payments->student_id}}<br />
            {{ $payments->student_name['first_name']}} {{ $payments->student_name['last_name']}} </td><td align="right"><b>No:</b> # {{ $payments->receipt_no }}</td></tr>
            <tr><td><b>Date:</b> {{ $payments->payment_date}} </td></tr>
            <tr><td colspan="2" align="center"><b></b></td></tr>
            <tr class="heading" style="background:#eee;border-bottom:1px solid #ddd;font-weight:bold;">
                <td> Desc</td>
                <td align="right"> Amount </td>
            </tr>
              @foreach($payments->payment_category as $classd)
              <tr class="itemrows">
                  <td> {{ $classd['category_name']->title }}</td>
                  <td align="right"> {{ $classd['amount'] }}</td>
              </tr>
              @endforeach
              <tr><td></td>
                  
              </tr>
            <tr class="total">
                <td></td>
                <td align="right">
                   <b>Total&nbsp;:&nbsp;{{ $payments->total }}</b>
                </td>
            </tr>
           
            </table>
        </table>
  
                </body>


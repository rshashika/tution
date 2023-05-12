
          
        <style type="text/css">
          table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
        }
        </style>          
                   <!--  <address>
                    

                    <h4><strong>Tution Nmae</strong></h4>
                    <h4><strong>Adres</strong></h4>
                    <h4><strong><?php echo date("Y-m-d"); ?></strong></h4>
                    <h4><?php echo date("h:i:sa"); ?></h4>
                    </address> -->
   
                
               
                 <h3 class="panel-title"><center><strong>Tution Attendence  Details</strong></center></h3>
                 <center>
             <table border="1">
                  <thead>
                    <tr>
                      <th style="width:40px; ">#</th>
                      <th style="width:100px; ">Tution  </th>
                      <th style="width:110px; "> Students  Count</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @php  $i=1; //print_r($levels)   @endphp
                    @foreach($levels as $pro)
                                <tr>
                                  <td>{{ $i}}</td>
                                <td class="text-left">{{ $pro->subject }}</td>
                             <td style="text-align: center; font-size: 17px;">{{ $pro->student_count }} </td>
                              </tr>  
                    @php  $i++; @endphp 
                     @endforeach 
        
                  </tbody>
                </table>
                </center>
 
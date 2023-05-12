
          
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
   
                
               
                 <h3 class="panel-title"><center><strong>Student  Details</strong></center></h3>
                 <center>
             <table border="1">
                  <thead>
                    <tr>
                      <th style="width:20px; ">#</th>
                   <th >Admission Num</th>
                      <th style="width:150px; "> Name</th>
                      <th style="width: 110px;" > Birth</th>
                      <th style="width:200; ">Address</th>
                      <th style="width:100px; ">Contact</th>
                       <th style="width:175; ">Classes / Join Dates</th>
                      {{-- <th style="width:200px; ">Registered Date</th> --}}
                    </tr>
                  </thead>
                  <tbody>
                    @php  $i=1; //print_r($levels)   @endphp
                    @foreach($student_data as $pro)
                                <tr>
                                  <td>{{ $i}}</td>
                                <td class="text-left">{{ $pro->admission_num }}</td>
                             <td style="text-align: center; font-size: 17px;">{{ $pro->first_name }} {{ $pro->last_name }}</td>
                               <td style="text-align: center;">{{ $pro->birth }}</td>
                                    <td style="text-align: center; font-size: 17px;">{{ $pro->address }}</td>
                                    <td style="text-align: center; font-size: 17px;">{{ $pro->contact }}</td>
                                   
                                   <td><?php 
                                  
                                   $students_class =DB::table('studentin_classes')
                                     ->select('studentin_classes.*','tutions.subject')
                                    ->where('studentin_classes.student_id',$pro->admission_num)
                                  //  ->join('students', 'students.admission_num', '=', 'studentin_classes.student')
                                    ->join('tutions', 'tutions.id', '=', 'studentin_classes.class')
                                    ->get();
                                     ?>
                                     @foreach($students_class as $pro)
                                       {{ $pro->subject }} -{{ $pro->join_date }}
                                     @endforeach
                                     </td> 
                                    {{-- <td style="text-align: center; font-size: 17px;">{{ $pro->created_at }}</td>   --}}
                                </tr>  
                                  @php  $i++; @endphp 
                                @endforeach 
        
                  </tbody>
                </table>
                </center>
 
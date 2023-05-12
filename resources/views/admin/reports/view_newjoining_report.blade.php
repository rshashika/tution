
        <html>
 <head>
  <link href="//bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> <!--
<script src="//bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



<link rel="stylesheet" href="{{ asset('css/backend_css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/backend_css/bootstrap-responsive.min.css') }}" />
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}"> -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> -->


 <!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>



       </head>
       <body>    
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
   
                 <div class="container">
          <br>
              <button onclick="window.location='{{ url("admin/view-reports") }}'" class="btn btn-primary font-weight-bolder"> Back</button>    

          <!-- <div class="card-header"> -->
            <h3 class="text-center">Filter Student  New Joined Details</h3>
          <!-- </div> -->
          <br>
          <div>
   <form enctype="multipart/form-data" class="form-inline" method="post" action="{{ url('admin/view-student-new-joining-report') }}" name="add_Place" id="add_Place" >  {{ csrf_field() }}
            
   
              
                  <div class="form-group  m-auto">
                     
                   
                  &nbsp;<label class="form-label">Select Class &nbsp;</label>
                  <select name="class_id" id="class"  class="form-control select2" >
                     <option value="0" >Select Class </option>
                      @foreach($classes as $cs )
                  <option value="{{ $cs->id }}"@if(!empty($classid) && $cs->id==$classid) selected @endif>{{ $cs->subject }}</option>
                  @endforeach
                  </select>

                  &nbsp; <label class="form-label">Select Month &nbsp;</label>
                  <input type="month" name="date" id="date" class="form-control" value="{{$start }}"> &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="submit" id="tempadd" value="Filter " class="btn btn-success btn-sm"> &nbsp;
                  <input type="button" onclick="location.href='{{ url('admin/view-student-new-joining-report') }}';" id="tempadd" value="Reset " class="btn btn-danger btn-sm">
                   </form>
                   </div>

              </div>
            </div>         
                 
                 <h3 class="panel-title"><center><strong>Student  New Joined Details</strong></center></h3>
                 <center>
             <table border="1">
                  <thead>
                    <tr>
                      <th style="width:20px; ">#</th>
                   <th style="width:250px; "> Student </th>
                      <th style="width:150px; " class="text-center"> Class  </th>
                       <th style="width:175; " class="text-center"> Join Date</th> 
       
                    </tr>
                  </thead>
                  <tbody>
                    @php  $i=1;  @endphp
                    @foreach($newstudents as $pro)
                                <tr>
                                  <td>{{ $i}}</td>
                                <td class="text-left">{{ $pro->student_id."-".$pro->studentname['first_name']." ".$pro->studentname['last_name'] }}</td>
                            
                               <td style="text-align: center;">{{ $pro->classname['subject'] }}</td>
                                    <td style="text-align: center;">{{ $pro->join_date }}</td>
                                </tr>  
                                  @php  $i++; @endphp 
                     @endforeach 
        
                  </tbody>
                </table>
                </center>
 
</body>
</html>
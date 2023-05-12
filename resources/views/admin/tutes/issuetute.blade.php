@extends('layouts.adminLayout.admin_design')
@section('content')
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 
</head>

 <div class="content-wrapper">
  @if(Session::has('flash_message_error'))
        <div class="alert alert-error alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{!! session('flash_message_error') !!}</strong>
        </div>
    @endif   
    @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{!! session('flash_message_success') !!}</strong>
        </div>
    @endif 

  <section class="content">
    <div class="container-fluid">
         <div class="row mb-2">
          <div class="col-sm-6">
            <h1 >  Issue Tutes </h1>
          </div>

           </div>
      </div><!-- /.container-fluid -->
    </section>
  <section class="content">
    <div class="container-fluid">
         <div class="card ">
             
             <form enctype="multipart/form-data" class="form-horizontal" method="post" action="#" name="issue_tute" id="issue_tute" >  {{ csrf_field() }}
                  
          <div class="card-body">
          <div class="row"> 

             <div class="col-md-6">

                  <div class="form-group">
                      <label> Select Student</label>
                   <select class="select2 form-control"  name="student" id="student" required onload="myFunction()">
                    <option value=" " selected="true" disabled="true"  ><h6>Student Ad Num </h6></option>
                   @foreach($students as  $value)
                    <option value="{{$value->student_id}}">{{$value->student_id}}</option>
                     @endforeach
                       
                     </select>
                   </div>

  
      
                </div>
                <div class="col-md-6">

                   <div class="form-group">
                <label class="form-label">Select Month</label>
                  <input type="month" name="month" id="month" class="form-control" required>
                  </div>

                  <input type="hidden" name="tution_id" id="tution_id" value="{{ $id}}">
                   <input type="hidden" name="tute_id" id="tute_id" value="{{ $tid}}">
                 {{--  <div class="form-group">
                    <label>Price</label>
                     <input type="text" class="form-control fees" name="tute_fee" id="tute_fee">
                  </div> --}}
                </div>
 
      
              <div class="form-actions">
                <button type="button" id="tempadd" value="Add " class="btn btn-success btn-sm"><i class="ik save ik-save"></i> Issue</button>
              </div>
            </div>
          </div>
            </form>
             
             


          </div>
        </div>
      </section>

         <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
            <div class="card-header">
            <h3 class="card-title"> {{ $tuteDetails['teacher_name']->first_name." ".$tuteDetails['teacher_name']->last_name."- ".$tuteDetails->subject }} Tute - {{ $tuteDetails['tute_class'][0]->tute_name}} </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
         
               {{--  <table id="viewtbl" class="table table-bordered table-striped">
                  <thead>
                <tr>
                 
                </tr>
              </thead>
              <tbody>

                @if($tutes != null)
                @foreach($tutes as $tute)
                <tr class="gradeX">
                 
                  <td>{{$tute['student_name']->admission_num }}</td>
                   <td> {{ $tute->rate}} </td>
                  <td> {{ date('F', strtotime($tute->month_for)) }}  </td> 
                 
                   
                
              </tr>
              
                @endforeach
                @endif
              </tbody>
            </table> --}}
            
    <table id="tbldata" class="table table-bordered table-striped ajax_view" >
                                 <thead>
                                    <tr>
                                    <th>Student </th>
                                    <th>Rate /Is Free </th>
                                    <th>Month</th>
                                    </tr>
                                 </thead>
                                  
                                  
                 </table>
         
                      </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
       
      </div>
    <!-- </div>
  </div>
</div> -->

<script type="text/javascript">

$( document ).ready(function() {
 // $.ajaxSetup({
 //          headers: {
 //              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 //          }

 //    });

  var tute_id = $("#tute_id").val();
    var tution_id = $("#tution_id").val();

      sell_table = $('#tbldata').DataTable({
        processing: false,
        serverSide: true,
        aaSorting: [[0, 'desc']],
    
    // responsive: true,
     "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],

        ajax: "{{ url('issuetutes') }}"+'/'+tute_id+'/'+tution_id,

        columns: [
            { data: 'student', name: 'student' },
            { data: 'rate', name: 'rate'  },
            { data: 'month_for', name: 'month_for' }
      
        ],

    });

    });
       

 //      }

 //       });

  $('#tempadd').click(function() {
    // var is_free = $("#is_free").val();
    var tute_id = $("#tute_id").val();
    var tution_id = $("#tution_id").val();
    var month=$('#month').val();
    var student_id =$('#student').val();

    //if (fees||clas||student||month) {}
    //alert(current_pwd);
    $.ajax({
    //  type:'get',
      url:'/mark-issue-tute',
      data:{
       "_token": "{{ csrf_token() }}",
      tute_id:tute_id,tution_id:tution_id,student_id:student_id,month:month},
      headers: {
                "cache-control": "no-cache"
            },
            // data: {
            //     coupon_code: coupon_code
            // },
            type: 'post',
            dataType: 'json',
      success:function(resp){
       // location.reload();
          document.getElementById("issue_tute").reset();
          sell_table.ajax.reload();
       // alert(resp);
        if(resp=='true'){
     //alert("hh");
      const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
      Toast.fire({
        icon: 'success',
        title: 'Record Added.'
      })
        }else if(resp=="false"){
           const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
         Toast.fire({
        icon: 'error',
        title: 'Something Wrong.'
      })
    // alert("hh");
        }else if(resp=="error"){
          const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
         Toast.fire({
        icon: 'error',
        title: 'Already Issued.'
      })
        }
    
     //   location.reload();
      },error:function(){
       // alert("Error");
        const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
         Toast.fire({
        icon: 'error',
        title: 'Please Enter the Details First.'
      })
      }
    });
  });
//});

</script>
{{-- <script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('fetchdata') }}",
        columns: [
            {data: 'Student', name: 'Student'},
            {data: 'Type', name: 'Type'},
            {data: 'Total', name: 'Total'},
            {data: 'Action', name: 'Action', orderable: false, searchable: false},
        ]
    });
    
  });
</script> --}}
   
@endsection
 




   
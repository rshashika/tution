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
            <h1 > Manage Tutes </h1>
          </div>

           </div>
      </div><!-- /.container-fluid -->
    </section>
  <section class="content">
    <div class="container-fluid">
         <div class="card ">
             
             <form enctype="multipart/form-data" class="form-horizontal" method="post" action="#" name="add_tute" id="add_tute" >  {{ csrf_field() }}
                  
          <div class="card-body">
          <div class="row"> 

             <div class="col-md-6">

                <div class="form-group">
                    <label>Tute Name/Code</label>
                     <input type="text" class="form-control fees" name="tute_name" id="tute_name">
                  </div>

                  <div class="form-group">
                      <label> Select Class</label>
                   <select name="class_id" id="class_id" class="form-control select2" required>
                    <option value=" " selected="true" disabled="true"  ><h6>Choose Class </h6></option>

                   @foreach($tutions as  $value)
                   @foreach($value->class_name as $details)
                    <option value="{{ $value->id}}">{{ $value->first_name." ".$value->last_name."-".$details->subject}}</option>
                    @endforeach
                     @endforeach
                       
                     </select>
                   </div>          
                  
                  <div class="form-group">
                <label class="form-label">Free</label>
                  <input type="checkbox" name="is_free" id="is_free" value="1">
              </div>
      
                </div>
                <div class="col-md-6">

                   <div class="form-group">
                <label class="form-label">Select Month</label>
                  <input type="month" name="month" id="month" class="form-control" required>
                  </div>

                   <div class="form-group">
                <label class="form-label">Issue Date</label>
                  <input type="date" name="issue_date" id="issue_date" class="form-control" required>
                  </div>

                  <div class="form-group">
                    <label>Price</label>
                     <input type="text" class="form-control fees" name="tute_fee" id="tute_fee">
                  </div>
                </div>

                   
             
                
                  
                    


              
      
              <div class="form-actions">
                <button type="button" id="tempadd" value="Add " class="btn btn-success btn-sm"><i class="ik save ik-save"></i> Add</button>
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
            <h3 class="card-title">Tutes  </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                
            {{ csrf_field() }}
               {{--  <table id="viewtbl" class="table table-bordered table-striped">
                  <thead>
                <tr>
                  <th>Tute Name</th> 
                  <th>Class </th>
                  <th>Rate /Is Free </th>
                  <th>Month</th>
                 <th>Delete</th> 
                </tr>
              </thead>
              <tbody>

                
                @foreach($tutes as $tute)
                 @foreach($tute->tute_class as $det)
                  @if($tute->tute_class != null)
                <tr class="gradeX">
                  <td>{{$det->tute_name}}</td>
                  <td>{{$tute->subject}}- {{ $tute->teacher_name->first_name." ".$tute->teacher_name->last_name }}</td>
                 
                   <td> @if( $det->is_free ==1  )  Free @else {{$det->price}} @endif</td>
                  <td> {{ date('F', strtotime($det->month_for)) }}  </td> 
                
                   
                 <td class="center">
                  <a href="{{ url('/admin/issue-tute/'.$det->tution_id.'/'.$det->id) }}" class="btn btn-sm bg-gradient-cyan mr-2"><i class="ik save ik-star-on"></i> Issue Tute
                   </a>
                  <a  class="deleteRecord btn btn-danger btn-sm" rel="{{ $tute->id }}" rel1="delete-tute" href="javascript:" > <i class="fas fa-trash"> </i> Delete</a></td> 
              </tr>
              @endif
               @endforeach
                @endforeach
              </tbody>
            </table> --}}
            <table id="tbldata" class="table table-bordered table-striped ajax_view" >
                                 <thead>
                                    <tr>
                                       <th>Tute Name</th> 
                                    <th>Class </th>
                                    <th>Rate /Is Free </th>
                                    <th>Month</th>
                                   <th>Delete</th> 
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
 $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }

    });
      sell_table = $('#tbldata').DataTable({
        processing: false,
        serverSide: true,
        aaSorting: [[0, 'desc']],
    
    // responsive: true,
     "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        // "ajax": {
        //     "url": '/fetch_data'
        // },
         ajax: "{{ url('tutes') }}",
        columns: [
            { data: 'tute_name', name: 'tute_name' },
            { data: 'class', name: 'class' },
            { data: 'rate', name: 'rate'  },
            { data: 'month_for', name: 'month_for' },
            { data: 'action', name: 'action' , "searchable": false}
        ],

    });

    });

  $('#tempadd').click(function() {



    var tute_name = $("#tute_name").val();
       var is_free = $("#is_free").prop('checked')
    var tution_id = $("#class_id").val();
    var month=$('#month').val();
    var tute_fee =$('#tute_fee').val();
    var issue_date=$('#issue_date').val();

    //if (fees||clas||student||month) {}
    //alert(current_pwd);
    $.ajax({
    //  type:'get',
      url:'/add-tute',
      data:{
       "_token": "{{ csrf_token() }}",
      is_free:is_free,tution_id:tution_id,tute_fee:tute_fee,month:month,tute_name:tute_name,issue_date:issue_date},
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
          document.getElementById("add_tute").reset();
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
        title: 'Already Added.'
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
 




   
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
            <h1 > Fees Manage </h1>
          </div>

           </div>
      </div><!-- /.container-fluid -->
    </section>
  <section class="content">
    <div class="container-fluid">
         <div class="card ">
             
             <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/manage-students-feestype')}}" name="add_Place" id="add_Place" >  {{ csrf_field() }}
                  
          <div class="card-body">
          <div class="row"> 

             <div class="col-md-6">

                  <div class="form-group">
                      <label> Select Student</label>
                   <select class="select2 form-control"  name="student" id="student_fee" required onload="myFunction()">
                    <option value=" " selected="true" disabled="true"  ><h6>Student Ad Num </h6></option>
                   @foreach($students as $key => $value)
                    <option value="{{$value->admission_num}}">{{$value->admission_num}}</option>
                     @endforeach
                       
                     </select>
                   </div>

             
               
                   <div class="form-group">
                <label class="form-label">Select Class</label>
                  <select name="class" id="class_id_fee" class="form-control select2" required>
                <option value="0" disabled="true" selected="true">Select Class</option>
                  </select>
                  </div>

                </div>
                <div class="col-md-6">

                   <div class="form-group">
                <label class="form-label">Select Month</label>
                  <input type="month" name="month" id="month" class="form-control" required>
                  </div>

                   <div class="form-group">
                      <label class="form-label">Select Type</label>
                    <select name="fees_type" id="fees_type" class="form-control" >
              <option value="FREE_CARD">FREE CARD</option>
              <option value="HALF_CARD">HALF CARD</option>
              {{-- <option value="CHARGE">CHARGE</option> --}}
              </select>
                   </div>

                </div>

              
      
              <div class="form-actions">
              <button type="submit" class="btn btn-primary btn-sm"><i class="ik save ik-save"></i> Save</button>
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
            <h3 class="card-title">Fess Manage  </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <table id="viewtbl" class="table table-bordered table-striped">
                  <thead>
                <tr>
                 <!--  <th>Product Name</th>  -->
                  <th>Student </th>
                  <th>Class</th>
                  <th>Month</th>
                  <th>Fees</th>
                 <th>Action</th> 
                </tr>
              </thead>
              <tbody>

                
                @foreach($billtemptble as $bill)
                <tr class="gradeX">
                  <td>{{$bill->student_id}}</td>
                  <td>{{$bill->subject}}</td> 
                  <td>{{$bill->month_for}}</td>
                  <td>{{$bill->amount}}</td>
                  <td class="text-right">
                                          <div class="actions">
                                             <a href="{{ url('/admin/edit-students-feestype/'.$bill->id) }}" class="btn btn-info btn-sm">
                                              <i class="fas fa-pencil-alt">
                                              </i> Edit

                                             </a>
                                             
                                             <a  class="deleteRecord btn btn-danger btn-sm" rel="{{ $bill->id }}" rel1="delete-students-feestype" href="javascript:" > <i class="fas fa-trash">
                                              </i> Delete</a>
                                             
                                           
                                            
                                          </div>
                                       </td> 
              </tr>
                
                @endforeach
              </tbody>
            </table>
           
            </tr>
           </tbody>
                     
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

$(document).ready(function($) {

<?php  if(Session::has('smessage')){ ?>
      Toast.fire({
        icon: 'success',
        title: '<?php echo session('smessage') ?>'
      })

      <?php }elseif(Session::has('emessage')){ ?>
         Toast.fire({
        icon: 'error',
        title: '<?php echo session('emessage') ?>'
      })
    <?php }elseif(Session::has('dmessage')){ ?>
         Toast.fire({
        icon: 'warning',
        title: '<?php echo session('dmessage') ?>'
      })
      <?php } ?>


});
</script>
<script type="text/javascript">
  $(function(){

     const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

     
      $('#student_fee').on('change',function(e){
       console.log(e);
      var stud=e.target.value;

         //ajax
         $.get('/json-class?stud='+stud,function(data){
        console.log(data);
        $('#class_id_fee').empty();
         $('#class_id_fee').append('<option value="0" selected="true" disabled="true">Select Class </option>');

        $.each(data,function(index,brandObj){
         $('#class_id_fee').append('<option value="'+brandObj.id+'">'+brandObj.first_name+' - '+brandObj.subject+'</option>');
        });
        });
    });

   


});

</script>
   
@endsection
 




   
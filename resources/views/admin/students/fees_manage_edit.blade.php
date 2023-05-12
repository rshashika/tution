@extends('layouts.adminLayout.admin_design')
@section('content')


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
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Student Fees</h1>
          </div>
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div> -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
  <section class="content">
  <section class="content">
    <div class="container-fluid">
         <div class="card ">
          <!-- <div class="card-header">
            <h3 class="card-title">Student Information</h3>
          </div> -->
             
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/edit-students-feestype/'.$levels->id) }}" name="add_student" id="add_student" > {{ csrf_field() }}
                
         <div class="card-body">
          <div class="row"> 

             <div class="col-md-6">

                  <div class="form-group">
                      <label> Select Student</label>
                   <select class="select2 form-control"  name="student" id="student_fee" required >
                    <option value=" " selected="true" disabled="true"  ><h6>Student Ad Num </h6></option>
                   @foreach($students as $key => $value)
                    <option  value="{{$value->admission_num}}" {{ $levels->student_id ==$value->admission_num ? 'selected' : '' }}>{{$value->admission_num}}</option>
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
                  <input type="month" name="month" id="month" class="form-control" value="{{ $levels->month_for}}">
                  </div>

                   <div class="form-group">
                      <label class="form-label">Select Type</label>
                    <select name="fees_type" id="fees_type" class="form-control" >
              <option value="FREE_CARD" {{ $levels->fees_type =="FREE_CARD" ? 'selected' : '' }}>FREE CARD</option>
              <option value="HALF_CARD" {{ $levels->fees_type =="HALF_CARD" ? 'selected' : '' }}>HALF CARD</option>
              {{-- <option value="CHARGE">CHARGE</option> --}}
              </select>
                   </div>

                </div>

              
      
             
            </div>
          </div>
              
      
              <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm"><i class="ik save ik-save"></i>Update</button>
                 <button onclick="history.back()" class="btn btn-outline-dark btn-sm"><i class="ik arrow-left ik-arrow-left"></i> Go Back</button>
              </div>
            </form>
              
          </div> 
        </div>
      </section>

      <!-- /////////////////////////////////// -->
      

      <!-- //////////////////////////////// -->


      </div>
    <!-- </div>
  </div>
</div> -->



    
    
   
@endsection
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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

     

    
      var stud={{ $levels->student_id }}

         //ajax
         $.get('/json-class?stud='+stud,function(data){
        console.log(data);
        $('#class_id_fee').empty();
        $("#class_id_fee").find(':selected').val({{$levels->class}});
         // $('#class_id_fee').append('<option value="'+brandObj.id+'"   >'+brandObj.first_name+' - '+brandObj.subject+'</option>');

        $.each(data,function(index,brandObj){
         $('#class_id_fee').append('<option value="'+brandObj.id+'">'+brandObj.first_name+' - '+brandObj.subject+'</option>');
        });
        });
    



   

});


</script>
<script type="text/javascript">
     function loadclass(){
        alert("gg");
      }

</script>
   
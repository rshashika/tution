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
            <h1>Update Student Details</h1>
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
             
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/edit-student/'.$levels->id) }}" name="add_student" id="add_student" > {{ csrf_field() }}
                
          <div class="card-body">
          <div class="row">
            <div class="col-md-6">
                 
                           
                  <div class="form-group">
                    <label>First Name</label>
                     <input type="text" class="form-control" name="fname" value="{{ $levels->first_name }}" required>
                  </div>
                    
                     <div class="form-group">
                    <label>Last Name</label>
                       <input type="text" class="form-control" name="lname" value="{{ $levels->last_name }}" required>
                     </div>

                     <div class="form-group">
                    <label>Date Of Birth</label>
                       <input type="date" class="form-control" name="dob" value="{{ $levels->birth }}" required>
                     </div>

                     <div class="form-group">
                    <label> Address</label>
                       <textarea class="form-control" name="address" required> {{ $levels->address }} </textarea>
                     </div>

                     <div class="form-group">
                    <label>Email </label>
                       <input type="email" class="form-control" name="email" value="{{ $levels->email }}" >
                     </div>

                     <div class="form-group">
                    <label>Contact Num</label>
                       <input type="text" class="form-control" name="contact" value="{{ $levels->contact }}" maxlength="10" required>
                     </div>

                     <div class="form-group">
                    <label>WhatsApp Num</label>
                       <input type="number" minlength="9" maxlength="10" class="form-control" name="whatsapp"  value="{{ $levels->whatsapp }}" >
                     </div>

                     
  

              </div> 

              <div class="col-md-6">
                <div class="form-group">
                    <label>Admission Num</label>
                       <input type="number" class="form-control" name="admission" value="{{ $levels->admission_num }}" required>
                     </div>

                <div class="form-group">
                    <label>Parent Name</label>
                    <input type="text" class="form-control" name="parent_name" value="{{ $levels->parent_name }}">
                </div>

                <div class="form-group">
                    <label>Parent Mobile</label>
                    <input type="text" class="form-control" name="mobile" value="{{ $levels->parent_mobile }}" maxlength="10">
                </div>
                    
                 
                   <div class="form-group">
                    <div class="custom-control custom-switch  custom-switch-on-success">
                      <input type="checkbox" name="active_sms" @if($levels->is_active_sms == "1") checked @endif value="1" class="custom-control-input" id="customSwitch1">
                      <label class="custom-control-label" for="customSwitch1">Active / Deactivate Messages </label>
                    </div>
                  </div>
                   
                
                   

                <div class="form-group">
                <label class="form-label">Image</label>
                   <div class="controls">
                  <div id="uniform-undefined">
                    <table>
                      <tr>
                        <td>
                          <input name="image" id="image" type="file">
                          @if(!empty($levels->image))
                            <input type="hidden" name="current_image" value="{{ $levels->image }}"> 
                          @endif
                        </td>
                        <td>
                          @if(!empty($levels->image))
                            <img style="width:30px;" src="{{ asset('/images/students/small/'.$levels->image) }}"> | <a href="{{ url('/admin/delete-student-image/'.$levels->id) }}">Delete</a>
                          @endif
                        </td>
                      </tr>
                    </table>
                </div>
                </div>
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

  $('#main_cat_id').on('change',function(e){
    console.log(e);
    var main_cat_id=e.target.value;
    $.get('/ajax-brands?main_cat_id='+main_cat_id,function(data){
      console.log(data);
      $('#brand_id').empty();
      $('#brand_id').append('<option value="0">Brand Name</option>');

      $.each(data,function(index,brandObj){
        $('#brand_id').append('<option value="'+brandObj.brand_id+'">'+brandObj.brand_name+'</option>');
      });
    });
  });
</script> 

   
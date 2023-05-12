@extends('layouts.adminLayout.admin_design')
@section('content')
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://unpkg.com/html5-qrcode"></script>
 <style type="text/css">
   .card-footer {
    background-color: rgb(255 255 255) !important;

}
 </style>
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
         <!-- <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Class Information</h3>
          </div>
             
             <form enctype="multipart/form-data" class="form-horizontal" method="post" action="#" name="add_Place" id="add_Place" novalidate="novalidate">  {{ csrf_field() }}
                  
          
            </form>
             
             </div> -->
            
        <div id="qr-reader-results"></div>
        
          <input type="hidden" name="subject" id="subject" value="{{ $classdetails->subject}}">
           <input type="hidden" name="teacher" id="teacher" value="{{ $classdetails->teacher}}">
           <input type="hidden" name="id" id="id" value="{{ $classdetails->id}}">
        <div class="row row row-cols-1">
          
          <!-- /.col -->
          <div class="col-md-6">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user h-100">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">{{ $classdetails->first_name." ".$classdetails->last_name}} <br>Subject: {{ $classdetails->subject}}</h3>
                <h5 class="widget-user-desc">{{ $currentTime->toDateString() }}</h5>
              </div>
               @if($tutes)
              <div class="card-body"> 

              <label>Current Month Tutes -: </label>
               
                {{-- <span>{{$tute->tute_name}} | </span> --}}
                {{-- <div class="form-group"> --}}
                    <div class="custom-control custom-switch  custom-switch-on-success">

                      <input type="checkbox" name="tuteid" id="customSwitch1" value="1" class="tuteid custom-control-input" >
                      <label class="custom-control-label" for="customSwitch1">{{$tutes->tute_name}} </label>
                    </div>

                  
                  {{-- </div> --}}
        
                </div>
                @endif
              <div class="row p-3">

                <label class="col-6"> <input type="radio" name="colorRadio" value="barcode"> QR</label>
                <label class="col-6"> <input type="radio" name="colorRadio" value="admission_Num">Admission Number </label>
              </div>
               



              <div class="card-footer text-center" id="admis" style="display:none;">
               
                <div class="input-group">
                    <input type="text" name="message" id="studnum" placeholder=" Student Number ..." required class="form-control" autofocus/>

                    
                    <span class="input-group-append admission_num" >
                      <button type="submit" id="send" class="btn btn-danger">Mark</button>
                    </span>
                   
                  </div> 
              </div>
              <div class="card-footer text-center" id="barcode" style="display:none;">
               
                <div class="input-group">
                 <div id="qr-reader" style="width:500px"></div>
                  </div> 
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
          <!-- /.col -->
          <div class="col-md-6" id="stuname" >
            <!-- Widget: user widget style 1 -->
          

          </div>
        </div>
             

      </div>
          </section>  
      </div>
    <!-- </div>
  </div>
</div> -->

<script type="text/javascript">
  $(function(){

     const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

       });

  // function loadCategories() {
  //           $.ajax({
  //               url: "/details",
  //               type: 'GET',
  //               success: function(data){
  //                   console.log(data)
  //               }
  //           })
  //       }

   
   

  $('#send').click(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
      // Toast.fire({
      //   icon: 'success',
      //   title: 'Please enter the Student Number.'
      // })
    var student = $("#studnum").val();
     var clas = $("#id").val();
     var subject = $("#subject").val();
     var teacher=$('#teacher').val();

     var tuteid=$('.tuteid:checked').val();
     
    if (student==0) {
      // alert(student);
       const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
      Toast.fire({
        icon: 'error',
        title: 'Please enter the Student Number.'
      })
    }else{
  
   // alert(clas);
    $.ajax({
    //  type:'get',
      url:'/check-attendence',
      data:{
       "_token": "{{ csrf_token() }}",
      subject:subject,clas:clas,student:student,teacher:teacher,tuteid:tuteid},
      headers: {
                "cache-control": "no-cache"
            },
            // data: {
            //     coupon_code: coupon_code
            // },
            type: 'post',
            dataType: 'json',
      success:function(resp){

     //  alert(resp);
      var ims="{{ asset('images/students/small') }}";
       if(resp['issue_tute']== 1) {
        var tute_issued =1;
       } else{
   
        var tute_issued =0;

       }
        if(resp['paid']==0){
                

                 if (resp['check']==1) {
                  var freecard=resp['freecard']== 0 ? "Fees Not Paid" :"Free Card";
                //  var ims="{{ asset('images/students/small') }}";
                 var html = `<div class="card card-widget h-100 widget-user"><div class="widget-user-header bg-gradient-gray"><h3 class="widget-user-username">${resp.first_name} ${resp.last_name}</h3><h5 class="widget-user-desc" >${freecard} </h5></div><div class="widget-user-image"><img class="img-circle elevation-2" src="${ims}/${resp.image}" alt="User Avatar"></div><div class="card-footer"><div class="alert alert-danger alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-exclamation-triangle"></i> Attendence Already Marked !</h5></div> </div></div>`;

              }else if(resp['check']==0){
                var student = $("#studnum").val();
                var freecard=resp['freecard']== 0 ? "Fees Not Paid" :"Free Card";
               //  var ims="{{ asset('images/students/small') }}";
                var html = `<div class="card card-widget h-100 widget-user"><div class="widget-user-header bg-gradient-gray"><h3 class="widget-user-username">${resp.first_name} ${resp.last_name}</h3><h5 class="widget-user-desc" >${freecard}  </h5></div><div class="widget-user-image"><img class="img-circle elevation-2" src="${ims}/${resp.image}" alt="User Avatar"></div><div class="card-footer text-center"> <div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Attendence Marked !</h5></div>${tute_issued==1  ? "<div class='alert alert-default-primary alert-dismissible'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h5><i class='icon fas fa-book'></i> Tute Issued</h5></div>" : ""}</div></div>`;

              }

              // <a type="button" href="{{ url('admin/add-paymentinattend/${student}/${clas}') }}" class="btn btn-danger">Pay Now</a> 
      
                    $('#stuname').html(html);
        }else if(resp['paid']==1){

              if (resp['check']==1) {

                 var html = `<div class="card card-widget h-100 widget-user"><div class="widget-user-header bg-gradient-gray"><h3 class="widget-user-username">${resp['first_name']} ${resp['last_name']}</h3><h5 class="widget-user-desc" >Fees  Paid  </h5></div><div class="widget-user-image"><img class="img-circle elevation-2" src="${ims}/${resp.image}" alt="User Avatar"></div><div class="card-footer"><div class="alert alert-danger alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-exclamation-triangle"></i> Attendence Already Marked !</h5> </div></div></div>`;

              }else if(resp['check']==0){

                 var html = `<div class="card card-widget h-100 widget-user"><div class="widget-user-header bg-gradient-gray"><h3 class="widget-user-username">${resp['first_name']} ${resp['last_name']}</h3><h5 class="widget-user-desc" >Fees  Paid  </h5></div><div class="widget-user-image"><img class="img-circle elevation-2" src="${ims}/${resp.image}" alt="User Avatar"></div><div class="card-footer"><div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Attendence Marked !</h5>${tute_issued==1  ? "<div class='alert alert-default-primary alert-dismissible'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h5><i class='icon fas fa-book'></i> Tute Issued</h5></div>" : ""}</div></div>`;

              }
           
              
                    $('#stuname').html(html);
    // alert("hh");
        } 
        if (resp=="notisstudent") {
          var html = '<div class="alert alert-danger alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-ban"></i> Student Not Registered or Invalid Number</h5> </div>';

             $('#stuname').html(html);
        }

          if (resp=="studentnotincls") {
            var html = '<div class="alert alert-danger alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-ban"></i> Student Not Registered for this Class or Invalid Number</h5> </div>';

             $('#stuname').html(html);
          }

     //   location.reload();
      },error:function(){
      //  alert("Error");
      }

    });
  }

  });


</script>

<script type="text/javascript">
 var resultContainer = document.getElementById('qr-reader-results');
var lastResult, countResults = 0;

function onScanSuccess(decodedText, decodedResult) {
    if (decodedText !== lastResult) {
        ++countResults;
        lastResult = decodedText;
        // Handle on success condition with the decoded message.
        console.log(`Scan result ${decodedText}`, decodedResult);

        const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
      // Toast.fire({
      //   icon: 'success',
      //   title: 'Please enter the Student Number.'
      // })
    var student = decodedText;
     var clas = $("#id").val();
     var subject = $("#subject").val();
     var teacher=$('#teacher').val();
     var tuteid=$('.tuteid:checked').val();
    if (student==0) {
     // alert(student);
       const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
      Toast.fire({
        icon: 'error',
        title: 'Please enter the Student Number.'
      })
    }else{
  
   // alert(clas);
    $.ajax({
    //  type:'get',
      url:'/check-attendence',
      data:{
       "_token": "{{ csrf_token() }}",
      subject:subject,clas:clas,student:student,teacher:teacher,tuteid:tuteid},
      headers: {
                "cache-control": "no-cache"
            },
            // data: {
            //     coupon_code: coupon_code
            // },
            type: 'post',
            dataType: 'json',
      success:function(resp){

     //  alert(resp);
       var ims="{{ asset('images/students/small') }}";
       if(resp['issue_tute']== 1) {
        var tute_issued =1;
       } else{
   
        var tute_issued =0;

       }
        if(resp['paid']==0){
                

                 if (resp['check']==1) {
                  var freecard=resp['freecard']== 0 ? "Fees Not Paid" :"Free Card";
                //  var ims="{{ asset('images/students/small') }}";
                 var html = `<div class="card card-widget h-100 widget-user"><div class="widget-user-header bg-gradient-gray"><h3 class="widget-user-username">${resp.first_name} ${resp.last_name}</h3><h5 class="widget-user-desc" >${freecard} </h5></div><div class="widget-user-image"><img class="img-circle elevation-2" src="${ims}/${resp.image}" alt="User Avatar"></div><div class="card-footer"><div class="alert alert-danger alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-exclamation-triangle"></i> Attendence Already Marked !</h5></div> </div></div>`;

              }else if(resp['check']==0){
                var student = $("#studnum").val();
                var freecard=resp['freecard']== 0 ? "Fees Not Paid" :"Free Card";
               //  var ims="{{ asset('images/students/small') }}";
                var html = `<div class="card card-widget h-100 widget-user"><div class="widget-user-header bg-gradient-gray"><h3 class="widget-user-username">${resp.first_name} ${resp.last_name}</h3><h5 class="widget-user-desc" >${freecard}  </h5></div><div class="widget-user-image"><img class="img-circle elevation-2" src="${ims}/${resp.image}" alt="User Avatar"></div><div class="card-footer text-center"> <div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Attendence Marked !</h5></div>${tute_issued==1  ? "<div class='alert alert-default-primary alert-dismissible'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h5><i class='icon fas fa-book'></i> Tute Issued</h5></div>" : ""}</div></div>`;

              }

              // <a type="button" href="{{ url('admin/add-paymentinattend/${student}/${clas}') }}" class="btn btn-danger">Pay Now</a> 
      
                    $('#stuname').html(html);
        }else if(resp['paid']==1){

              if (resp['check']==1) {

                 var html = `<div class="card card-widget h-100 widget-user"><div class="widget-user-header bg-gradient-gray"><h3 class="widget-user-username">${resp['first_name']} ${resp['last_name']}</h3><h5 class="widget-user-desc" >Fees  Paid  </h5></div><div class="widget-user-image"><img class="img-circle elevation-2" src="${ims}/${resp.image}" alt="User Avatar"></div><div class="card-footer"><div class="alert alert-danger alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-exclamation-triangle"></i> Attendence Already Marked !</h5> </div></div></div>`;

              }else if(resp['check']==0){

                 var html = `<div class="card card-widget h-100 widget-user"><div class="widget-user-header bg-gradient-gray"><h3 class="widget-user-username">${resp['first_name']} ${resp['last_name']}</h3><h5 class="widget-user-desc" >Fees  Paid  </h5></div><div class="widget-user-image"><img class="img-circle elevation-2" src="${ims}/${resp.image}" alt="User Avatar"></div><div class="card-footer"><div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Attendence Marked !</h5>${tute_issued==1  ? "<div class='alert alert-default-primary alert-dismissible'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h5><i class='icon fas fa-book'></i> Tute Issued</h5></div>" : ""}</div></div>`;

              }
           
       
                    $('#stuname').html(html);
    // alert("hh");
        } 
        if (resp=="notisstudent") {
          var html = '<div class="alert alert-danger alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-ban"></i> Student Not Registered or Invalid Number</h5> </div>';

             $('#stuname').html(html);
        }

          if (resp=="studentnotincls") {
            var html = '<div class="alert alert-danger alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-ban"></i> Student Not Registered for this Class or Invalid Number</h5> </div>';

             $('#stuname').html(html);
          }

     //   location.reload();
      },error:function(){
      //  alert("Error");
      }

    });
  }
  
    }
}

var html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
</script>

<script type="text/javascript">

   $(document).ready(function(){
      $('input[type="radio"]').click(function(){

        
          var inputValue = $(this).attr("value");
          //alert(inputValue)
          if(inputValue == "barcode"){

           document.getElementById('admis').style.display = 'none';
           document.getElementById('barcode').style.display = 'block';
           
          }else{
            document.getElementById('admis').style.display = 'block';
           document.getElementById('barcode').style.display = 'none';
          }
      });
  });
</script>
   
@endsection
 




   
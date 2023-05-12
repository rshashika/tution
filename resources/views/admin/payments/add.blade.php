@extends('layouts.adminLayout.admin_design')
@section('content')
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 <link href="https://cdn.datatables.net/plug-ins/1.12.1/api/sum().js" rel="stylesheet">
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
            <h1 > Payments </h1>
          </div>

           </div>
      </div><!-- /.container-fluid -->
    </section>
  <section class="content">
    <div class="container-fluid">
         <div class="card ">
             
             <form enctype="multipart/form-data" class="form-horizontal" method="post" action="#" name="add_Place" id="add_Place" >  {{ csrf_field() }}
                  
          <div class="card-body">
          <div class="row"> 

             <div class="col-md-6">

                  <div class="form-group">
                      <label> Select Student</label>
                   <select class="select2 form-control"  name="student" id="student" required onload="myFunction()">
                    <option value=" " selected="true" disabled="true"  ><h6>Student Ad Num </h6></option>
                   @foreach($students as $key => $value)
                    <option value="{{$value->admission_num}}">{{$value->admission_num}}</option>
                     @endforeach
                       
                     </select>
                   </div>

             
               
                   <div class="form-group">
                <label class="form-label">Select Class</label>
                  <select name="class_id" id="class_id" class="form-control select2" required>
                <option value="0" disabled="true" selected="true">Select Class</option>
                  </select>
                  </div>

                </div>
                <div class="col-md-6">

                   <div class="form-group">
                <label class="form-label">Select Month</label>
                  <input type="month" name="month" id="month" class="form-control" required>
                  </div>
                </div>

                   
             
                
                 <!--  <div class="form-group">
                    <label>Fees</label> -->
                     <input type="hidden" class="form-control fees" name="fees" id="fees">
                  <!-- </div> -->
                    


              
      
              <div class="form-actions">
                <button type="button" id="tempadd" value="Add " class="btn btn-success btn-sm"><i class="ik save ik-save"></i> Add</button>
              </div>
            </div>
          </div>
            </form>
             
             


          </div>
        </div>
      </section>

      {{--   <div class="container">
  
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Type</th>
                <th>Total</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div> --}}

      <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Fees  </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                 <form class="form-horizontal" method="post" action="{{ url('/admin/add-billpaymon') }}" name="add_bill" id="add_bill"> 
            {{ csrf_field() }}

               <table id="tbldata" class="table table-bordered table-striped ajax_view" >
                                 <thead>
                                    <tr>
                                    <th>Class </th>
                                    <th>Month</th>
                                    <th>Total</th>
                                   <th>Delete</th> 
                                    </tr>
                                 </thead>
                                 
                                  
                 </table>
                {{-- <table id="viewtbl" class="table table-bordered table-striped">
                  <thead>
                <tr>
                 
                  <th>Month</th>
                  <th>Total</th>
                 <th>Delete</th> 
                </tr>
              </thead>
              <tbody>

                <?php $total_amount = 0; ?>
                @foreach($billtemptble as $bill)
                <tr class="gradeX">
                 
                  <td>
                      <input type="text" name="sku"  value="{{ date('F', strtotime($bill->month_for)) }}" readonly>
                    <input type="hidden" name="student"  value="{{$bill->student_id}}"readonly>
                  </td> 
                  <td>
                    @if($bill->amount !=0)
                  <input type="text" name="total" class="total" id="total"  value="{{ $bill->amount}}"readonly>

                  @else ($bill->amount ==0)  <span class="text-success">FREE CARD</span >  @endif
                  </td>
                    <?php //$tot=($bill->id * $bill->id); ?>
                 <td class="center">
                  <a  class="deleteRecord btn btn-danger btn-sm" rel="{{ $bill->id }}" rel1="delete-feestemp" href="javascript:" > <i class="fas fa-trash"> </i> Delete</a></td> 
              </tr>
                <?php  $total_amount =$total_amount + ($bill->amount); ?>
                @endforeach
              </tbody>
            </table> --}}
            <table id="viewtbl" class="table-sm">
              <tbody>
               <tr>
                  <td><strong>Total</strong></td>
                  <td><input type="text"  class="tot" name="tot" id="tot"   style="width: 160px;"> </td>
              </tr>
    
                <tr>
                      <td style="border:none;"><strong style="font-size: 15px;">Pay Amount</strong></td>
                      <td style="border:none;"><input type="text" name="amount" id="amount" style="width: 160px;"></td>
                    </tr>
                  </tbody>
              <tbody >
                    <tr>
                      <td style="border:none;"><strong style="font-size: 15px;">Balance</strong></td>
                      <td style="border:none;"><input type="text" class="balance" name="balance" id="balance" style="width: 160px;"></td>
                    </tr>
                  </tbody>
                  <tbody>
                    <tr> 
                   
                      <td style="border:none;"><input type="submit" value="Save " class="btn btn-danger btn-sm"></td>
                      
                    </tr>
                  </tbody> 
            </table>
         


          </form>

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
        bFilter: false,
        bInfo:false,
        bPaginate: false,
        // aaSorting: [[0, 'desc']],
    
    // responsive: true,
     // "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        // "ajax": {
        //     "url": '/fetch_data'
        // },
         ajax: "{{ url('view-temppay') }}",
        columns: [
            { data: 'student', name: 'student' },
            { data: 'class', name: 'class' },
            { data: 'amount', name: 'amount'  },
            { data: 'action', name: 'action' , "searchable": false}
        ],

    //     drawCallback: function () {
    //   var api = this.api();
    //   $( api.table().footer() ).html(
    //     api.column( 2, {page:'current'} ).data().sum()
    //   );
    // }
      //   drawCallback: function () {
      //   var sum = $('#tbldata').DataTable().column(2).data().sum();
      //  $('#tot').html(sum);

      // },

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // computing column Total of the complete result 
            var monTotal = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
        
     
       // console.log(monTotal);
          $('#tot').val(monTotal);
            // Update footer by showing the total with the reference of the column index 
      // $( api.column( 0 ).footer() ).html('Total');
      //       $( api.column( 1 ).footer() ).html(monTotal);
      //       $( api.column( 2 ).footer() ).html(monTotal);
      //       $( api.column( 3 ).footer() ).html(monTotal);
    
        },

    });

        
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

     
       var student = $("#student").val();
      if(student){
      

         //ajax
         $.get('/json-class?stud='+student,function(data){
        console.log(data);
        $('#class_id').empty();
         $('#class_id').append('<option value="0" selected="true" disabled="true">Select Class </option>');

        $.each(data,function(index,brandObj){
         $('#class_id').append('<option value="'+brandObj.id+'">'+brandObj.first_name+' - '+brandObj.subject+'</option>');
        });
        });

       

      }

       });

  

$( document ).ready(function() {

      
    //    $('#student').on('change',function(e){
    //    console.log(e);
    //   var stud=e.target.value;

    //      //ajax
    //      $.get('/json-class?stud='+stud,function(data){
    //     console.log(data);
    //     $('#class_id').empty();
    //      $('#class_id').append('<option value="0" selected="true" disabled="true">Select Class </option>');

    //     $.each(data,function(index,brandObj){
    //      $('#class_id').append('<option value="'+brandObj.id+'">'+brandObj.first_name+' - '+brandObj.subject+'</option>');
    //     });
    //     });
    // });

    $('#amount').keyup(function(){
    //          //  var tr=$(this).parent().parent();
            
    //          // var discount=tr.find('.discount').val();
    //           //tr.find('.tt').val(subtot);
    //          // tr.find('.amount').val(subtotal);
    //           // alert("h");
               var tot = $('#tot').val();
                var pay = $('#amount').val();

              var bal= pay-tot;
              $('#balance').val(bal);
    //       //     var price=tr.find('.price').val();
          
    //       //     //var tot=(qty * price );
    //       //     var total= (qty * price)- (qty * price * discount)/100;
    //       //     tr.find('.total').val(total);
            
    //       //      subtotal();
    //       //     var discount=tr.find('.Discount').val();
    //       //     var amount=(total-discount);
    //       //     tr.find('.amount').val(amount);
    //       //     subamount();
               });
  });
   

  $('#tempadd').click(function() {
    var fees = $("#fees").val();
    var clas = $("#class_id").val();
    var student = $("#student").val();
    var month=$('#month').val();

    //if (fees||clas||student||month) {}
    //alert(current_pwd);
    $.ajax({
    //  type:'get',
      url:'/add-temp',
      data:{
       "_token": "{{ csrf_token() }}",
      fees:fees,clas:clas,student:student,month:month},
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

   
@endsection
 




   
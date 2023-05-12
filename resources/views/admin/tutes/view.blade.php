@extends('layouts.adminLayout.admin_design')
@section('content')
   
        
 <div class="content-wrapper">
   

   
 
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Issued Tutes </h1>
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card ">
           <div class="card-header">
                <div class="col-md-6 d-block">
        <a href="{{ url('/admin/issue-tute') }}" class="btn btn-sm btn-dark float-left"><i class="ik plus-square ik-plus-square"></i> Issued Tute</a>
      </div>
              </div>
              <div class="card-body">

                <table id="viewtbl" class="table table-bordered table-striped">
                                 <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Class</th>
                                       <th>Student</th>
                                       <th>Month </th>
                                       <th>Issue Date</th>
                                       {{-- <th>Status</th> --}}
                                       {{-- <th class="text-left">Action</th> --}}
                                    </tr>
                                 </thead>
                                 @foreach($tutes as $ind => $class)
                                 <tbody>
                                    <tr> 
                                      <td>{{$ind+1}}</td>
                                      <td>{{ $class->tution_id}}</td>
                                       <td>{{ $class->first_name }}</td>
                                       <td>{{ $class->payment_date }} </td>
                                       <td>{{ $class->total }}</td>
                                        
                                     
                                       {{-- <td class="text-left">
                                          <div class="actions">
                                               <a href="{{ url('/admin/view-morepaym/'.$class->id) }}" class="btn btn-primary btn-sm">
                                                <img src="https://img.icons8.com/external-smashingstocks-circular-smashing-stocks/20/000000/external-receipt-shopping-and-e-commerce-smashingstocks-circular-smashing-stocks.png"/> View</a> 
                                            
                                              <a href="{{ url('/admin/print-monthreceipt/'.$class->id) }}" class="btn btn-info btn-sm"> <i class="fas fa-print">
                                              </i> Print
                                                </a> 
                                          </div>
                                       </td> --}}
                                    </tr>
                                   
                                 </tbody>
                                  @endforeach
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
    <!-- /.content -->
    
  </div>
       
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function($) {

   

// $("#employee_id").select2();
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
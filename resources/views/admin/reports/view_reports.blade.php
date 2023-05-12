@extends('layouts.adminLayout.admin_design')
@section('content')

 <div class="content-wrapper">
 

  <section class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <!-- <div class="card-header">
                <h3 class="card-title">View Classes</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
          <!-- <div class="widget-content nopadding"> -->
            <table class="table ">
              <thead>
                <tr>
                 <td> <a  href="{{ url('/admin/view-teachers-report') }}" class="btn btn-warning btn-sm">Teachers View </a> </td>
                  <td>
                  <a  href="{{ url('/admin/view-students-report') }}" class="btn btn-warning btn-sm">Students Views </a></td>
                </tr>
              </thead>
              <tbody>
                 <tr>
                 {{-- <td> <a  href="{{ url('/admin/view-teachattendence-report')}}" class="btn btn-warning btn-sm">Techers Attendence </a></td> --}}
                  <td>
                    <a  href="{{ url('/admin/view-monthlyattend-report')}}" class="btn btn-warning btn-sm">Monthly Attendence Class Wise </a>
                  </td>
                   <td>
                   <a  href="{{ url('/admin/view-attendence-report')}}" class="btn btn-warning btn-sm">Students Attendence </a></td>
                </tr>      
              
              </tbody>
               <tbody>
                 <tr>
                  <td> <a  href="{{ url('/admin/view-studentpayment-report')}}" class="btn btn-warning btn-sm">Students Payments </a></td> 
        
                   <td>
                   <a  href="{{ url('/admin/view-studentwiseclass-report')}}" class="btn btn-warning btn-sm">Student Counts Wise Class </a></td>
                </tr>      
              
              </tbody>
               <tbody>
                 <tr>
                  <td> <a  href="{{ url('/admin/view-student-pending-payment-report')}}" class="btn btn-warning btn-sm">Students Pending Payments </a></td> 
                   <td>
                    <a  href="{{ url('/admin/view-student-new-joining-report')}}" class="btn btn-warning btn-sm">Students New Joining  </a>
                   </td>
                </tr>      
              
              </tbody>
           
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
   </section>
 </div>

@endsection
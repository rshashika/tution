<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\payment;
use App\tution;
use App\student;
use App\feestemp;
use App\student_registration_fees_temp;
use Session;
use App\students_fees;
use App\student_registration_fees;
use App\studentin_class;
use App\payment_category;
use App\student_fees_manage;
use Illuminate\Support\Facades\Input;
use DB;
use Elibyy\TCPDF\Facades\TCPDF;
use DataTables;
// use PDF;

class PaymentController extends Controller
{
    
       
    //student registration payment
      public function new(Request $request,$id){
       // echo $id;
       //     die;
        $paycats = payment_category::where('is_deleted',0)->get();
        $student=student::where('id',$id)->first();
        // $billtemptble = 0;
         $month=date('Y-m', strtotime(date('Y-m')));
  
           $billtemptble = DB::table('student_registration_fees_temps')
            ->select('student_registration_fees_temps.*','payment_categories.title')
            ->join('payment_categories', 'payment_categories.id', '=', 'student_registration_fees_temps.payment_cat')
           // ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
           // ->where('studentin_classes.student', $stud)
               ->where('student_registration_fees_temps.added',Session::get('adminDetails')['branch'])
            ->get();
         $billtemptble = json_decode(json_encode($billtemptble));
       //  $student=$id;
          //   $billtemptble = json_decode(json_encode($billtemptble));
        return view('admin.payments.newpay')->with(compact('paycats','student','billtemptble'));
    }



     public function attributepaytype(Request $request)
    {
         // $type=Input::get('id');
           $type = $request->id;
         // $class_id=Input::get('id');
         // $main=MainCategory::get();
          $attributes=payment_category::where('id','=',$type)->get();
       //  $attributes=tution::where('id','=',$class_id)->get();
         return response()->json($attributes);
         // echo "<pre>"; print_r($attributes); die;
    }

     public function UpdateRegPay(Request $request){
        $data = $request->all();
         //echo "<pre>"; print_r($data);
         $month=date('Y-m', strtotime(date('Y-m')));
        $stu=$data['student'];
         //$temp = new feestemp;
        // DB::beginTransaction();
        // try {

            $temp = new student_registration_fees_temp;
             $temp->student_id = $data['student'];
             $temp->amount = $data['amount'];
             $temp->payment_cat =  $data['type'];
             $temp->added=Session::get('adminDetails')['branch'];
  
             if($temp->save()){
                // echo "true"; die;
                echo json_encode('true');
               
             }else{
               // echo "false"; die;
                echo json_encode('false');   

             }
        //     DB::commit();
        // } catch (Exception $e) {
        //     DB::rollback();
        // }
         
      // echo "<pre>"; print_r($data);

          // return $billtemptble; die;
          //  $this->Details();           
    }

    public function deletefees(Request $request, $id = null){
        if(!empty($id)){
            feestemp::where(['id'=>$id])->delete();
            return redirect()->back()->with('dmessage','Deleted Successfully!');
           // return redirect('admin/add-payment')->with('dmessage', 'Deleted successfully');
        }
    }


    public function delete_registartoin_fees(Request $request, $id = null)
    {
        if(!empty($id)){
            student_registration_fees_temp::where(['id'=>$id])->delete();
            return redirect()->back()->with('dmessage','Deleted Successfully!');
           // return redirect('admin/add-payment')->with('dmessage', 'Deleted successfully');
        }
    }


     public function addpayment(Request $request){
            if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
             $ReceiptNo = time();
            // $person = feestemp::all();
             // DB::beginTransaction();
             // try {
                 $person = student_registration_fees_temp::where('added',Session::get('adminDetails')['branch'])->get();
             $pay = new payment;
             $pay->receipt_no = $ReceiptNo;
             $pay->student_id = $data['student'];
             $pay->payment_date = date('Y-m-d');
             $pay->payment_details =$person;
             $pay->total = $data['tot'];
             $pay->payment_res='Register';
             $pay->added = Session::get('adminDetails')['branch'];
             $pay->save();
             $lastinsertid=$pay->id;

            // $trans_id = DB::getPdo()->lastInsertId();
           // $trans = DB::table('billtemp')->get();

             foreach($person as $pro){

                 $Pro = new student_registration_fees;
                 $Pro->payment_id=$lastinsertid;
                 $Pro->student_id = $pro->student_id;
                 $Pro->payment_cat = $pro->payment_cat;
                 // $Pro->payment_date = date('Y-m-d');
                 $Pro->amount = $pro->amount;
                 $Pro->added = Session::get('adminDetails')['branch'];
                 $Pro->save();
             }
               
          DB::table('student_registration_fees_temps')->where('added',Session::get('adminDetails')['branch'])->delete();
          

            return redirect('/admin/view-students')->with('smessage','Student Registered Successfully!'); 
             //     DB::commit();
             // } catch (Exception $e) {
             //     DB::rollback();
             // }

              
      }
  } 

      public function viewPaymentsReg(){
      //  $pays = payments::get();     
        // $data = session()->all();
        // print_r($data); die;
        $pays = DB::table('payments')
                ->select('payments.*','students.first_name')
                ->join('students', 'students.admission_num', '=', 'payments.student_id')
               // ->join('studentsfees', 'studentsfees.student_code', '=', 'students.admission_num')
                ->where('payments.payment_res','Register')
                // ->where('studentsfees.tution_code','Paid')
                ->get();

        $pays = json_decode(json_encode($pays));

       // echo "<pre>"; print_r($brnd); die;
        return view('admin.payments.viewreg')->with(compact('pays'));
    }


     public function viewPaymentsmore(Request $request,$id=null){


         $class = payment::where(['id'=>$id])->first();

       //  print_r($class); die;
         $payments = DB::table('payments')
        ->select('payments.*','students.first_name','students.last_name','students.admission_num','students.address')
        ->join('students', 'students.admission_num', '=', 'payments.student_id')
        ->where('payments.id', $id)
        ->first();

         $class = json_decode(json_encode($payments));     
        $payd=json_decode($class->payment_details);
         foreach ($payd as $key => $value) {
            // $subject=paymentcategory::where(['id'=>$value->class])->first();
             $subject=tution::where(['id'=>$value->class])->first();
            $payd[$key]->class=$subject->subject;
            }

       // echo "<pre>"; print_r($payd); die;
           //   $studn = student::where(['admission_num'=>$class->student_id])->first();
          //   $studn = json_decode(json_encode($studn));

           // echo "<pre>"; print_r($payments); die;
        return view('admin.payments.viewmore')->with(compact('payments','payd'));
    }

      public function add(Request $request){
        // if($request->isMethod('post')){
        //     $data = $request->all();
        //     //echo "<pre>"; print_r($data); die;

        //     // if(empty($data['status'])){
        //     //     $status='0';
        //     // }else{
        //     //     $status='1';
        //     // }
        //     // if(empty($data['meta_title'])){
        //     //     $data['meta_title'] = "";    
        //     // }
        //     // if(empty($data['meta_description'])){
        //     //     $data['meta_description'] = "";    
        //     // }
        //     // if(empty($data['meta_keywords'])){
        //     //     $data['meta_keywords'] = "";    
        //     // }
        //     $category = new payments;
        //     $category->grade = $data['grade'];
        //     $category->teacher = $data['teacher'];
        //     $category->time = $data['time'];
        //      $category->subject = $data['subject'];
        //     // $category->meta_title = $data['meta_title'];
        //     // $category->meta_description = $data['meta_description'];
        //     // $category->meta_keywords = $data['meta_keywords'];
        //     // $category->status = $status;
        //     $category->save();
        //     return redirect()->back()->with('flash_message_success', 'Category has been added successfully');
        // }

        $levels = tution::where('is_deleted',0)->get();
        $students=student::where('is_deleted',0)->get();
        // $billtemptble = 0;
        
           //  $billtemptble = feestemp::get();
   //            $billtemptble = DB::table('feestemps')
   //  ->select('feestemps.*','tutions.grade','tutions.subject')
   //  ->join('tutions', 'tutions.id', '=', 'feestemps.class')
   // // ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
   //  ->where('feestemps.added',Session::get('adminDetails')['branch'])
   //  ->get();
       // $billtemptble = json_decode(json_encode($billtemptble));
         
   //  $billtemptble = json_decode(json_encode($billtemptble));
      //  die;
        return view('admin.payments.add')->with(compact('levels','students'));
    }


     public function payments_view(Request $request)
    {
         // $data = $request->all();
        // $id = $request->get('id');
        if (request()->ajax()) {

         $billtemptble = DB::table('feestemps')
            ->select('feestemps.*','tutions.grade','tutions.subject')
            ->join('tutions', 'tutions.id', '=', 'feestemps.class')
           // ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
            ->where('feestemps.added',Session::get('adminDetails')['branch'])
            ->get();

          // $tutedets=[];
          //   foreach($data as $tut){
          //       $tutedet=[];
          //       foreach($tut->tute_class as $tute){
          //            $tute['first_name']=$tut->teacher_name->first_name;
          //           $tute['last_name']=$tut->teacher_name->last_name;
          //           $tute['subject']=$tut->subject;
          //           array_push($tutedets,$tute );
          //       }
          //   }
            
           // print_r(json_encode($tutedets));

            return Datatables::of($billtemptble)
                // foreach($data->tute_class as $tute){
                ->addColumn('student',function ($row){
                    return $row->student_id;
                })
                 ->addColumn('class',function ($row){
                    return $row->subject;
                })
                //   ->addColumn('amount',function ($row){
                //     return $row->amount;
                // })
                ->addColumn('amount',function ($row) {
                        // if($row->amount ==0){
                        //    $col='<span class="text-success">FREE CARD</span >';
                        //    return $col;
                        // }else{
                            return $row->amount;  
                        // }                            
                })
                ->addColumn('action', function($row){
                           $btn = '<a  class="deleteRecord btn btn-danger btn-sm" rel="'.$row->id.'" rel1="delete-feestemp" href="javascript:" > <i class="fas fa-trash"> </i> Delete</a>';
                            return $btn;                      
                    })
            
                   ->rawColumns(['amount','action'])
              //  ->rawColumns(['action'])
                // ->removeColumn('id')
                // ->rawColumns(['action','name'])
                //  ->rawColumns(['action','name'])
                ->make(true);
        }

       
         return view('admin.tutes.issuetute');
    }



     public function class(Request $request){
      //  $stud=Input::get('stud');
          $stud = $request->stud;

        $classes = DB::table('tutions')
        ->select('tutions.*','teachers.first_name')
         ->join('studentin_classes', 'studentin_classes.class', '=', 'tutions.id')
        ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
        ->where('studentin_classes.student_id', $stud)
        ->get();
         return response()->json($classes);
    }

    public function classfilerfees(Request $request){
      //  $stud=Input::get('stud');
          $stud = $request->stud;
         // $main=MainCategory::get();
        // $classes=tution::where('main_cat_id','=',$stud_id)->get();
        $classes = DB::table('tutions')
    ->select('tutions.*','teachers.first_name')
    // ->join('student_fees_manages', 'student_fees_manages.class', '!=', 'tutions.id')
    ->join('studentin_classes', 'studentin_classes.class', '=', 'tutions.id')
    ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
    ->where('studentin_classes.student_id', $stud)
    // ->where('student_fees_manages.amount','!=',0)
    // ->where('student_fees_manages.is_deleted',0)
    // ->where('student_fees_manages.amount','=',0)
    ->get();
         return response()->json($classes);
    }


    public function attribute(Request $request){
        // $type=Input::get('id');
          $class_id=$request->id;

          $attributes = DB::table('tutions')
            ->select('tutions.*')
            // ->join('studentin_classes', 'studentin_classes.class', '=', 'tutions.id')
            ->where('tutions.id', $class_id)
            ->get();

         return response()->json($attributes);
         // echo "<pre>"; print_r($attributes); die;
    }


    public function getAjax(Request $request){
        $data = $request->all();

        // DB::beginTransaction();
        // try {
            $count_type=student_fees_manage::where('student_id',$data['student'])->where('class',$data['clas'])->where('month_for',$data['month'])->first();

            if($count_type){

            $count=feestemp::where('student_id',$data['student'])->where('class',$data['clas'])->where('month_for',$data['month'])->count();

            if( $count == 0){

             $temp = new feestemp;
             $temp->student_id = $data['student'];
             $temp->amount =$count_type->amount;
             $temp->class =  $data['clas'];
             $temp->month_for =  $data['month'];
             $temp->added = Session::get('adminDetails')['branch'];

             if($temp->save()){
                // echo "true"; die;
                 echo json_encode('true');
                //  $this->Details();
                 
             }else{
              //  echo "false"; die;
                 echo json_encode('false');        
             }
            } else{
                echo json_encode('error');  
             }
            }else{

                $count=feestemp::where('student_id',$data['student'])->where('class',$data['clas'])->where('month_for',$data['month'])->count();

            if( $count == 0){
                 $temp = new feestemp;
             $temp->student_id = $data['student'];
             $temp->amount =$data['fees'];
             $temp->class =  $data['clas'];
             $temp->month_for =  $data['month'];
             $temp->added = Session::get('adminDetails')['branch'];

             if($temp->save()){
                // echo "true"; die;
                 echo json_encode('true');
                //  $this->Details();
                 
             }else{
              //  echo "false"; die;
                 echo json_encode('false');        
             }

            }else{
                echo json_encode('error');       
            }


            }
        //     DB::commit();
        // } catch (Exception $e) {
        //    DB::rollback(); 
        // }
           
            
             
    }

     public function Details()
{
    

         $billtemptble = DB::table('feestemps')
    ->select('feestemps.*','tutions.grade','tutions.subject')
    ->join('tutions', 'tutions.id', '=', 'feestemps.class')
   // ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
   ->where('feestemps.added',Session::get('adminDetails')['branch'])
    ->get();
     //   $billtemptble = json_decode(json_encode($billtemptble));
         $levels = tution::where('is_deleted',0)->get();
        $students=student::where('is_deleted',0)->get();
    return view('admin.payments.add')->with(compact('levels','students','billtemptble'));
    //return $billtemptble;
}

    
    public function addpaymentmon(Request $request){
            if($request->isMethod('post')){
            $data = $request->all();
           
             $ReceiptNo = time();
            $person = feestemp::all();

          //   echo "<pre>"; print_r($person); die;
             $pay = new payment;
             $pay->receipt_no = $ReceiptNo;
             $pay->student_id = $data['student'];
             $pay->payment_date = date('Y-m-d');
             $pay->payment_details =$person;
             $pay->total = $data['tot'];
             $pay->added = Session::get('adminDetails')['branch'];
             $pay->payment_res='Monthly';
             $pay->save();
             $lastinsertid=$pay->id;

            // $trans_id = DB::getPdo()->lastInsertId();

           // $trans = DB::table('billtemp')->get();

             foreach($person as $pro){
                $today=date('Y-m-d');
                 $Pro = new students_fees;
                 $Pro->payment_id=$lastinsertid;
                 $Pro->student_id = $pro->student_id;
                 $Pro->tution_id = $pro->class;
                 $Pro->month_for_pay = $pro->month_for;
                 $Pro->payment_date = date('Y-m-d');
                $Pro->fees = $pro->amount;
                 $Pro->added = Session::get('adminDetails')['branch'];
                 $Pro->save();


            //       studentsfees::where(['student_code'=>$data['student'],'month_for_pay'=>$pro->month_for])
            // ->update(['payment_date'=>$today,
            //     'fees'=>$pro->amount,
            //     'tution_code'=>'Paid',
            //     'added_by'=>Session::get('adminDetails')['branch']]);
             }

        //         $getProductStock = ProductAttribute::where('sku',$pro->sku)->first();
               
         DB::table('feestemps')->where('added',Session::get('adminDetails')['branch'])->delete();
          
        // }
          return redirect('/admin/view-payment')->with('smessage','Bill Generated Successfully!'); 

          //  DB::table('cart')->where('user_email',$user_email)->delete();
            $this->printmonpay_receipt($lastinsertid);
             
      }
  }


    public function viewPayments(){
      //  $pays = payments::get();     
        // $data = session()->all();
        // print_r($data); die;
        $pays = DB::table('payments')
                ->select('payments.*','students.first_name','students_fees.tution_id')
                ->join('students', 'students.admission_num', '=', 'payments.student_id')
                ->join('students_fees', 'students_fees.student_id', '=', 'students.admission_num')
                ->where('payments.payment_res','Monthly')
                // ->where('studentsfees.tution_code','Paid')
                ->get();

        $pays = json_decode(json_encode($pays));

       // echo "<pre>"; print_r($brnd); die;
        return view('admin.payments.view')->with(compact('pays'));
    }


    public function printmonpay_receipt($id=null)
    {
        // $filename = 'demo.pdf';

        //  $class = json_decode(json_encode($payments));     
        // $payd=json_decode($class->payment_details);
        //  foreach ($payd as $key => $value) {
        //     // $subject=paymentcategory::where(['id'=>$value->class])->first();
        //      $subject=tution::where(['id'=>$value->class])->first();
        //     $payd[$key]->class=$subject->subject;
        //     }


        $payments=payment::select('receipt_no','student_id','payment_date','total','id')->with(['student_name'=> function($query){
        $query->select('admission_num','first_name','last_name');
       },'payment_class' => function($querys){
        $querys->select('payment_id','tution_id','fees','month_for_pay');
       },'payment_class.class_name'=> function($qry){
        $qry->select('subject','id');
       }])->where('id',$id)
        ->where('payment_res','Monthly')
       ->first();
          // echo $payments->count();
        // die;
    
        $data = [
             'payments' => $payments,

        ];
  
        $html = \View::make('admin.payments.printmonpay', $data);
        $pdf = new  TCPDF;
          
        // $pdf::SetTitle('SMARTWAY ACADEMY');
        $pdf::SetMargins(0, 10, 10, true);
        // $pdf::AddPage();
        // $pdf::writeHTML($html, true, false, true, false, '');
        // $pdf::Output(public_path($filename), 'I');
        // return response()->download(public_path($filename));
        // $pdf = new TCPDF;
        $pdf::AddPage('P', 'A6');
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('helo_world.pdf', 'I'); 
    }


    public function printregpay_receipt($id=null)
    {

        $payments=payment::select('receipt_no','student_id','payment_date','total','id')->with(['student_name'=> function($query){
        $query->select('admission_num','first_name','last_name');
       },'payment_category' => function($querys){
        $querys->select('payment_id','payment_cat','amount');
       },'payment_category.category_name'=> function($qry){
        $qry->select('title','id');
       }])->where('id',$id)
        ->where('payment_res','Register')
       ->first();


      // return $payments;
       // $class = json_decode(json_encode($payments));     
       //  $payd=json_decode($class['payment_details']);
       //   foreach ($payd as $key => $value) {
       //      $subject=paymentcategory::where(['id'=>$value->class])->first();
       //       // $subject=tution::where(['id'=>$value->class])->first();
       //      $payd[$key]->class=$subject->subject;
       //      }


       $data = [
             'payments' => $payments,
            
        ];
  
        $html = \View::make('admin.payments.printregpay', $data);


  
        $pdf = new  TCPDF;
          
        // $pdf::SetTitle('SMARTWAY ACADEMY');
        $pdf::SetMargins(0, 10, 10, true);
        // $pdf::AddPage();
        // $pdf::writeHTML($html, true, false, true, false, '');
        // $pdf::Output(public_path($filename), 'I');
        // return response()->download(public_path($filename));
        // $pdf = new TCPDF;
        $pdf::AddPage('P', 'A6');
        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::Output('helo_world.pdf', 'I');
    }

}

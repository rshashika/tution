<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\payment;
use App\tution;
use App\student;
use App\feestemp;
use Session;
use App\students_fees;
use App\studentin_class;
use App\payment_category;
use App\student_fees_manage;
use Illuminate\Support\Facades\Input;
use DB;

class StudentFeesManageController extends Controller
{
     public function add(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $count=student_fees_manage::where('student_id',$data['student'])->where('class',$data['class'])->where('month_for',$data['month'])->count();
            if($count == 0){
  
            $class=tution::where('id',$data['class'])->first();
            if ($data['fees_type'] == "HALF_CARD") {
                $amount= $class->fees/2;
            }else if($data['fees_type'] == "FREE_CARD"){
                $amount=0;
            }
      
            $category = new student_fees_manage;
            $category->student_id = $data['student'];
            $category->class = $data['class'];
            $category->month_for = $data['month'];
            $category->amount = $amount;
            $category->fees_type=$data['fees_type'];
              $category->added=Session::get('adminDetails')['branch'];
             $category->save();

             return redirect()->back()->with('smessage', 'Added  successfully');

         }else{
            return redirect()->back()->with('emessage', 'Already  added');
         }
            
        }

        $levels = tution::get();
        $students=student::get();
        // $billtemptble = 0;
        
             // $billtemptble = student_fees_manage::get();
             $billtemptble = DB::table('student_fees_manages')
             ->select('student_fees_manages.*','tutions.subject')
        ->join('tutions', 'tutions.id', '=', 'student_fees_manages.class')
           // ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
           // ->where('studentin_classes.student', $stud)
           ->get();
      //  $billtemptble = json_decode(json_encode($billtemptble));
         
     //   $billtemptble = json_decode(json_encode($billtemptble));
        return view('admin.students.fees_manage')->with(compact('levels','students','billtemptble'));
    }

     public function edit(Request $request,$id=null){
        if($request->isMethod('post')){
            $data = $request->all();
             // $generatorPNG = new \Picqer\Barcode\BarcodeGeneratorPNG();
          
           // echo "<pre>"; print_r($data); 

           $class=tution::where('id',$data['class'])->first();
            if ($data['fees_type'] == "HALF_CARD") {
                $amount= $class->fees/2;
            }else if($data['fees_type'] == "FREE_CARD"){
                $amount=0;
            }

            student_fees_manage::where(['id'=>$id])
            ->update(['student_id'=>$data['student'],
                'class'=>$data['class'],
                'month_for'=>$data['month'],
                'fees_type'=>$data['fees_type'],
                'amount'=> $amount,
                'added'=>Session::get('adminDetails')['branch']]);

             return redirect('admin/manage-students-feestype')->with('smessage', 'Updated successfully');
        }

       // $classes = tution::where(['id'=>$id])->first();
        $classes = tution::where(['is_deleted'=>0])->get();

        $students=student::get();
        $levels = student_fees_manage::where(['id'=>$id])->first();
        return view('admin.students.fees_manage_edit')->with(compact('levels','classes','students'));
    }

    public function delete($id = null){
      //  attendence::where(['id'=>$id])->delete();

        student_fees_manage::where('id', $id)
          ->update(['is_deleted' => 1]);
        return redirect('admin/manage-students-feestype')->with('dmessage', 'Deleted successfully');
    }
}

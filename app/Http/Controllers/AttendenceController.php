<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\attendence;
use App\teacherattend;
use App\tution;
use App\User;
use App\teacher;
use App\payments;
use App\student;
use App\feestemp;
use App\tutionday;
use App\students_fees;
use App\studentin_class;
use App\student_tute;
use App\tute;
use App\student_fees_manage;
use Illuminate\Support\Facades\Input;
use DB;
use Session;

class AttendenceController extends Controller
{
     public function view(){ 
         $start=date('Y-m-d');
       // $classes = tution::get();
        $classes = DB::table('tutions')
           ->select('tutions.*','teachers.first_name','teachers.last_name','tutiondays.status','tutiondays.id As newid')
            ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
            ->join('tutiondays', 'tutiondays.tution_id', '=', 'tutions.id')
            ->where('tutiondays.tution_date',$start)
            ->get();

           // print_r($classes);
        return view('admin.attendence.view')->with(compact('classes'));
    }

      public function changestatus(Request $request){

        $data = $request->all();
    

        // DB::beginTransaction();

            $id=$data['id'];
            $status=$data['status'];

        // try {

             $tmp= tutionday::where(['id'=>$id])->update(['status'=>$status]);

             if($tmp){
                 echo "true"; die;
                 echo json_encode('1');
                 
             }else{
              //  echo "false"; die;
                 echo json_encode('0');        
             }
        //     DB::commit();
        // } catch (Exception $e) {
        //     DB::rollback();
        // }

            //return $billtemptble; die;
                        
    }

     public function mark(Request $request,$id=null){ 
        

            $currentTime = Carbon::now();
             $day=date('Y/m/d');
              $month=date('Y-m', strtotime(date('Y-m')));
       // $classdetails = tution::
        $classdetails =DB::table('tutions')
         ->select('tutions.*','teachers.first_name','teachers.last_name')
        ->where('tutions.id',$id)
        ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
        ->first();
        $students=student::where('is_deleted',0)->get();
        $tutes=tute::where('is_deleted',0)->where('tution_id',$id)->where('issue_date',$day)->first();
        return view('admin.attendence.edit')->with(compact('classdetails','students','currentTime','tutes'));
    } 


      public function getAjax(Request $request){
            $data = $request->all();
            $day=date('Y/m/d');
            $current_time = \Carbon\Carbon::now()->toDateTimeString();
            $admin=Session::get('adminSession');
            $isstudent = student::where(['admission_num'=>$data['student']])->count();
            $month=date('Y-m', strtotime(date('Y-m')));

        // DB::beginTransaction();
        //     try {
            


                if($isstudent==1)
            {   
                    
                $studentincls = studentin_class::where(['student_id'=>$data['student'],'class'=>$data['clas']])->count();
                 $freecard=student_fees_manage::where(['student_id' =>$data['student'],'class'=>$data['clas'],'month_for'=>$month,'fees_type'=>'FREE_CARD'])->count();
                 if($freecard !=0){
                    $isfree_card=1;
                 }else{
                    $isfree_card=0;
                 }

                if($studentincls==1){

                $check = attendence::where(['student_id'=>$data['student'],'subject'=>$data['subject'],'class'=>$data['clas'],'date'=>$day])->count();
                if ($check==0) {
                  $attend = new attendence;
                    $attend->student_id = $data['student'];
                    $attend->subject = $data['subject'];
                    $attend->teacher = $data['teacher'];
                    $attend->class = $data['clas'];
                    $attend->date = $day;
                    $attend->result = 1;
                    $attend->added=Session::get('adminDetails')['branch'];
                    $attend->save();

                    
                    $student=student::where('admission_num',$data['student'])->first();
                    if($student->is_active_sms == 1){

                        $user = "94760353119";
                        $password = "7969";
                        $text = urlencode($student->first_name. "  Attendence Marked at ".$current_time);
                        $to = "94760353119";
                        $baseurl ="http://www.textit.biz/sendmsg";
                        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
                        $ret = file($url);
                        $res= explode(":",$ret[0]);
                        if (trim($res[0])=="OK")
                        {
                        // echo "Message Sent - ID : ".$res[1];
                        }
                        else
                        {
                        // echo "Sent Failed - Error : ".$res[1];
                        }
                    }
                    
                   


                    $month=date('Y-m', strtotime(date('Y-m')));
                 $classdetails = student::where(['admission_num'=>$data['student']])->first();
                  $adminCount = students_fees::where(['student_id' =>$data['student'],'tution_id'=>$data['clas'],'month_for_pay'=>$month])->count(); 
                    if($data['tuteid']){

                   $tuteDetails=tute::where('id',$data['tuteid'])->first(); 
                 if($tuteDetails){

                    $count =student_tute::where('tute_id',$data['tuteid'])->where('is_issued',1)->where('student_id',$data['student'])->count();
                    if ($count == 0) {
                      
                    $attend = new student_tute;
                    $attend->student_id = $data['student'];
                    $attend->tute_id = $data['tuteid'];
                    $attend->tution_id = $data['clas'];
                    // $attend->date = $day;
                    $attend->rate = $tuteDetails->price;
                    $attend->month_for =  $tuteDetails->month_for;
                    $attend->is_issued=1;
                    $attend->added=Session::get('adminDetails')['branch'];
                    $attend->save();

                    $classdetails = json_decode($classdetails);
                     $classdetails->issue_tute =1;
                    $classdetails = json_encode($classdetails);

                    }
                    
                   }
               }
                 //  echo json_encode($adminCount);
                 if ($adminCount == 1) {
                  $classdetails = json_decode($classdetails);
                $classdetails->paid =1;
                $classdetails->freecard =$isfree_card;
                $classdetails = json_encode($classdetails);
                 } else {
                $classdetails = json_decode($classdetails);
                $classdetails->paid =0;

                 $classdetails->freecard =$isfree_card;
                    $classdetails = json_encode($classdetails);
                 }
                 $classdetails = json_decode($classdetails);
                    $classdetails->check =0;
                    $classdetails = json_encode($classdetails);

                 }else{
                    $month=date('Y-m', strtotime(date('Y-m')));
                    $classdetails = student::where(['admission_num'=>$data['student']])->first();
               $adminCount = students_fees::where(['student_id' =>$data['student'],'tution_id'=>$data['clas'],'month_for_pay'=>$month])->count(); 

              // echo json_encode($adminCount);
                 if ($adminCount == 1) {
                      $classdetails = json_decode($classdetails);
                    $classdetails->paid =1;
                     $classdetails->freecard =$isfree_card;
                    $classdetails = json_encode($classdetails);
                 } else {
                    $classdetails = json_decode($classdetails);
                    $classdetails->paid =0;
                     $classdetails->freecard =$isfree_card;
                    $classdetails = json_encode($classdetails);
                 }
                  $classdetails = json_decode($classdetails);
                    $classdetails->check =1;
                    $classdetails = json_encode($classdetails);

                 }
                  $classdetails = json_decode($classdetails);
                    $classdetails = json_encode($classdetails);
                      return $classdetails; die;
                  }
                  else{
                     echo json_encode("studentnotincls");
                  }    
            }else{

                echo json_encode("notisstudent");
            }
                

            // DB::commit();
            // } catch (Exception $e) {
            //     DB::rollback();
            // }


            
            
         
    }
}

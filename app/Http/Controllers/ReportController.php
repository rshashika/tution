<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\teacher;
use App\student;
use App\tution;
use App\studentin_class;
use App\students_fees;
use App\teacher_attend;
use App\attendence;
use DB;
use Elibyy\TCPDF\Facades\TCPDF;

class ReportController extends Controller
{
     public function view($value='')
    {
        return view('admin.reports.view_reports');
    }


    function viewStudentReport(){

            $student_data=student::where(['is_deleted'=>0])->get();  
               $stud= json_decode($student_data);
               // print_r($stud);                  
          //  $student_data=DB::table('studentin_classes')->join('students','students.admission_num','=','studentin_classes.student')->get();  
        return view('admin.reports.view_students_report')->with(compact('student_data'));
    }

    function viewTeacherReport(){

            $teacherdata=teacher::where(['is_deleted'=>0])->get();  
               $stud= json_decode($teacherdata);
               // print_r($stud);                  
          //  $student_data=DB::table('studentin_classes')->join('students','students.admission_num','=','studentin_classes.student')->get();  
        return view('admin.reports.view_teachers_report')->with(compact('teacherdata'));
    }

    function viewAttendReport(Request $request){
            if($request->isMethod('post')){
             $data = $request->all();

          $start=$data['date'];
           $student=$data['student'];

          
              $classid=$data['class_id'];      
            
          

        if ($student) { 

             if ($classid) { 

             $levels = DB::table('attendences')
            ->select('attendences.*','students.first_name','students.last_name')
            ->join('students', 'students.admission_num', '=', 'attendences.student_id')
            ->where('attendences.class',$classid)
            ->where('attendences.student_id',$student)
             ->selectRaw('GROUP_CONCAT(date) as attend_dates')
             ->GROUPBY('attendences.student_id')
            ->GROUPBY('attendences.class')
            ->get();

            }else{
                
              $levels = DB::table('attendences')
            ->select('attendences.*','students.first_name','students.last_name')
            ->join('students', 'students.admission_num', '=', 'attendences.student_id')
            ->where('attendences.student_id',$student)
            ->selectRaw('GROUP_CONCAT(date) as attend_dates')
             ->GROUPBY('attendences.student_id')
            ->GROUPBY('attendences.class')
            ->get();  
            }


            }else{

            if ($classid) { 

             $levels = DB::table('attendences')
            ->select('attendences.*','students.first_name','students.last_name')
            ->join('students', 'students.admission_num', '=', 'attendences.student_id')
            ->where('attendences.class',$classid)
             ->selectRaw('GROUP_CONCAT(date) as attend_dates')
             ->GROUPBY('attendences.student_id')
            ->GROUPBY('attendences.class')            ->get();

            $tutiodys= DB::table('tutiondays')
             ->select('tutiondays.*')
             ->where('tution_code',$classid)
               ->GROUPBY('tution_date')
             ->get();

            }else{

              $levels = DB::table('attendences')
            ->select('attendences.*','students.first_name','students.last_name','tutions.subject')
            ->join('students', 'students.admission_num', '=', 'attendences.student_id')
            ->join('tutions', 'tutions.id', '=', 'attendences.class')
            ->selectRaw('GROUP_CONCAT(date) as attend_dates')
            ->GROUPBY('attendences.student_id')
            ->GROUPBY('attendences.class')
            ->get();

            }

           }


        
            $from=date('Y-m', strtotime($start));
            $month= date("m",strtotime($from));
             $year= date("Y",strtotime($from));

            if ($start) {
               $tutiodys= DB::table('tutiondays')
             ->select('tutiondays.*')
             ->whereYear('tution_date',$year)
             ->whereMonth('tution_date', $month)
               ->GROUPBY('tution_date')
             ->get();
            }else{

                $tutiodys= DB::table('tutiondays')
             ->select('tutiondays.*')
               ->GROUPBY('tution_date')
             ->get();
            }

        $students = student::where(['is_deleted'=>0])->get();
        $classes = DB::table('tutions')
           ->select('tutions.*','teachers.first_name','teachers.last_name')
                ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
                ->get();




        return view('admin.reports.view_attend_report')->with(compact('levels','tutiodys','classes','students','student','classid','start'));
          }  
             $start=date('Y-m', strtotime(date('Y-m')));
              $month= date("m",strtotime($start));
             $year= date("Y",strtotime($start));
            $tutiodys= DB::table('tutiondays')
            ->select('tutiondays.*')
            ->whereYear('tution_date',$year)
            ->whereMonth('tution_date', $month)
            ->GROUPBY('tution_date')   
            ->get(); 


         $levels = DB::table('attendences')
            ->select('attendences.*','students.first_name','students.last_name','tutions.subject')
            ->join('students', 'students.admission_num', '=', 'attendences.student_id')
            ->join('tutions', 'tutions.id', '=', 'attendences.class')
           ->selectRaw('GROUP_CONCAT(date) as attend_dates')
           ->GROUPBY('attendences.student_id')
           ->GROUPBY('attendences.class')
            ->get();

       // $levels=$levelso->groupby('attendences.student_id');
             $students = student::where(['is_deleted'=>0])->get();


         $classes = DB::table('tutions')
           ->select('tutions.*','teachers.first_name','teachers.last_name')
                ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
                ->get();
          //  print_r($levels);   
        // $today=date('Y-m-d', strtotime(date('Y-m')." -1 month"));
        // $year=date("Y",strtotime($today));
        // $month= date("m",strtotime($today));
               
  
        return view('admin.reports.view_attend_report')->with(compact('levels','tutiodys','classes','students','start'));
    }

    function viewTeachAttendReport(Request $request){
            if($request->isMethod('post')){
             $data = $request->all();
       // print_r($data); 


        // $start=date('Y-m-d');
          $start=$data['date'];
           $teacher=$data['teacher'];
        //   $student=1220;
       //   $classid=$data['class_id'];
       //  $test = date('N', $start);
       
       // $classes = tution::get();
        if ($teacher) { 


                
              $levels = DB::table('teacher_attends')
            ->select('teacher_attends.*','teachers.first_name','teachers.last_name')
            ->join('teachers', 'teachers.id', '=', 'teacher_attends.teacher_id')
            ->where('teacher_attends.teacher_id',$teacher)
            ->selectRaw('GROUP_CONCAT(date) as attend_dates')
             ->GROUPBY('teacher_attends.teacher_id')
           // ->GROUPBY('attendences.class')
            ->get();  

  

           }

          
      //    $from = date('2022-09');
            $from=date('Y-m', strtotime($start));
            $month= date("m",strtotime($from));
             $year= date("Y",strtotime($from));
        ///echo $year;
            if ($start) {
               $tutiodys= DB::table('tutiondays')
             ->select('tutiondays.*')
            // ->join('students', 'students.admission_num', '=', 'attendences.student_id')
           //  ->where('tution_date',$start)
             ->whereYear('tution_date',$year)
             ->whereMonth('tution_date', $month)
               ->GROUPBY('tution_date')
             ->get();
            }else{

                $tutiodys= DB::table('tutiondays')
             ->select('tutiondays.*')
            // ->join('students', 'students.admission_num', '=', 'attendences.student_id')
            // ->where('tution_code',$classid)
               ->GROUPBY('tution_date')
             ->get();
            }
       //  print_r($tutiodys);
        $teachers = teacher::where(['is_deleted'=>0])->get();
        $classes = DB::table('tutions')
           ->select('tutions.*','teachers.first_name','teachers.last_name')
                ->join('teachers', 'teachers.id', '=', 'tutions.teacher')
                ->get();

              //  die;
        return view('admin.reports.view_teachattend_report')->with(compact('levels','tutiodys','classes','teachers','teacher','start'));
          }  

          
          $tutiodys= DB::table('tutiondays')
             ->select('tutiondays.*')
            // ->join('students', 'students.admission_num', '=', 'attendences.student_id')
            // ->where('tution_code',$classid)
              ->GROUPBY('tution_date')
             
             ->get();  

         $levels = DB::table('teacher_attends')
            ->select('teacher_attends.*','teachers.first_name','teachers.last_name')
            ->join('teachers', 'teachers.id', '=', 'teacher_attends.teacher_id')
           // ->join('tutions', 'tutions.id', '=', 'attendences.class')
           ->selectRaw('GROUP_CONCAT(date) as attend_dates')
            ->GROUPBY('teacher_attends.teacher_id')
           // ->GROUPBY('attendences.class')
            ->get();
             $teachers = teacher::where(['is_deleted'=>0])->get();


       // $levels = attendence::get(); 
        return view('admin.reports.view_teachattend_report')->with(compact('levels','tutiodys','teachers'));
    }


    public function viewStudentClassReport()
    {
        

              $levels = DB::table('studentin_classes')
            ->select('studentin_classes.class',DB::raw('count(*) as student_count'),'tutions.subject','tutions.*')
            ->join('tutions', 'tutions.id', '=', 'studentin_classes.class')
             // ->join('tutions', 'tutions.id', '=', 'attendences.class')
           
             // ->selectRaw('GROUP_CONCAT(date) as attend_dates')
           ->GROUPBY('studentin_classes.class')
            ->get();

            // echo $levels;
            

       return view('admin.reports.view_studentwiseclass_report')->with(compact('levels'));
    }

        public function viewMonthlyattendReport(Request $request){

             if($request->isMethod('post')){
             $data = $request->all();
               // print_r($data); 

            $start=$data['date'];
            $month= date("m",strtotime($start));
             $year= date("Y",strtotime($start));
            $classid=$data['class_id'];  

                if($classid){
                    $tutiodys= DB::table('tutiondays')
             ->select('tutiondays.tution_date')
              ->whereYear('tution_date',$year)
             ->whereMonth('tution_date', $month)
             ->where('tution_id',$classid)
              ->GROUPBY('tution_date')
            //  ->get();
             ->pluck('tution_date')->toArray(); 
            
            //  echo $tutiodys;
            $levels=tution::select('subject','id')->where('id',$classid)
            ->with(['attendences'=>function($query) use($tutiodys,$year,$month,$classid){
                // foreach($tutiodys as $day){
                     $query->select('class','date',DB::raw('COUNT(class) as attend_count'))
                       ->whereYear('date',$year)
                      ->whereMonth('date', $month)      
                     ->whereIn('date',$tutiodys)
                     ->groupBy('date','class');
                // }
               
            }])->get();
            $attends =[];
          
                foreach($levels as $class){
                    $child['class_name']=$class->subject;
                    $child_attendence=[];
                    $class_dates=[];
                    foreach($class->attendences as $attendence){
                        array_push($class_dates, $attendence->date); 
                    }
                    foreach($tutiodys as $day){
                        if(in_array($day, $class_dates)){
                          //  echo "found";
                          foreach ($class->attendences as $att){
                            if($att->date == $day){
                                $count =$att->attend_count;
                            }
                          }

                            array_push($child_attendence, ['date' => $day, 'count' =>$count]);
                        }else{
                            //echo "not found";
                            array_push($child_attendence, ['date' => $day,'count' => 0]); 
                        }  
                    }
                    $child['attendence']=$child_attendence;
                    array_push($attends, $child);
                }
                }else{

                }
             
              
              //  print_r($attends);
             //  die;

                $classes=tution::where('is_deleted',0)->get();

        return view('admin.reports.view_monthlyattend_report')->with(compact('start','tutiodys','attends','classes','classid'));
       
              } 

             $start=date('Y-m', strtotime(date('Y-m')));
              $month= date("m",strtotime($start));
             $year= date("Y",strtotime($start));


           $tutiodys= DB::table('tutiondays')
             ->select('tutiondays.tution_date')
              ->whereYear('tution_date',$year)
             ->whereMonth('tution_date', $month)
              ->GROUPBY('tution_date')
            //  ->get();
             ->pluck('tution_date')->toArray(); 
            
            //  echo $tutiodys;
            $levels=tution::select('subject','id')->with(['attendences'=>function($query) use($tutiodys,$year,$month){
                // foreach($tutiodys as $day){
                     $query->select('class','date',DB::raw('COUNT(class) as attend_count'))
                       ->whereYear('date',$year)
                      ->whereMonth('date', $month)
                     ->whereIn('date',$tutiodys)
                     ->groupBy('date','class');
                // }
               
            }])->get();
            $attends =[];
          
                foreach($levels as $class){
                    $child['class_name']=$class->subject;
                    $child_attendence=[];
                    $class_dates=[];
                    foreach($class->attendences as $attendence){
                        array_push($class_dates, $attendence->date); 
                    }
                    foreach($tutiodys as $day){
                        if(in_array($day, $class_dates)){
                          //  echo "found";
                          foreach ($class->attendences as $att){
                            if($att->date == $day){
                                $count =$att->attend_count;
                            }
                          }

                            array_push($child_attendence, ['date' => $day, 'count' =>$count]);
                        }else{
                            //echo "not found";
                            array_push($child_attendence, ['date' => $day,'count' => 0]); 
                        }  
                    }
                    $child['attendence']=$child_attendence;
                    array_push($attends, $child);
                }
              
              //  print_r($attends);
             //  die;

                $classes=tution::where('is_deleted',0)->get();

        return view('admin.reports.view_monthlyattend_report')->with(compact('start','tutiodys','attends','classes'));
        }


        public function viewStudentPaymentReport(Request $request){
            if($request->isMethod('post')){
             $data = $request->all();
               // print_r($data); 

            $start=$data['date'];
            $month= date("m",strtotime($start));
             $year= date("Y",strtotime($start));
            $classid=$data['class_id'];  

            $levels = DB::table('students_fees')
            ->select(DB::raw("SUM(students_fees.fees) as total"),'students_fees.*','tutions.subject')
            ->join('tutions', 'tutions.id', '=', 'students_fees.tution_id')
             // ->join('tutions', 'tutions.id', '=', 'attendences.class')
           
             // ->selectRaw('GROUP_CONCAT(date) as attend_dates')
            ->whereYear('payment_date',$year)
            ->whereMonth('payment_date', $month)
           ->GROUPBY('tutions.id')
            ->get();

            $classes=tution::where('is_deleted',0)->get();
              return view('admin.reports.view_studentpayment_report')->with(compact('start','levels','classes'));
        }

        $start=date('Y-m', strtotime(date('Y-m')));
        $month= date("m",strtotime($start));
        $year= date("Y",strtotime($start));



              $levels = DB::table('students_fees')
            ->select(DB::raw("SUM(students_fees.fees) as total"),'students_fees.*','tutions.subject')
            ->join('tutions', 'tutions.id', '=', 'students_fees.tution_id')
             // ->join('tutions', 'tutions.id', '=', 'attendences.class')
           
             // ->selectRaw('GROUP_CONCAT(date) as attend_dates')
             ->whereYear('payment_date',$year)
            ->whereMonth('payment_date', $month)
           ->GROUPBY('tutions.id')
            ->get();

             $classes=tution::where('is_deleted',0)->get();

        return view('admin.reports.view_studentpayment_report')->with(compact('start','levels','classes'));
        }

        public function viewStudentPendingPaymentReport(Request $request)
        {

        if($request->isMethod('post')){
             $data = $request->all();
               // print_r($data); 

            $start=$data['date'];
            $month= date("m",strtotime($start));
             $year= date("Y",strtotime($start));
            $classid=$data['class_id'];  


            $levels=studentin_class::select('student_id','class')->with(['classname' => function($query) {
            $query->select('id','subject');
         }])->doesntHave('studentsfeeses','or',function($q) use ($start){
                     $q->select('student_id','tution_id','month_for_pay')->where('month_for_pay', $start);
            })->doesntHave('studentsclasses', 'or') ->orderBy('student_id','ASC')
         ->orderBy('class','ASC')->get();

          $classes=tution::where('is_deleted',0)->get();
         return view('admin.reports.view_student_pending_payment_report')->with(compact('start','levels','classes'));
        }

        $start=date('Y-m', strtotime(date('Y-m')));
         // $start=date('Y-m', strtotime(date('Y-m')." -1 month"));
        $month= date("m",strtotime($start));
        $year= date("Y",strtotime($start));



        $levels=studentin_class::select('student_id','class')->with(['classname' => function($query) {
            $query->select('id','subject');
         }])->doesntHave('studentsfeeses','or',function($q) use ($start){
                     $q->select('student_id','tution_id','month_for_pay')->where('month_for_pay', $start);
            })->doesntHave('studentsclasses', 'or')->orderBy('student_id','DESC')->get();

          $classes=tution::where('is_deleted',0)->get();


        return view('admin.reports.view_student_pending_payment_report')->with(compact('start','levels','classes'));
        }

        public function viewStudentNewJoiningReport(Request $request)
        {

            if($request->isMethod('post')){
             $data = $request->all();
               // print_r($data); 

            $start=$data['date'];
            $month= date("m",strtotime($start));
             $year= date("Y",strtotime($start));
            $classid=$data['class_id'];  

              $newstudents=studentin_class::select('student_id','class','join_date')->with(['studentname'=> function($query) {
             $query->select('id','first_name','last_name','admission_num');
           }])->whereYear('join_date',$year)
            ->whereMonth('join_date', $month)
            ->orderBy('join_date','ASC')
           ->get();

            $classes=tution::where('is_deleted',0)->get();
        return view('admin.reports.view_newjoining_report')->with(compact('newstudents','start','classes'));
        }

        $start=date('Y-m', strtotime(date('Y-m')));
         // $start=date('Y-m', strtotime(date('Y-m')." -1 month"));
         $month= date("m",strtotime($start));
         $year= date("Y",strtotime($start));

            // code...
            $newstudents=studentin_class::select('student_id','class','join_date')->with(['studentname'=> function($query) {
             $query->select('id','first_name','last_name','admission_num');
           }])->whereYear('join_date',$year)
            ->whereMonth('join_date', $month)
            ->orderBy('join_date','ASC')
           ->get();

            $classes=tution::where('is_deleted',0)->get();
        return view('admin.reports.view_newjoining_report')->with(compact('newstudents','start','classes'));
        }

}

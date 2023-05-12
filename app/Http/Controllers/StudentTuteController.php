<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\admin;
use App\student;
use App\student_tute;
use App\studentin_class;
use App\tution;
use App\tute;
use App\teacher;
use DB;
use Carbon\Carbon;
use DataTables;
class StudentTuteController extends Controller
{
    
    public function view(){
        $tutes = student_tute::get();
        /*$admins = json_decode(json_encode($admins));
        echo "<pre>"; print_r($admins); die;*/
        return view('admin.tutes.view')->with(compact('tutes'));
    }

    public function add(Request $request,$id = null,$tid= null){

        if (request()->ajax()) {
             
          $tutes=student_tute::with(['student_name'=> function($qry){
                $qry->select('admission_num');
         }])->where('tution_id',$id)->where('tute_id',$tid)->get();

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
            
           // print_r(json_encode($tutes));

            return Datatables::of($tutes)
                // foreach($data->tute_class as $tute){
                ->addColumn('student',function ($row){
                    return $row['student_name']->admission_num;
                })
                ->addColumn('rate',function ($row) {
                        if($row->rate ==0){
                           return 'Free';
                        }else{
                            return $row->rate;  
                        }                            
                })
                ->addColumn('month_for',function ($row) {
                        
                      return date('F', strtotime($row->month_for));  
                                                    
                })
            
                   // ->rawColumns(['action'])
                ->removeColumn('id')
                // ->rawColumns(['action','name'])
                //  ->rawColumns(['action','name'])
                ->make(true);
                 // return view('admin.tutes.issuetute');
        }
      
      //  die;
         // $tutes=student_tute::with(['tution_name'=> function($query){
         //        $query->select('id','subject','teacher');
         // },'tution_name.teacher_name' => function($qr){
         //    $qr->select('id','first_name','last_name');
         // }])->where('tution_id',$id)->get();
      //  echo $id.$tid;

         //  $tutes=student_tute::with(['student_name'=> function($qry){
         //        $qry->select('admission_num');
         // }])->where('tution_id',$id)->where('tute_id',$tid)->get();

      

                $students=studentin_class::where('class',$id)->get();

             //  die;
         //     $tuteDetails=teacher::select('id','first_name','last_name')->with(['class_name'=> function($qryy) use($id) {
         //    $qryy->select('id','teacher','subject')->where('id',$id);

         // },'class_name.tute_class' =>function ($qry2) use ($tid){
         //        $qry2->select('id','institute_id','tution_id','month_for','price','is_free')->where('id',$tid);
         // }])->first();

           $tuteDetails=tution::select('id','teacher','subject')->with(['tute_class'=> function ($qry2) use ($tid){
             $qry2->select('id','institute_id','tution_id','month_for','price','is_free','tute_name')->where('id',$tid);
          },'teacher_name' => function($qry){
            $qry->select('id','first_name','last_name');
          }])->where('id',$id)->first();


        // die;
        return view('admin.tutes.issuetute')->with(compact('students','tuteDetails','id','tid'));
    }


    public function mark(Request $request){
        $data = $request->all();

        // DB::beginTransaction();
        // try {

        $tuteDetails=tute::where('id',$data['tute_id'])->first();

            $count=student_tute::where('tution_id',$data['tution_id'])->where('month_for',$data['month'])->where('student_id',$data['student_id'])->where('tute_id',$data['tute_id'])->count();


            if( $count ==0 ){

                // if($data['is_free']=='true'){
                //     $status=1;
                // }else{
                //      $status=0;
                // }

             $temp = new student_tute;
             $temp->tution_id = $data['tution_id'];
             $temp->tute_id =$data['tute_id'];
             $temp->student_id =  $data['student_id'];
             $temp->month_for =  $data['month'];
             $temp->rate=$tuteDetails->price;
             $temp->is_issued=1;
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
             
    }


     public function index(Request $request,$tid,$id)
    {
         // $data = $request->all();
        // $id = $request->get('id');
        if (request()->ajax()) {
       // $tid=1;
       // $id=2;
        //   return $tid;
          //  $id=$request['tution_id'];
          //    $tid=$request['tute_id'];
            // $data = request()->ajax();

             //   $id = $request->input('tute_id');
            //   $id=$data['tution_id'];
            //   $tid=$data['tute_id'];
              //  return $data;

             $tutes=student_tute::with(['student_name'=> function($qry){
                $qry->select('admission_num');
         }])->where('tution_id',$id)->where('tute_id',$tid)->get();

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

            return Datatables::of($tutes)
                // foreach($data->tute_class as $tute){
                ->addColumn('student',function ($row){
                    return $row['student_name']->admission_num;
                })
                // ->addColumn('rate',function ($row) {
                //         if($row->rate ==0){
                //            return 'Free';
                //         }else{
                //             return $row->rate;  
                //         }                            
                // })
                // ->addColumn('month_for',function ($row) {
                        
                //       return date('F', strtotime($row->month_for));  
                                                    
                // })
            
                   // ->rawColumns(['action'])
                // ->removeColumn('id')
                // ->rawColumns(['action','name'])
                //  ->rawColumns(['action','name'])
                ->make(true);
        }

       
         return view('admin.tutes.issuetute');
    }
   
}

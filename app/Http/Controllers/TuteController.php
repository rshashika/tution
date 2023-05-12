<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tute;
use Auth;
use Session;
use App\User;
use App\admin;
use App\student;
use App\student_tute;
use App\tution;
use App\teacher;
use DB;
use Carbon\Carbon;
use DataTables;

class TuteController extends Controller
{
     public function add(Request $request){
        $data = $request->all();

        // DB::beginTransaction();
        // try {
            // $count=tute::where('tution_id',$data['tution_id'])->where('month_for',$data['month'])->count();


            // if( $count ==0 ){

                if($data['is_free']=='true'){
                    $status=1;
                }else{
                     $status=0;
                }

             $temp = new tute;
             $temp->tute_name=$data['tute_name'];
             $temp->tution_id = $data['tution_id'];
             $temp->price =$data['tute_fee'];
             $temp->is_free =  $status;
             $temp->month_for =  $data['month'];
             $temp->issue_date=$data['issue_date'];
             $temp->added = Session::get('adminDetails')['branch'];

             if($temp->save()){
                // echo "true"; die;
                 echo json_encode('true');
                //  $this->Details();
                 
             }else{
              //  echo "false"; die;
                 echo json_encode('false');        
             }
            // } else{
            //     echo json_encode('error');  
            //  }
             
    }

     public function delete($id = null){
      //  attendence::where(['id'=>$id])->delete();
        tute::where('id', $id)
          ->update(['is_deleted' => 1]);
        return redirect('admin/issue-tute')->with('dmessage', 'Deleted successfully');
    }


     public function manage(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>";print_r($data); die;*/
             // DB::beginTransaction();

             // try {
                $adminCount = student_tute::where('username',$data['username'])->count();
            if($adminCount>0){
                return redirect()->back()->with('flash_message_error','Admin / Sub Admin already exists! Please choose another.');
            }else{
                if(empty($data['status'])){
                    $data['status'] = 0;
                }
               // if($data['type']=="Admin"){
                    $admin = new student_tute;
                    // $admin->branch = $data['branch'];
                    $admin->username = $data['username'];
                    $admin->password = md5($data['password']);
                    $admin->password_plain = $data['password'];
                    $admin->type = $data['type'];
                    $admin->status = $data['status'];
                    $admin->save();
                    return redirect('admin/view-admins')->with('smessage', 'Access Added Successfully');    
                
             }
                  // DB::commit();
             // } catch (Exception $e) {
             //       DB::rollback();
             // }

             // $tution = tution::get();
       
        }
       //  $tutions=tution::with(['teacher_name'=>function($query){
       //  $query->select('id','first_name','last_name');
       // }])->where('is_deleted',0)->get();

         $tutions=teacher::with(['class_name' => function($qry){
        $qry->select('id','subject','teacher');
       }])->get();


           $tutes=tution::with(['teacher_name'=>function($query){
        $query->select('id','first_name','last_name');
       }])
         ->with(['tute_class'=>function($query){
        $query->select('id','tution_id','month_for','price','is_free','tute_name');
       }])
         ->get();

         // $tutedets=[];
         //    foreach($tutes as $tut){

         //        $tutedet=[];
         //        foreach($tut->tute_class as $tute){
         //            $tute['first_name']=$tut->teacher_name->first_name;
         //            $tute['last_name']=$tut->teacher_name->last_name;
         //            array_push($tutedets,$tute );
         //        }
         //    }
         //     print_r(json_encode($tutedets));
          //die;
       // die;
       //   $tutes=tute::with(['tution_name'=> function($query){
       //   $query->select('id','teacher','subject');
       // },'tution_name.teacher_name' => function($qry){
       //  $qry->select('id','first_name','last_name');
       // }])->where('is_deleted',0)->get();

       // echo  $tutes=teacher::select('id','first_name','last_name')->with(['class_name'=> function($qryy) {
       //      $qryy->select('id','teacher','subject');

       //   }])->whereHas('class_name.tute_class' ,function ($qry2) {
       //          $qry2->select('id','institute_id','tution_id','month_for','price','is_free');
       //   })->get();
      // die;
        return view('admin.tutes.add')->with(compact('tutions','tutes'));
    }


    public function index(Request $request)
    {

        if (request()->ajax()) {

             $data=tution::with(['teacher_name'=>function($query){
        $query->select('id','first_name','last_name');
       }])
         ->with(['tute_class'=>function($query){
        $query->select('id','tution_id','month_for','price','is_free','tute_name');
       }])
         ->get();
          $tutedets=[];
            foreach($data as $tut){
                $tutedet=[];
                foreach($tut->tute_class as $tute){
                     $tute['first_name']=$tut->teacher_name->first_name;
                    $tute['last_name']=$tut->teacher_name->last_name;
                    $tute['subject']=$tut->subject;
                    array_push($tutedets,$tute );
                }
            }
            
           // print_r(json_encode($tutedets));

            return Datatables::of($tutedets)
                // foreach($data->tute_class as $tute){
                ->addColumn('class',function ($row){
                    return $row->subject."-".$row->first_name." ".$row->last_name;
                })
                ->addColumn('rate',function ($row) {
                        if($row->is_free ==1){
                           return 'Free';
                        }else{
                            return $row->price;  
                        }                            
                })
                ->addColumn('month_for',function ($row) {
                        
                      return date('F', strtotime($row->month_for));  
                                                    
                })
                ->addColumn('action', function($row){
                           $btn = '<a href="'.url('/admin/issue-tute/'.$row->tution_id.'/'.$row->id).'" class="btn btn-sm bg-gradient-cyan mr-2"><i class="ik save ik-star-on"></i> Issue Tute</a>';
                           $btn = $btn.'<a  class="deleteRecord btn btn-danger btn-sm" rel="'.$row->id.'" rel1="delete-tute" href="javascript:" > <i class="fas fa-trash"> </i> Delete</a>';
                            return $btn;                      
                    })
            
                    ->rawColumns(['action'])
                ->removeColumn('id')
                // ->rawColumns(['action','name'])
                //  ->rawColumns(['action','name'])
                ->make(true);
        }

       
         return view('admin.tutes.add')->with(compact('tutes'));
    }
}

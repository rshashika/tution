<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
use App\student;
use App\tution;
use App\studentin_class;
use DB;
use Image;
// use Picqer\Barcode\BarcodeGeneratorPNG;
use DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class StudentController extends Controller
{
      public function add(Request $request){
        if($request->isMethod('post')){
             // $generator = new BarcodeGeneratorPNG();
            $data = $request->all();

           
              $adms=$data['admission'];
            // echo "<pre>"; print_r($data); die;
           $Count = student::where(['admission_num' => $adms ])->count(); 
            $admission_new=$data['admission'];

            if(empty($data['active_sms'])){
                    $data['active_sms'] = 0;
                }
              // $admission_new=str_pad($data['admission'], 12, '0', STR_PAD_LEFT);
          
            if (!$Count){

            $category = new student;
            $category->first_name = $data['fname'];
            $category->last_name = $data['lname'];
            $category->birth = $data['dob'];
            $category->address = $data['address'];
            $category->email = $data['email'];
            $category->contact = $data['contact'];
            $category->parent_name = $data['parent_name'];
            $category->is_active_sms=$data['active_sms'];
             $category->parent_mobile = $data['mobile'];
             $category->admission_num =$admission_new;
              $category->whatsapp = $data['whatsapp'];
               $category->added=Session::get('adminDetails')['branch'];

             // Upload Image
            if($request->hasFile('image')){
                // $image_tmp = Input::file('image');
                 $image_tmp = $request->image;
                if ($image_tmp->isValid()) {
                    // Upload Images after Resize
                    $extension = $image_tmp->getClientOriginalExtension();
                  //  $fileName = rand(111,99999).'.'.$extension;
                    $fileName = $data['admission'].'.'.$extension;


                   // echo $extension ; 
                   // echo $fileName;
                  //  die;
                    $large_image_path = 'images/students/def/'.$fileName;
                    // $medium_image_path ='images/backend_images/products/medium/'.$fileName;  
                    $small_image_path = 'images/students/small/'.$fileName;  
                        //rresize imaes
                   Image::make($image_tmp)->save($large_image_path);
                  //   $image_lg= Image::make($image_tmp);
                    // Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
                    //  $image_sm= Image::make($image_tmp)->resize(300, 300);

                   //  \Storage::put( $large_image_path, $image_lg ,$image_tmp);
                   //   \Storage::put( $small_image_path, $image_sm ,$image_tmp);

                    $category->image = $fileName; 

                }
            }


             // $barcode=$generator->getBarcode($data['admission'], $generator::TYPE_CODE_128,1,13);
             $barcode=QrCode::generate('Welcome to Makitweb');
             $fileNameToStore = $data['admission'].'.png';

            $file = $barcode;
          // \Storage::put('barcodes/'.$data['admission'].'.png', $barcode);
           \Storage::disk('local')->put('public/barcodes/'.$fileNameToStore, $barcode);
           // $file->move(public_path('images/barcodes'), $fileNameToStore);
           $category->barcode =$fileNameToStore;
            // $category->meta_description = $data['meta_description'];
            // $category->meta_keywords = $data['meta_keywords'];
            // $category->status = $status;
            $category->save();
           
           $last_insert_id = $category->admission_num;
        // die;
            return redirect('admin/manage-student_inreg/'.$last_insert_id);
            //admin/add-paymentnew/{id}
           // return redirect()->back()->with('smessage', 'Student has been added successfully');
        }else{
             return redirect('admin/add-student')->with('emessage', 'Already Added');
        }
         }

        $levels = tution::where(['is_deleted'=>0])->get();
        return view('admin.students.add')->with(compact('levels'));
    }

     public function edit(Request $request,$id=null){
         // $generator = new BarcodeGeneratorPNG();
        if($request->isMethod('post')){
            $data = $request->all();
             // $generatorPNG = new \Picqer\Barcode\BarcodeGeneratorPNG();
          
           // echo "<pre>"; print_r($data); 
           // die;

            if(empty($data['active_sms'])){
                    $data['active_sms'] = 0;
                }

             if($request->hasFile('image')){
                // $image_tmp = Input::file('image');
                 $image_tmp = $request->image;
                if ($image_tmp->isValid()) {
                    // Upload Images after Resize
                    $extension = $image_tmp->getClientOriginalExtension();
                  //  $fileName = rand(111,99999).'.'.$extension;
                    $fileName =$data['admission'].'.'.$extension;
                   
                    $large_image_path = 'images/students/def'.'/'.$fileName;
                  // //  $medium_image_path = 'images/backend_images/products/medium'.'/'.$fileName;  
                    $small_image_path = 'images/students/small'.'/'.$fileName;  

                    Image::make($image_tmp)->save($large_image_path);
                  //  // Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                    //   $large_image_path = 'public/students/def/'.$fileName;
                    // // $medium_image_path ='images/backend_images/products/medium/'.$fileName;  
                    // $small_image_path = 'public/students/small/'.$fileName;  
                        //rresize imaes
                   Image::make($image_tmp)->save($large_image_path);
                     // $image_lg= Image::make($image_tmp);
                    // Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
                      // $image_sm= Image::make($image_tmp)->resize(300, 300);
                   //   \Storage::disk('local')->put('public/students/small'.'/'.$fileName,$image_tmp);


                     // \Storage::put( $large_image_path, $image_lg);
                     // \Storage::put( $small_image_path, $image_sm);
                    
                   
             // \Storage::put('barcodes/'.$data['admission'].'.png', $barcode);
              // \Storage::disk('local')->put('public/students/'.$fileNameToStore, $image_lg);

                }
            }else {
                $fileName = $data['current_image'];
            }


             // $barcode=$generator->getBarcode($data['admission'], $generator::TYPE_CODE_128,1,13);
             $barcode=QrCode::generate($data['admission']);
             $fileNameToStore = $data['admission'].'.svg';

            $file = $barcode;
          // \Storage::put('barcodes/'.$data['admission'].'.png', $barcode);
           \Storage::disk('local')->put('public/barcodes/'.$fileNameToStore, $barcode);
           // $admission_new=str_pad($data['admission'], 12, '0', STR_PAD_LEFT);
            $admission_new=$data['admission'];
            student::where(['id'=>$id])
            ->update(['first_name'=>$data['fname'],
                'last_name'=>$data['lname'],
                'birth'=>$data['dob'],
                'address'=>$data['address'],
                'email'=>$data['email'],
                'contact'=>$data['contact'],
                'parent_name'=>$data['parent_name'],
                'parent_mobile'=>$data['mobile'],
                'is_active_sms'=>$data['active_sms'],
                'whatsapp'=>$data['whatsapp'],
                'image'=>$fileName,
                'barcode'=>$fileNameToStore,
                'added'=>Session::get('adminDetails')['branch'],
                'admission_num'=>$admission_new]);

            return redirect('admin/view-students')->with('smessage', 'Student has been updated successfully');
        }

       // $classes = tution::where(['id'=>$id])->first();
        $classes = tution::where(['is_deleted'=>0])->get();
        $levels = student::where(['id'=>$id])->first();
        return view('admin.students.edit')->with(compact('levels','classes'));
    }

    public function deletetution($id = null){
        studentin_class::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Student removed from Class successfully');
    }

    public function view(Request $request){ 
        if($request->isMethod('post')){
             $data = $request->all();
       // print_r($data); 

          $branch=$data['branch'];       

             $classes = DB::table('students')
            ->select('students.*')
           // ->join('students', 'students.admission_num', '=', 'attendences.student_id')
           // ->where('students.branch',$branch)
            //->where('attendences.student_id',$student)
           //  ->selectRaw('GROUP_CONCAT(date) as attend_dates')
           //  ->GROUPBY('attendences.student_id')
          //  ->GROUPBY('attendences.class')
            ->get();
             return view('admin.students.view')->with(compact('classes'));
    }
        // if (Session::get('adminDetails')['branch']=="Admin") {
        //    $classes = student::where(['is_deleted'=>0])->orderBy('id', 'desc')->get();
        // }else{
            $classes = student::where(['is_deleted'=>0])->orderBy('id', 'desc')->get();
        // }
        
        return view('admin.students.view')->with(compact('classes'));
    }

  
    public function managereg($id=null)
    {
       $classes = tution::where(['is_deleted'=>0])->get();

       $levels = student::where(['admission_num'=>$id])->first();
         // $levels = student::where(['id'=>$id])->first();

        // $classdetails =DB::table('studentin_classes')
        //  ->select('studentin_classes.*','students.first_name','students.last_name','tutions.subject','tutions.grade')
        // ->where('studentin_classes.student_id',$id)
        // ->join('students', 'students.admission_num', '=', 'studentin_classes.student_id')
        // ->join('tutions', 'tutions.id', '=', 'studentin_classes.class')
        // ->get();

        // return Datatables::of($classdetails)
        //             ->addIndexColumn()
        //             ->addColumn('action', function($row){
   
        //                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
     
        //                     return $btn;
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);

        //admin/add-paymentnew/{id}
       //  return redirect('admin/add-paymentnew/'.$last_insert_id);
           // return redirect()->back()->with('smessage', 'Student has been added successfully');
        return view('admin.students.manage_studentsreg')->with(compact('levels','classes'));
    }


      public function regstudata(Request $request,$student)
    {

        if (request()->ajax()) {

             $classdetails =DB::table('studentin_classes')
         ->select('studentin_classes.*','students.first_name','students.last_name','tutions.subject','tutions.grade')
        ->where('studentin_classes.student_id',$student)
        ->join('students', 'students.admission_num', '=', 'studentin_classes.student_id')
        ->join('tutions', 'tutions.id', '=', 'studentin_classes.class')
        ->where('studentin_classes.added',Session::get('adminDetails')['branch'])
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

            return Datatables::of($classdetails)
                // foreach($data->tute_class as $tute){
                ->addColumn('student',function ($row){
                    return $row->first_name." ".$row->last_name ;
                })
                ->addColumn('class',function ($row) {
                         return $row->grade." ".$row->subject;  
                                                  
                }) 
                ->addColumn('action', function($row){
                           $btn = '<a href="'.url('/admin/delete-studentcls/'.$row->id).'" class="btn btn-sm bg-gradient-cyan mr-2"> <i class="fas fa-trash"> </i> Delete</a>';
                           
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



    public function manage($id=null)
    {
       $classes = tution::where(['is_deleted'=>0])->get();

        $levels = student::where(['admission_num'=>$id])->first();

        $classdetails =DB::table('studentin_classes')
         ->select('studentin_classes.*','students.first_name','students.last_name','tutions.subject','tutions.grade')
        ->where('studentin_classes.student_id',$id)
        ->join('students', 'students.admission_num', '=', 'studentin_classes.student_id')
        ->join('tutions', 'tutions.id', '=', 'studentin_classes.class')
        ->get();


        return view('admin.students.manage_students')->with(compact('levels','classes','classdetails'));
    }

    public function printId($id=null)
    {


          $student = student::where(['id'=>$id])->first();

           // echo "<pre>"; print_r($student); die;
       return view('admin.students.printid')->with(compact('student'));
    }

    public function stuincls(Request $request)
    {
        $data = $request->all();
        $day=date('Y-m-d', strtotime(date('Y-m-d')));

        // $check = attendence::where(['student_id'=>$data['student'],'subject'=>$data['subject'],'class'=>$data['clas'],'date'=>$day])->count();
               // if ($check==0) {
               // }
                  $attend = new studentin_class;
                    $attend->student_id = $data['student'];
                    $attend->class = $data['clas'];
                    $attend->join_date = $day;
                  //  $attend->fees_type=$data['fees_type'];
                     $attend->added=Session::get('adminDetails')['branch'];
                    // $attend->admin=$admin;
                    $attend->save();

                   echo json_encode("success"); 
    }

     public function delete($id = null){
      //  attendence::where(['id'=>$id])->delete();

        student::where('id', $id)
          ->update(['is_deleted' => 1]);
        return redirect('admin/view-students')->with('dmessage', 'Deleted successfully');
    }

     public function deleteStudentImage($id=null){

        // Get Product Image
        $productImage = Student::where('id',$id)->first();

        // Get Product Image Paths
        $large_image_path = 'images/students/large/';
      //  $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/students/small/';

        // Delete Large Image if not exists in Folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        // Delete Medium Image if not exists in Folder
        // if(file_exists($medium_image_path.$productImage->image)){
        //     unlink($medium_image_path.$productImage->image);
        // }

        // Delete Small Image if not exists in Folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        // Delete Image from Products table
        Student::where(['id'=>$id])->update(['Image'=>'']);

        return redirect()->back()->with('dmessage', 'Image has been deleted successfully');
    }

    public function sendsms()
    {
      
     //  $id ="94757480969";
     // $pw = "9582";
     //  $to = "0757480969";
     //  $text = "Your%20Payment%20Has%20been%20Updated";


      //http://www.textit.biz/sendmsg?id=xxxxxxx&pw=xxxx&to=xxxx&text=xxxxxx
   //  echo $url ='https://www.textit.biz/sendmsg?id='.$id.'&pw='.$pw.'&to='.$to.'&text='.$text.'';
   //  https://www.textit.biz/sendmsg/?id=94757480969&pw=9582&to=0757480969&text=Hello+World
   // return redirect::away('https://www.textit.biz/sendmsg?id='.$id.'&pw='.$pw.'&to='.$to.'&text='.$text.'');
     // if ($url) {
     //   echo "string";
     // }
     //  $id ="94757480969";
     // $pw = "9582";
     //  $to = "0757480969";
     //  $text = "Your%20Payment%20Has%20been%20Updated";


            $user = "94757480969";
        $password = "9582";
        $text = urlencode("This is an example message");
        $to = "0757480969";

        $baseurl ="http://www.textit.biz/sendmsg";
        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
        $ret = file($url);

        $res= explode(":",$ret[0]);

        if (trim($res[0])=="OK")
        {
        echo "Message Sent - ID : ".$res[1];
        }
        else
        {
        echo "Sent Failed - Error : ".$res[1];
        }
     }

     public function changefeestype(Request $request){

        $data = $request->all();
        $id=$data['id'];
        $status=$data['status'];
         // $temp = new feestemp;
         //     $temp->student_id = $data['student'];
         //     $temp->amount = $data['fees'];
         //     $temp->class =  $data['clas'];
         //     $temp->month_for =  $data['month'];

             $tmp= studentin_class::where(['id'=>$id])->update(['fees_type'=>$status]);

             if($tmp){
                 echo "true"; die;
                 echo json_encode('1');
                 
             }else{
              //  echo "false"; die;
                 echo json_encode('0');        
             }

            //return $billtemptble; die;
             
             
    }

}

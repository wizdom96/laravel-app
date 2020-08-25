<?php
namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use DB;

class UsersController extends Controller{

  public function index(){
    
    $users = User::select('user')->distinct()->get();

    return view('index',['users' => $users]);
  }




  public function uploadFile(Request $request){

    if ($request->input('submit') != null ){

      $file = $request->file('file');

      // File Details 
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();
      $tempPath = $file->getRealPath();
      $fileSize = $file->getSize();
      $mimeType = $file->getMimeType();

      // Valid File Extensions
      $valid_extension = array("csv");

      // 2MB in Bytes
      $maxFileSize = 2097152; 

      // Check file extension
      if(in_array(strtolower($extension),$valid_extension)){

        // Check file size
        if($fileSize <= $maxFileSize){

          // File upload location
          $location = 'uploads';

          // Upload file
          $file->move($location,$filename);

          // Import CSV to Database
          $filepath = public_path($location."/".$filename);

          // Reading file
          $file = fopen($filepath,"r");

          $importData_arr = array();
          $i = 0;

          while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
             $num = count($filedata);
             
            
             if($i == 0){
                $i++;
                continue; 
             }
             for ($c=0; $c < $num; $c++) {
                $importData_arr[$i][] = $filedata [$c];
             }
             $i++;
          }
          fclose($file);

          
          foreach($importData_arr as $importData){

          
            $insertData = array(
              
                "user"=>$importData[0],
                "client"=>$importData[1],
                "client_type"=>$importData[2],
                "date"=>$importData[3],
                "duration"=>$importData[4],
                "type_of_call"=>$importData[5],
                "external"=>$importData[6]
               
            );
            User::insertData($insertData);

          }

          Session::flash('message','Import Successful.');
        }else{
          Session::flash('message','File too large. File must be less than 2MB.');
        }

      }else{
         Session::flash('message','Invalid File Extension.');
      }

    }

    // Redirect to index
    return redirect()->action('UsersController@index');
  }




  public function getDetails($name){

          $average = 0;
          $averagecall = 0;
          $ars7 =[];
          $callduration7 = [];
        
        for($i = 7; $i> 0; $i--){
          
          $users = [];
        $users= User::where('user',$name)->whereBetween('date',[Carbon::now()->subDays($i), Carbon::now()])
        ->get();
        foreach($users as $user){
              $average = $average +  $user->external;
              $averagecall = $averagecall + $user->duration;
        }
        $average = $average / count($users);
       

        array_push($ars7, [$average]);
        array_push($callduration7, [$averagecall/86400]);
        }

        $ars30 = [];
        $callduration30 = [];


          for($i = 30; $i> 0; $i--){
            
            $users = [];
          $users= User::where('user',$name)->whereBetween('date',[Carbon::now()->subDays($i), Carbon::now()])
          ->get();
          foreach($users as $user){
                $average = $average +  $user->external;
          }
          $average = $average / count($users);
          

          array_push($ars30, [$average]);
          array_push($callduration30, [$averagecall/86400]);

        }

        $ars7 = json_encode($ars7);
        $callduration7= json_encode($callduration7);
        $ars30 = json_encode($ars30);
        $callduration30= json_encode($callduration30);


        //get last 5 calls

        $lastcalls= User::where('user',$name)->orderBy('date','desc')->take(5)
        ->get();

    return view ('details', ['ars7'=>$ars7, 'callduration7'=>$callduration7, 'ars30'=>$ars30, 'callduration30'=>$callduration30, 'name'=>$name, 'lastcalls'=>$lastcalls]);
      }
    }
  
    

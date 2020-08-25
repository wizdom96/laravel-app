<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class User extends Model {

   public static function insertData($data){

    
         DB::table('users')->insert($data);
      
   }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class listmodel extends Model
{
    use HasFactory;
    protected $table = "list";

    public static function getList(){
        $records = DB::table('list')->select('id','gno','ino','date','rfrom','subject')->get()->toArray();
        return $records;
    }
}

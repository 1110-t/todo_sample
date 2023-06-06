<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TodoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'user_id',
        'expire_date',
        'finished_date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function insertTodo(Request $request){
        if(!isset($request->finished_date)) {
            $request->merge(['finished_date'=>0]);
        }
        $this->fill($request->all());
        if($request->finished_date == 1) {
            $this->finished_date =  date("Y-m-d H:i:s");
        } else {
            $this->finished_date = null;
        }
        $this->registration_date = date("Y-m-d H:i:s");
        $this->save();
        return $this;
    }

}

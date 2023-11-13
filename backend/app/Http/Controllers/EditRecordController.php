<?php

namespace App\Http\Controllers;

use App\Models\EditRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EditRecordController extends Controller
{
    public function showEditRecord(){
        $editRecord = EditRecord::with(['user', 'role'])->get();
        return $editRecord;
    }

}

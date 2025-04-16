<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Device;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:students_update'])->only(['edit', 'update']);
    }

    public function destroy($id)
    {
        Device::find($id)->delete();
        return redirect()->back();
    }
}

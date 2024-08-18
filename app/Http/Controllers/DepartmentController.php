<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Models\User;


class DepartmentController extends Controller
{

    public function department(Request $request)
    {
        $notification['notify'] = DB::select("
        SELECT
            users.id,
            users.name,
            users.lastname,
            users.email,
            COUNT(messages.is_read) AS unread
        FROM
            users
        LEFT JOIN
            messages ON users.id = messages.send_to AND messages.is_read = 0
        WHERE
            users.id = " . Auth::id() . "
        GROUP BY
            users.id, users.name, users.lastname, users.email
    ");

    $search = $request->input('search');

    // Fetch departments that match the search query and are not marked as deleted
    $departments = Department::where('name', 'LIKE', "%{$search}%")
        ->where('deleted', 1)
        ->paginate(10);

    // Fetch positions that belong to the found departments
    $departmentIds = $departments->pluck('id');
    $position = Position::whereIn('department_id', $departmentIds)
        ->where('deleted', 1)
        ->paginate(10);
        $query = Message::getNotify();



        // Fetch positions based on the search query
        if(Auth::user()->user_type === 0){
            $employeeData = User::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
            ->where('user_type', '!=', 0)
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();
        }else{
            $employeeData = User::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
            ->whereNotIn('user_type', [0, 1])
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();
        }

// Calculate growth rate for each year
$growthRates = [];
$years = array_keys($employeeData);
for ($i = 1; $i < count($years); $i++) {
$previousYearEmployees = $employeeData[$years[$i - 1]];
$currentYearEmployees = $employeeData[$years[$i]];
$growthRate = (($currentYearEmployees - $previousYearEmployees) / $previousYearEmployees) * 100;
$growthRates[$years[$i]] = $growthRate;
}


        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.department.department'
            : (Auth::user()->user_type == 1
                ? 'admin.department.department'
                : 'employee.dashboard');


        return view($viewPath, [
            'notification' => $notification,
            'getNot' => $getNot,
            'departments' => $departments,
            'position' => $position,
            'growthRates' => $growthRates,
            'employeeData' => $employeeData,

        ]);
    }


    public function departmentarchived(Request $request)
    {
        $notification['notify'] = DB::select("
        SELECT
            users.id,
            users.name,
            users.lastname,
            users.email,
            COUNT(messages.is_read) AS unread
        FROM
            users
        LEFT JOIN
            messages ON users.id = messages.send_to AND messages.is_read = 0
        WHERE
            users.id = " . Auth::id() . "
        GROUP BY
            users.id, users.name, users.lastname, users.email
    ");

    $search = $request->input('search');

    // Fetch departments that match the search query and are not marked as deleted
    $departments = Department::where('name', 'LIKE', "%{$search}%")
        ->where('deleted', 2)
        ->paginate(10);

    // Fetch positions that belong to the found departments and are not marked as deleted
    $departmentIds = $departments->pluck('id');
    $position = Position::whereIn('department_id', $departmentIds)
        ->where('deleted', 2)
        ->where('name', 'LIKE', "%{$search}%")
        ->paginate(10);

        if(Auth::user()->user_type === 0){
            $employeeData = User::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
            ->where('user_type', '!=', 0)
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();
        }else{
            $employeeData = User::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
            ->whereNotIn('user_type', [0, 1])
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();
        }

// Calculate growth rate for each year
$growthRates = [];
$years = array_keys($employeeData);
for ($i = 1; $i < count($years); $i++) {
$previousYearEmployees = $employeeData[$years[$i - 1]];
$currentYearEmployees = $employeeData[$years[$i]];
$growthRate = (($currentYearEmployees - $previousYearEmployees) / $previousYearEmployees) * 100;
$growthRates[$years[$i]] = $growthRate;
}


        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.department.departmentarchived'
            : (Auth::user()->user_type == 1
                ? 'admin.department.departmentarchived'
                : 'employee.message');


        return view($viewPath, [
            'notification' => $notification,
            'getNot' => $getNot,
            'departments' => $departments,
            'position' => $position,
            'growthRates' => $growthRates,
            'employeeData' => $employeeData,
        ]);
    }


    public function getPositions($department_id)
    {
        $positions = Position::where('department_id', $department_id)->get();
        return response()->json($positions);
    }

    public function adddepartment(Request $request)
    {
        $department = new Department;

        $request->validate([
            'name' => 'string|max:50|unique:departments,name',
        ], [
            'name.unique' => 'This name has already been taken.',
        ]);

        $department->name = $request->name;
        $department->save();

        return redirect()->back()->with('success', 'Department successfully added');
    }
    public function updatedepartment($id, Request $request)
    {

        $department = Department::getId($id);
        $request->validate([
            'name' => 'required|string|max:50|unique:departments,name,' . $request->id,
        ],[
            'name.unique' => 'This name has already been taken.',
        ]);

        $department->name = $request->name;
        $department->save();

        return redirect()->back()->with('success', 'Department successfully updated');
    }

    public function updateposition($id, Request $request)
    {

        $position = Position::getId($id);
        $request->validate([
            'name' => 'required|string|max:50|unique:departments,name,' . $request->id,
        ],[
            'name.unique' => 'This name has already been taken.',
        ]);

        $position->name = $request->name;
        $position->save();

        return redirect()->back()->with('success', 'Department successfully updated');
    }


    public function addposition(Request $request)
    {

        $position = new Position;

        $request->validate([
            'name' => 'required|string|max:50|unique:positions,name',
            'department_id' => 'required|integer|exists:departments,id',
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'This name has already been taken.',
            'department_id.required' => 'The department field is required.',
            'department_id.exists' => 'The selected department is invalid.',
        ]);



        $position->name = $request->name;
        $position->department_id = $request->department_id;

        $position->save();

        return redirect()->back()->with('success', 'Position successfully added');
    }

    public function deleted($id)
    {
        $user = Department::getId($id);
        $user->deleted = 2;
        $user->save();

        return redirect()->back()->with('success', 'Department successfully DELETED');
    }
    public function deletedrestored($id)
    {
        $user = Department::getId($id);
        $user->deleted = 1;
        $user->save();

        return redirect()->back()->with('success', 'Department successfully RESTORED');
    }

    public function deletedposition($id)
{
    // Find the position by ID
    $position = Position::findOrFail($id);

    // Permanently delete the position from the database
    $position->forceDelete();

    return redirect()->back()->with('success', 'Position successfully deleted');
}

}

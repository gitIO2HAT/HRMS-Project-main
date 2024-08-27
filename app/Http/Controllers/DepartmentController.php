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
            $employeeData = User::selectRaw('YEAR(date_of_assumption) as year, COUNT(*) as total')
            ->where('user_type', '!=', 0)
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();

            $employeeCount = User::where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->where('user_type', '!=', 0)
            ->count();

        $employeefemale = User::where('sex', '=', 'Female')
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employeemale = User::where('sex', '=', 'Male')
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee1822 = User::whereBetween('age', [18, 22])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee2327 = User::whereBetween('age', [23, 27])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee2833 = User::whereBetween('age', [28, 33])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee3438 = User::whereBetween('age', [34, 38])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee3943 = User::whereBetween('age', [39, 43])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee4448 = User::whereBetween('age', [44, 48])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee4953 = User::whereBetween('age', [49, 53])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee5460 = User::whereBetween('age', [54, 60])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();

        $departmentCounts = User::select('department', DB::raw('count(*) as total'))
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->groupBy('department')
            ->get();

        // Prepare data for Chart.js
        $departmentsedits = $departmentCounts->pluck('department');
        $counts = $departmentCounts->pluck('total');

        $totalEmployeesAtStart = User::where('date_of_assumption', '<=', now()->startOfYear())
        ->where('user_type', '!=', 0)->count();
        $employeesStayed = User::where('is_archive', 1)
        ->where('user_type', '!=', 0)->count();

        // Handle division by zero
        if ($totalEmployeesAtStart > 0) {
            // Calculate retention rate
            $retentionRate = ($employeesStayed / $totalEmployeesAtStart) * 100;
        } else {
            // Set retention rate to 0 or handle it differently
            $retentionRate = 0;
        }
    $totalEmployeesAtEnd = User::count();
    // Calculate the number of employees who have left (assuming archived employees have left)
    $employeesLeft = User::where('is_archive', 2)
    ->where('user_type', '!=', 0)
    ->count();

    // Calculate the average number of employees
    if ($totalEmployeesAtStart + $totalEmployeesAtEnd > 0) {
        $averageEmployees = ($totalEmployeesAtStart + $totalEmployeesAtEnd) / 2;
    } else {
        $averageEmployees = 0;
    }

    // Handle division by zero
    if ($averageEmployees > 0) {
        // Calculate turnover rate
        $turnoverRate = ($employeesLeft / $averageEmployees) * 100;
    } else {
        $turnoverRate = 0;
    }
        }else{
            $employeeData = User::selectRaw('YEAR(date_of_assumption) as year, COUNT(*) as total')
            ->whereNotIn('user_type', [0, 1])
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();

            $employeeCount = User::where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->where('user_type', '!=', 0)
            ->count();

        $employeefemale = User::where('sex', '=', 'Female')
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employeemale = User::where('sex', '=', 'Male')
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee1822 = User::whereBetween('age', [18, 22])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee2327 = User::whereBetween('age', [23, 27])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee2833 = User::whereBetween('age', [28, 33])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee3438 = User::whereBetween('age', [34, 38])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee3943 = User::whereBetween('age', [39, 43])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee4448 = User::whereBetween('age', [44, 48])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee4953 = User::whereBetween('age', [49, 53])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee5460 = User::whereBetween('age', [54, 60])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();

        $departmentCounts = User::select('department', DB::raw('count(*) as total'))
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->groupBy('department')
            ->get();

        // Prepare data for Chart.js
        $departmentsedits = $departmentCounts->pluck('department');
        $counts = $departmentCounts->pluck('total');

        $totalEmployeesAtStart = User::where('date_of_assumption', '<=', now()->startOfYear())
        ->where('user_type', '!=', 0)->count();
        $employeesStayed = User::where('is_archive', 1)
        ->where('user_type', '!=', 0)->count();

        // Handle division by zero
        if ($totalEmployeesAtStart > 0) {
            // Calculate retention rate
            $retentionRate = ($employeesStayed / $totalEmployeesAtStart) * 100;
        } else {
            // Set retention rate to 0 or handle it differently
            $retentionRate = 0;
        }
    $totalEmployeesAtEnd = User::count();
    // Calculate the number of employees who have left (assuming archived employees have left)
    $employeesLeft = User::where('is_archive', 2)
    ->where('user_type', '!=', 0)
    ->count();

    // Calculate the average number of employees
    if ($totalEmployeesAtStart + $totalEmployeesAtEnd > 0) {
        $averageEmployees = ($totalEmployeesAtStart + $totalEmployeesAtEnd) / 2;
    } else {
        $averageEmployees = 0;
    }

    // Handle division by zero
    if ($averageEmployees > 0) {
        // Calculate turnover rate
        $turnoverRate = ($employeesLeft / $averageEmployees) * 100;
    } else {
        $turnoverRate = 0;
    }
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
            'employeefemale' => $employeefemale,
            'employeemale' => $employeemale,
            'employee1822' => $employee1822,
            'employee2327' => $employee2327,
            'employee2833' => $employee2833,
            'employee3438' => $employee3438,
            'employee3943' => $employee3943,
            'employee4448' => $employee4448,
            'employee4953' => $employee4953,
            'employee5460' => $employee5460,
            'departmentsedits' => $departmentsedits,
            'counts' => $counts,
            'employeesStayed' => $employeesStayed,
            'totalEmployeesAtStart' => $totalEmployeesAtStart,
            'retentionRate' => $retentionRate,
            'averageEmployees' => $averageEmployees,
            'employeesLeft' => $employeesLeft,
            'turnoverRate' => $turnoverRate

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
            $employeeData = User::selectRaw('YEAR(date_of_assumption) as year, COUNT(*) as total')
            ->where('user_type', '!=', 0)
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();

            $employeeCount = User::where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->where('user_type', '!=', 0)
            ->count();

        $employeefemale = User::where('sex', '=', 'Female')
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employeemale = User::where('sex', '=', 'Male')
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee1822 = User::whereBetween('age', [18, 22])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee2327 = User::whereBetween('age', [23, 27])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee2833 = User::whereBetween('age', [28, 33])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee3438 = User::whereBetween('age', [34, 38])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee3943 = User::whereBetween('age', [39, 43])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee4448 = User::whereBetween('age', [44, 48])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee4953 = User::whereBetween('age', [49, 53])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee5460 = User::whereBetween('age', [54, 60])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();

        $departmentCounts = User::select('department', DB::raw('count(*) as total'))
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->groupBy('department')
            ->get();

        // Prepare data for Chart.js
        $departmentsedits = $departmentCounts->pluck('department');
        $counts = $departmentCounts->pluck('total');

        $totalEmployeesAtStart = User::where('date_of_assumption', '<=', now()->startOfYear())
        ->where('user_type', '!=', 0)->count();
        $employeesStayed = User::where('is_archive', 1)
        ->where('user_type', '!=', 0)->count();

        // Handle division by zero
        if ($totalEmployeesAtStart > 0) {
            // Calculate retention rate
            $retentionRate = ($employeesStayed / $totalEmployeesAtStart) * 100;
        } else {
            // Set retention rate to 0 or handle it differently
            $retentionRate = 0;
        }
    $totalEmployeesAtEnd = User::count();
    // Calculate the number of employees who have left (assuming archived employees have left)
    $employeesLeft = User::where('is_archive', 2)
    ->where('user_type', '!=', 0)
    ->count();

    // Calculate the average number of employees
    if ($totalEmployeesAtStart + $totalEmployeesAtEnd > 0) {
        $averageEmployees = ($totalEmployeesAtStart + $totalEmployeesAtEnd) / 2;
    } else {
        $averageEmployees = 0;
    }

    // Handle division by zero
    if ($averageEmployees > 0) {
        // Calculate turnover rate
        $turnoverRate = ($employeesLeft / $averageEmployees) * 100;
    } else {
        $turnoverRate = 0;
    }
        }else{
            $employeeData = User::selectRaw('YEAR(date_of_assumption) as year, COUNT(*) as total')
            ->whereNotIn('user_type', [0, 1])
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();

            $employeeCount = User::where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->where('user_type', '!=', 0)
            ->count();

        $employeefemale = User::where('sex', '=', 'Female')
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employeemale = User::where('sex', '=', 'Male')
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee1822 = User::whereBetween('age', [18, 22])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee2327 = User::whereBetween('age', [23, 27])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee2833 = User::whereBetween('age', [28, 33])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee3438 = User::whereBetween('age', [34, 38])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee3943 = User::whereBetween('age', [39, 43])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee4448 = User::whereBetween('age', [44, 48])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee4953 = User::whereBetween('age', [49, 53])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();
        $employee5460 = User::whereBetween('age', [54, 60])
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->count();

        $departmentCounts = User::select('department', DB::raw('count(*) as total'))
            ->where('is_archive', 1)
            ->where('user_type', '!=', 0)
            ->groupBy('department')
            ->get();

        // Prepare data for Chart.js
        $departmentsedits = $departmentCounts->pluck('department');
        $counts = $departmentCounts->pluck('total');

        $totalEmployeesAtStart = User::where('date_of_assumption', '<=', now()->startOfYear())
        ->where('user_type', '!=', 0)->count();
        $employeesStayed = User::where('is_archive', 1)
        ->where('user_type', '!=', 0)->count();

        // Handle division by zero
        if ($totalEmployeesAtStart > 0) {
            // Calculate retention rate
            $retentionRate = ($employeesStayed / $totalEmployeesAtStart) * 100;
        } else {
            // Set retention rate to 0 or handle it differently
            $retentionRate = 0;
        }
    $totalEmployeesAtEnd = User::count();
    // Calculate the number of employees who have left (assuming archived employees have left)
    $employeesLeft = User::where('is_archive', 2)
    ->where('user_type', '!=', 0)
    ->count();

    // Calculate the average number of employees
    if ($totalEmployeesAtStart + $totalEmployeesAtEnd > 0) {
        $averageEmployees = ($totalEmployeesAtStart + $totalEmployeesAtEnd) / 2;
    } else {
        $averageEmployees = 0;
    }

    // Handle division by zero
    if ($averageEmployees > 0) {
        // Calculate turnover rate
        $turnoverRate = ($employeesLeft / $averageEmployees) * 100;
    } else {
        $turnoverRate = 0;
    }
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

            'employeefemale' => $employeefemale,
            'employeemale' => $employeemale,
            'employee1822' => $employee1822,
            'employee2327' => $employee2327,
            'employee2833' => $employee2833,
            'employee3438' => $employee3438,
            'employee3943' => $employee3943,
            'employee4448' => $employee4448,
            'employee4953' => $employee4953,
            'employee5460' => $employee5460,
            'departmentsedits' => $departmentsedits,
            'counts' => $counts,
            'employeesStayed' => $employeesStayed,
            'totalEmployeesAtStart' => $totalEmployeesAtStart,
            'retentionRate' => $retentionRate,
            'averageEmployees' => $averageEmployees,
            'employeesLeft' => $employeesLeft,
            'turnoverRate' => $turnoverRate,
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

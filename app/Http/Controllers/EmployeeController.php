<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Models\Department;
use App\Models\Position;

class EmployeeController extends Controller
{
    public function employee(Request $request)
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

        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();

        $query = User::getEmployee();

        $search = $request->input('search');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(name, ' ', lastname) LIKE ?", ["%$search%"])
                    ->orWhere('custom_id', 'LIKE', "%$search%")
                    ->orWhere('department', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('end_of_contract', 'LIKE', "%$search%")
                    ->orWhere('position', 'LIKE', "%$search%")
                    ->orWhere('daily_rate', 'LIKE', "%$search%");
            });
        }

        $data['getEmployee'] = $query->orderBy('id', 'desc')->paginate(10);


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

        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.employee.employee'
            : (Auth::user()->user_type == 1
                ? 'admin.employee.employee'
                : 'employee.dashboard');

        return view($viewPath, $data, [
            'notification' => $notification,
            'getNot' => $getNot,
            'growthRates' => $growthRates,
            'employeeData' => $employeeData,
        ]);
    }

    public function addemployee(Request $request)
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

        // Fetch positions that belong to the found departments and are not marked as deleted
        $departmentIds = $departments->pluck('id');
        $position = Position::whereIn('department_id', $departmentIds)
            ->where('deleted', 1)
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
            ? 'superadmin.employee.addemployee'
            : (Auth::user()->user_type == 1
                ? 'admin.employee.addemployee'
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

    public function insertemployee(Request $request)
    {
        $user = new User;

        // Create a new user instance
        $request->validate([
            'name' => 'required|string|max:30',
            'middlename' => 'required|string|max:30',
            'lastname' => 'required|string|max:30',
            'suffix' => 'nullable|in:Jr.,Sr.,I,II,III',
            'sex' => 'required|in:Male,Female,Other',
            'age' => 'required|integer|min:18',
            'birth_date' => 'required|date',
            'phonenumber' => 'required|string|max:20',
            'department' => 'required|integer', // Validate as integer if using IDs
            'position' => 'required|integer',   // Validate as integer if using IDs
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
            'end_of_contract' => 'required|date',
            'user_type' => 'required|integer',
            'daily_rate' => 'required|numeric|min:0',
        ], [
            'name.required' => 'The name field is required.',
            'middlename.required' => 'The middlename field is required.',
            'lastname.required' => 'The lastname field is required.',
            'sex.required' => 'The sex field is required.',
            'sex.in' => 'Invalid value for sex.',
            'age.required' => 'The age field is required.',
            'age.integer' => 'The age must be an integer.',
            'age.min' => 'The age must be at least 18.',
            'birth_date.required' => 'The birth date field is required.',
            'birth_date.date' => 'Invalid date format for birth date.',
            'phonenumber.required' => 'The phonenumber field is required.',
            'department.required' => 'The department field is required.',
            'department.integer' => 'Invalid value for department.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'This email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.string' => 'Invalid password format.',
            'password.min' => 'The password must be at least 8 characters.',
            'user_type.required' => 'The user type field is required.',
            'user_type.integer' => 'Invalid value for user type.',
            'daily_rate.required' => 'The daily rate field is required.',
            'daily_rate.numeric' => 'Invalid value for daily rate.',
            'daily_rate.min' => 'The daily rate must be at least 0.',
        ]);

        // Assign values to user properties
        $user->name = trim($request->name);
        $user->middlename = trim($request->middlename);
        $user->lastname = trim($request->lastname);
        $user->suffix = $request->suffix;
        $user->sex = $request->sex;
        $user->age = $request->age;
        $user->birth_date = $request->input('birth_date') ? trim($request->input('birth_date')) : null;
        $user->phonenumber = trim($request->phonenumber);

        // Find the department by ID and assign the name
        $department = Department::find($request->department);
        if ($department) {
            $user->department = $department->name;
        } else {
            return redirect()->back()->withErrors(['department' => 'Department not found']);
        }

        // Find the position by ID and assign the name
        $position = Position::find($request->position);
        if ($position) {
            $user->position = $position->name;
        } else {
            return redirect()->back()->withErrors(['position' => 'Position not found']);
        }

        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->end_of_contract = $request->input('end_of_contract') ? trim($request->input('end_of_contract')) : null;
        $user->user_type = $request->user_type;
        $user->daily_rate = $request->daily_rate;

        // Generate custom ID
        $currentYear = Carbon::now()->format('Y');
        $latestUserId = User::latest('id')->first(); // Get the latest user ID
        $nextUserId = ($latestUserId) ? $latestUserId->id + 1 : 1; // Increment the latest user ID
        $customId = $currentYear . '-' . sprintf('%05d', $nextUserId); // Format the custom ID

        // Assign the custom ID to the user
        $user->custom_id = $customId;

        // Save the user to the database
        $user->save();

        return redirect()->back()->with('success', 'Employee successfully added');
    }


    public function editemployee($id)
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


        $departments = Department::all();
        $positions = Position::all();
        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $data['getId'] = User::getId($id);

        if (!empty($data['getId'])) {
            $viewPath = Auth::user()->user_type == 0
                ? 'superadmin.employee.editemployee'
                : (Auth::user()->user_type == 1
                    ? 'admin.employee.editemployee'
                    : 'employee.dashboard');


            return view($viewPath, $data, [
                'notification' => $notification,
                'departments' => $departments,
                'positions' => $positions,
                'getNot' => $getNot,
                'growthRates' => $growthRates,
                'employeeData' => $employeeData,
            ]);
        } else {
            abort(404);
        }
    }

    public function updateemployee($id, Request $request)
    {
        $user = User::find($id); // Assuming you're finding the user by ID

        // Validate the input fields
        $request->validate([
            'department' => 'nullable|integer', // Validate as integer if using IDs
            'position' => 'nullable|integer',   // Validate as integer if using IDs
            'end_of_contract' => 'nullable|date',
        ], [
            'department.integer' => 'Invalid value for department.',
            'daily_rate.numeric' => 'Invalid value for daily rate.',
            'daily_rate.min' => 'The daily rate must be at least 0.',
        ]);

        // Check if the department field is provided in the request
        if ($request->filled('department')) {
            $department = Department::find($request->department);
            if ($department) {
                $user->department = $department->name;
            } else {
                return redirect()->back()->withErrors(['department' => 'Department not found']);
            }
        }

        // Check if the position field is provided in the request
        if ($request->filled('position')) {
            $position = Position::find($request->position);
            if ($position) {
                $user->position = $position->name;
            } else {
                return redirect()->back()->withErrors(['position' => 'Position not found']);
            }
        }

        $user->end_of_contract = $request->input('end_of_contract') ? trim($request->input('end_of_contract')) : null;
        $user->daily_rate = $request->daily_rate;

        $user->save();

        return redirect()->back()->with('success', 'Employee successfully updated');
    }


    public function previewemployee($id)
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
        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $data['getId'] = User::getId($id);

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

        if (!empty($data['getId'])) {
            $viewPath = Auth::user()->user_type == 0
                ? 'superadmin.employee.previewemployee'
                : (Auth::user()->user_type == 1
                    ? 'admin.employee.previewemployee'
                    : 'employee.dashboard');


            return view($viewPath, $data, [
                'notification' => $notification,
                'getNot' => $getNot,
                'growthRates' => $growthRates,
                'employeeData' => $employeeData,
            ]);
        } else {
            abort(404);
        }
    }
    public function archive($id)
    {
        $user = User::getId($id);
        $user->is_archive = 2;
        $user->date_archive = now()->format('Y-m-d H:i:s');
        $user->save();

        return redirect()->back()->with('success', 'Employee successfully archived');
    }
    public function restore($id)
    {
        $user = User::getId($id);
        $user->is_archive = 1;
        $user->date_archive = null;
        $user->save();

        return redirect()->back()->with('success', 'Employee successfully restore');
    }

    public function archiveemployee(Request $request)
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

        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $query = User::getArchiveEmployee();

        $search = $request->input('search');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(name, ' ', lastname) LIKE ?", ["%$search%"])
                    ->orWhere('custom_id', 'LIKE', "%$search%")
                    ->orWhere('department', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('end_of_contract', 'LIKE', "%$search%")
                    ->orWhere('position', 'LIKE', "%$search%")
                    ->orWhere('daily_rate', 'LIKE', "%$search%");
            });
        }

        $data['getEmployee'] = $query->orderBy('id', 'desc')->paginate(10);

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

        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.employee.archiveemployee'
            : (Auth::user()->user_type == 1
                ? 'admin.employee.archiveemployee'
                : 'employee.dashboard');


        return view($viewPath, $data, [
            'notification' => $notification,
            'getNot' => $getNot,
            'growthRates' => $growthRates,
            'employeeData' => $employeeData,
        ]);
    }
}

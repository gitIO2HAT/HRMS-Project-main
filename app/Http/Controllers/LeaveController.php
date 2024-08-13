<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Models\Message;
use App\Models\Leave;

class LeaveController extends Controller
{
    public function leave(Request $request)
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

        $query = Leave::query();

        if ($request->filled('search')) {
            $query->where('reason', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('from', [$request->input('from'), $request->input('to')]);
        }

        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->input('leave_type'));
        }

        $leaves = $query->paginate(10);

        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.leave.leave'
            : (Auth::user()->user_type == 1
                ? 'admin.leave.leave'
                : 'employee.leave.leave');


        return view($viewPath, [
            'notification' => $notification,
            'getNot' => $getNot,
            'leaves' => $leaves,
        ]);
    }


 
  
    
    public function addleave(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'leave_type' => 'required|in:Sick Leave,Vacation Leave',
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'reason' => 'required|string',
        ], [
            'leave_type.required' => 'The leave type field is required.',
            'from.required' => 'This field is required.',
            'to.required' => 'This field is required.',
            'reason.required' => 'The reason field is required.',
        ]);
    
        try {
            // Get the current time from the external API
            $response = Http::get('http://worldtimeapi.org/api/timezone/Asia/Manila');
            $internetTime = Carbon::parse($response->json()['datetime']);
    
            // Calculate the number of leave days
            $fromDate = Carbon::parse($validatedData['from']);
            $toDate = Carbon::parse($validatedData['to']);
            $leaveDays = $toDate->diffInDays($fromDate) + 1; // Include the start date in the count
    
            // Check if the leave starts in the future
            if ($fromDate->lessThan($internetTime)) {
                return redirect()->back()->withErrors('Leave start date must be in the future.');
            }
    
            // Create a new Leave instance and assign validated data
            $leave = new Leave([
                'employee_id' => Auth::user()->custom_id, // Correctly set employee_id here
                'leave_type' => $validatedData['leave_type'],
                'from' => $validatedData['from'],
                'to' => $validatedData['to'],
                'reason' => $validatedData['reason'],
                'leave_days' => $leaveDays, // Assuming you have a column in your table to store leave days
            ]);
    
            // Save the leave record
            $leave->save();
    
            return redirect()->back()->with('success', 'Leave successfully added');
        } catch (\Exception $e) {
            Log::error('Error adding leave', ['message' => $e->getMessage()]);
            return redirect()->back()->withErrors('There was an error saving your leave.');
        }
    }
    
}

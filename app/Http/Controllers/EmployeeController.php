<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $file = $request->file('avatar');
        $filename = time().'.'.$file->getClientOriginalExtension();
        $file->storeAs('public/images', $filename);

        $employeedata = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address,
            'post' => $request->post,
            'avatar' => $filename
        ];

        Employee::create($employeedata);
        return response()->json([
            'status' => 200,
        ]);
    }

// fetch all employees

    public function fetchemployee()
    {
        $emps = Employee::all();
        $output = '';
        if($emps->count() > 0)
        {
            $output .= '<table class = "table table-striped table-sm text-center align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Avatar</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Post</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($emps as $emp)
                {
                    $output .= '<tr>
                        <td>'. $emp->id .'</td>
                        <td><img src = "storage/images/'. $emp->avatar .'" width = "50" class = "img-thumbnail rounded-circle"> </td>
                        <td>'. $emp->first_name .'</td>
                        <td>'. $emp->last_name .'</td>
                        <td>'. $emp->email .'</td>
                        <td>'. $emp->address .'</td>
                        <td>'. $emp->post .'</td>
                        <td>
                            <a href = "#" id = "'. $emp->id .'" class = "text-success mx-1 editIcon" data-bs-toggle = "modal" data-bs-target = "#editEmployeeModal"><i class = "bi-pencil-square h4"></i></a>
                            <a href = "#" id = "'. $emp->id .'" class = "text-danger mx-1 deleteIcon"><i class = "bi-trash h4"></i></a>
                        </td>
                    </tr>';
                }
            $output .= '<tbody></table>';
            echo $output; 
        } 
        else
        {
            echo '<h1 class = "text-center text-secondary my-5">No Record Found</h1>';
        }
    }

    // handle edit employee ajax request

    public function editemployee(Request $request)
    {
        $id = $request->id;
        $emp = Employee::find($id);
        return response()->json($emp);
    }

    // updating the employee function

    public function updateemployee(Request $request)
    {
        $filename = '';
        $emp = Employee::find($request->emp_id);
        if($request->hasFile('avatar'))
        {
            $file = $request->file('avatar');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/images', $filename);
            if($emp->avatar)
            {
                Storage::delete('public/images/'.$emp->avatar);
            }
        }
        else
        {
            $filename = $request->emp_avatar;
        }
        $empdata = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'email' => $request->email,
            'post' => $request->post,
            'avatar' => $filename
        ];
        $emp->update($empdata);
        return response()->json([
            'status' => 200
        ]);
    }

// delete employee ajax request function

    public function deleteemployee(Request $request)
    {
        $id = $request->id;
        $emp = Employee::find($id);
        if(Storage::delete('public/images/'.$emp->avatar))
        {
            Employee::destroy($id);
        }
    }
}

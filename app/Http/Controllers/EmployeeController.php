<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Employee;
use DataTables;

class EmployeeController extends Controller
{
    public function dashboard(Request $request) {
        if ($request->ajax()) {
            $data = Employee::get();
            $user = auth()->user();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row) use ($user){
                    if($user->is_admin == 1) {
                        $btn = '<a href="javascript:delete_data('.$row->id.')" class="btn btn-danger m-1 btn-sm">Delete</a>';
                        $url = route('edit', $row->id);
                        $btn .= '<a href="'.$url.'" class="btn btn-primary btn-sm">Edit</a>';
                        return $btn;
                    } else {
                        return '--';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard');
    }

    public function delete(Request $request){
        try {
            $employee = Employee::findOrFail($request->id);
            if(!empty($employee)) {
                $employee->delete();
            }
            $status = true;
            $message = "Data deleted successfully.";
        } catch(\Exception $error){
            $status = false;
            $message = "Data not found!!.";
        }
        return array('status' => $status, 'message' => $message);
    }

    public function create() {
        return view('create');
    }

    public function edit($id) {
        $employee = Employee::find($id);
        return view('create', compact('employee'));
    }

    public function store(Request $request) {
        $id = $request->eid;
        $rules = [
            'name' => 'required',
            'number' => 'required',
            'designation' => 'required',
            'address' => 'required',
        ];
    
        if (!empty($id)) {
            $employee = Employee::find($id);
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore($employee->id),
            ];
        } else {
            $rules['email'] = 'required|email|unique:employees,email';
        }
    
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('create')->withErrors($validator)->withInput();
        }

        if(!empty($id)) {
            $employee = Employee::find($id);
        } else {
            $employee = new Employee;
        }

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->number = $request->number;
        $employee->designation = $request->designation;
        $employee->address = $request->address;
        $employee->save();

        return redirect('dashboard');
    }

    public function bulk_upload() {
        return view('bulk');
    }

    public function bulk_upload_store(Request $request) {
        $file_name = request()->file('csv_file');

        if(!empty($file_name))  {
            $get_original_name = time().'_'.$file_name->getClientOriginalName();

            $explode_file = explode(".", $get_original_name);
            $get_name = $explode_file[0];
            $get_ext = $explode_file[1];

            if($get_ext == 'csv') {
                $get_path = public_path().'/file_csv/';

                $file_name->move($get_path, $get_original_name);
                $location = $get_path . $get_original_name;
                if(!empty($location)) {
                    $file_open = fopen($location,"r");

                    while(!feof($file_open)) {
                        $rowData[] = fgetcsv($file_open);
                    }

                    $skip_count = 0;
                    $upload_count = 0;
                    $error_count = 0;

                    foreach ($rowData as $key => $value) {
                        if($key != 0){
                            if(!empty($value)){
                                $email = $value[1];
                                $name = $value[0];
                                $number = $value[2];
                                $designation = $value[3];
                                $address = $value[4];

                                if(!empty($email) && !empty($name) && !empty($number) && !empty($designation) && !empty($address)) {
                                    $check_unique = Employee::where('email', $email)->first();
                                    if(!empty($check_unique)) {
                                        $skip_count++;
                                    } else {
                                        $employee = new Employee;
                                        $employee->name = $name;
                                        $employee->email = $email;
                                        $employee->number = $number;
                                        $employee->designation = $designation;
                                        $employee->address = $address;
                                        $employee->save();
                                        $upload_count++;
                                    }
                                } else {
                                    $error_count++;
                                }
                            }
                        }
                    }
                    // echo $skip_count; exit();
                    if($skip_count == 0 && $error_count == 0) {
                        $message = "CSV file uploaded successfully. [Skiped Data = $skip_count, Uploaded Data = $upload_count, Errored Data = $error_count]";
                        return redirect('dashboard')->with('success', $message);
                    } else {
                        $message = "CSV file uploaded with Error. [Skiped Data = $skip_count, Uploaded Data = $upload_count, Errored Data = $error_count]";
                        return redirect('dashboard')->withErrors(['message' => $message]);
                    }
                }
            }
        }
        
    }
}

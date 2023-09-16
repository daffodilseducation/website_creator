<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ClientUser;
use App\ClientUserPassword;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\ProcessUsers;

class ClientUserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function clientUserList(Request $request) {
        $userId = Auth::user()->id;
        if (!empty($userId)) {
            $ClientUser = ClientUser::where('user_id', '=', $userId)->get();
        }
        return view('pages.client.index', compact('ClientUser'));
    }

    public function clientList(Request $request) {
        $ClientUser = User::where('role', '=', 'client')->get();
        return view('pages.client.list', compact('ClientUser'));
    }

    public function clientEdit(Request $request, $id) {
        $ClientUser = User::where('id', '=', $id)->first();
        return view('pages.client.edit', compact('ClientUser'));
    }

    public function postUpdateUser(Request $request) {
        $user_id = $request->get('user_id');
        $user_name = $request->get('user_name');
        $user_email = $request->get('user_email');
        $user_password = $request->get('user_password');
        $status = $request->get('status');
        if (!empty($user_password)) {
            User::updateOrCreate(
                    ['id' => $user_id],
                    ['name' => $user_name, 'email' => $user_email, 'password' => Hash::make($user_password), 'status' => $status]
            );
        } else {
            User::updateOrCreate(
                    ['id' => $user_id],
                    ['name' => $user_name, 'email' => $user_email, 'status' => $status]
            );
        }
        return redirect()->intended('client-list');
    }

    public function createUser(Request $request) {
        return view('pages.client.add');
    }

    public function createPostUser(Request $request) {
        $decreption_key = '3ff360b29079ceec22d47d27d905f96c8868d0353dc96de533f70dc73e30e38c';
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'decryption_key' => $decreption_key,
            'role' => 'client',
            'status' => $request->get('status')
        ]);
        return redirect()->intended('client-list');
    }

    public function bulkUpload(Request $request) {
        return view('pages.client.bulk-upload');
    }

    public function downloadSample(Request $request) {
        $row = array();
        $fileName = "UsersFileSample" . date("Y-m-d H:i:s") . ".csv";
        $headerArr[] = 's.no.';
        $headerArr[] = 'name';
        $headerArr[] = 'email';
        $headerArr[] = 'password';

        $columns = array(
            $headerArr,
            array(1, 'Aman', 'aman@nl.com', '12345')
        );
        $f = fopen('php://memory', 'w');
        // loop over the input array
        foreach ($columns as $line) {
            // generate csv lines from the inner arrays
            fputcsv($f, $line, ",");
        }
        // reset the file pointer to the start of the file
        fseek($f, 0);
        // tell the browser it's going to be a csv file
        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="' . $fileName . '";');
        // make php send the generated csv lines to the browser
        fpassthru($f);
    }

    public function importSheet(Request $request) {
        $userId = Auth::user()->id;
        ini_set('memory_limit', '10240M');
        ini_set('upload_max_filesize', '1024M');
        ini_set('upload_max_size', '1024M');
        ini_set('max_execution_time', '300');
        set_time_limit(240);
        $ifProcessed = 0;
        $partsCount = 0;
        $flag = 0;
        $filestatus = 'Error';
        $errorReports = array();
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $pendingFilesPath = public_path('pending_files/*.csv');
        $pendingFiles = glob($pendingFilesPath);
        foreach ($pendingFiles as $filepath) {
            unlink($filepath);
        }

        $file = file($request->file->getRealPath());
        $data = array_slice($file, 1);
        $parts = array_chunk($data, 500);
        //$count = count($data);
        
        /*ProcessUsers::dispatch($userId,$file,$parts);
        return view('pages.client.bulk-upload-ajax');*/
        
        foreach ($parts as $key => $part) {
            $fileName = public_path("pending_files/" . date("Y-m-d H:i:s") . $key . ".csv");
            file_put_contents($fileName, $part);
            $partsCount++;
        }

        $path = public_path('pending_files/*.csv');
        $g = glob($path);
        $rowNum = 2;
        foreach ($g as $file) {

            $data = array_map("str_getcsv", file($file));

            foreach ($data as $rowid => $row) {
                if ($this->getErrorReport($row, $rowNum))
                    $errorReports[] = $this->getErrorReport($row,$rowNum);


                if (count($errorReports)) {
                    $flag = 1;
                }

                if (!$errorReports) {
                    $userData = ClientUser::updateOrCreate([
                                "user_id" => $userId,
                                "email" => $row[2]
                                    ], [
                                "user_id" => $userId,
                                "name" => $row[1],
                                "email" => $row[2],
                                "password" => md5($row[3]),
                    ]);
                    if (!empty($userData['id'])) {
                        ClientUserPassword::updateOrCreate([
                            "client_user_id" => $userData['id'] 
                                ], [
                            "client_user_id" => $userData['id'] ,
                            "password" => $row[3],
                        ]);
                    }
                }
                $rowNum++;
            }

            unlink($file);
            if (!$flag)
                $ifProcessed++;
        }

        if ($partsCount == $ifProcessed) {
            $filestatus = "Processed";
        }

        if ($errorReports) {
            $htmlcode = '';
            foreach ($errorReports as $key => $value) {
                $htmlcode .= "<p>" . $value . "</p>";
            }
            return back()->with('error', $htmlcode);
        }
        return back()->with('success', 'File Imported Successfully');
    }

    public function getErrorReport($row, $rowNum) {
        $errorReport = '';
        /* if(!$row[1] ){
          $errorReport .="Missing username -";
          } */

        if (!$row[1]) {
            $errorReport .= "Missing Name Row Num : $rowNum";
        }
        if (!$row[2]) {
            $errorReport .= "Missing email Row Num : $rowNum";
        }
        if (!$row[3]) {
            $errorReport .= "Missing Password Row Num : $rowNum";
        }
        return $errorReport;
    }

}

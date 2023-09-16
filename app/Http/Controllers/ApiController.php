<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClientUser;
use App\User;
use App\UserLoginState;
use App\Helpers\MySettings;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller {

    private function getStatusCode($id) {
        $codes = Array(
            0 => array('code' => 100, 'message' => 'Success'),
            1 => array('code' => 101, 'message' => 'Failed.'),
            2 => array('code' => 102, 'message' => 'Invalid Password.'),
            3 => array('code' => 103, 'message' => 'User has been disabled by adminstrator.'),
            4 => array('code' => 104, 'message' => 'Invalid User.'),
            5 => array('code' => 105, 'message' => 'Invalid request.'),
            6 => array('code' => 106, 'message' => 'Something went wrong!!!'),
            7 => array('code' => 107, 'message' => 'Please enter your username and password.'),
            8 => array('code' => 108, 'message' => 'Invalid Access, Please login to access your account'),
            9 => array('code' => 201, 'message' => 'Batch does not exist/Empty Resultset'),
            10 => array('code' => 202, 'message' => 'Incorrect input data.'),
            11 => array('code' => 203, 'message' => 'Data Not Found.'),
            12 => array('code' => 204, 'message' => 'Old password not matched.'),
            13 => array('code' => 205, 'message' => 'Invalid content requested.'),
            14 => array('code' => 206, 'message' => 'Only PDF,PPT,PPTX,DOC,DOCX file is allowed, Please upload valid file.'),
            15 => array('code' => 207, 'message' => 'Only JPG,GIF,JPEG,PNG file is allowed, Please upload valid file.'),
            16 => array('code' => 203, 'message' => 'Assesment not started yet.')
        );
        return (isset($codes[$id])) ? $codes[$id] : '';
    }

    public function createClientUser(Request $request) {
        $outputArray['status'] = 0;
        $code = $this->getStatusCode(1);
        $password = $request->get('password');
        $allheaders = $request->headers->all();
        $secretKey = !empty($allheaders['secretkey'][0]) ? $allheaders['secretkey'][0] : '';
        $secretArr = explode('_', $secretKey);
        $userId = $secretArr[0];
        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => md5($password),
            'user_id' => $userId,
        ];
        $ClientUser = new ClientUser($data);
        $ClientUser->save();
        if (!empty($ClientUser)) {
            $outputArray['message'] = 'Client User Created Successfully!!';
            $code = $this->getStatusCode(0);
            $outputArray['status'] = 1;
        } else {
            $outputArray['message'] = 'Invalid email.';
            $code = $this->getStatusCode(1);
        }
        $outputArray['code'] = $code['code'];
        return response()->json($outputArray);
    }

    public function updateClientUser(Request $request) {
        $outputArray['status'] = 0;
        $code = $this->getStatusCode(1);
        $email = $request->get('email');
        $name = $request->get('name');
        $password = $request->get('password');
        $allheaders = $request->headers->all();
        $secretKey = !empty($allheaders['secretkey'][0]) ? $allheaders['secretkey'][0] : '';
        $secretArr = explode('_', $secretKey);
        $userId = $secretArr[0];
        $clientUser = ClientUser::where('email', '=', $email)->where('user_id', '=', $userId)->first();
        if (!empty($clientUser)) {
            ClientUser::updateOrCreate(
                    ['id' => $clientUser->id],
                    ['name' => $name, 'password' => md5($password)]
            );
            $outputArray['message'] = 'Updated sucessfully.';
            $code = $this->getStatusCode(0);
            $outputArray['status'] = 1;
        } else {
            $outputArray['message'] = 'Invalid email.';
            $code = $this->getStatusCode(1);
        }
        $outputArray['code'] = $code['code'];
        return response()->json($outputArray);
    }

    public function deleteClientUser(Request $request) {
        $outputArray['status'] = 0;
        $code = $this->getStatusCode(1);
        $email = $request->get('email');
        $allheaders = $request->headers->all();
        $secretKey = !empty($allheaders['secretkey'][0]) ? $allheaders['secretkey'][0] : '';
        $secretArr = explode('_', $secretKey);
        $userId = $secretArr[0];
        $clientUser = ClientUser::where('email', '=', $email)->where('user_id', '=', $userId)->first();
        if (!empty($clientUser)) {
            $clientUser = ClientUser::where('email', '=', $email)->first();
            $clientUser->delete();
            $outputArray['message'] = 'Deleted sucessfully.';
            $outputArray['status'] = 1;
            $code = $this->getStatusCode(0);
        } else {
            $outputArray['message'] = 'Invalid email.';
            $code = $this->getStatusCode(1);
        }
        $outputArray['code'] = $code['code'];
        return response()->json($outputArray);
    }

    public function loginStatus(Request $request) {
        $outputArray['status'] = 0;
        $code = $this->getStatusCode(1);
        $email = $request->get('email');
        $allheaders = $request->headers->all();
        $secretKey = !empty($allheaders['secretkey'][0]) ? $allheaders['secretkey'][0] : '';
        $secretArr = explode('_', $secretKey);
        $userId = $secretArr[0];
        $clientUser = ClientUser::where('email', '=', $email)->where('user_id', '=', $userId)->first();
        if (!empty($clientUser)) {
            $UserLoginState = UserLoginState::where('client_user_id', '=', $clientUser->id)->first();
            if (!empty($UserLoginState) && $UserLoginState->login_status == 'yes') {
                $outputArray['message'] = 'yes';
                $code = $this->getStatusCode(0);
                $outputArray['status'] = 1;
            } else {
                $outputArray['message'] = 'no';
                $code = $this->getStatusCode(1);
            }
        } else {
            $outputArray['message'] = 'no';
            $code = $this->getStatusCode(1);
        }

        $outputArray['code'] = $code['code'];
        return response()->json($outputArray);
    }

    public function createSecretKey(Request $request) {
        $outputArray['status'] = 0;
        $code = $this->getStatusCode(1);
        $password = $request->get('password');


        $domainId = $request->get('domain_id');
        $passphrase = $request->get('decryption_key');
        $secreteKey = MySettings::encryptToken($domainId, $passphrase);
        if (!empty($secreteKey)) {
            $outputArray['secretekey'] = $secreteKey;
            $code = $this->getStatusCode(1);
        } else {
            $outputArray['message'] = 'Invalid email.';
            $code = $this->getStatusCode(1);
        }
        $outputArray['code'] = $code['code'];
        return response()->json($outputArray);
    }

    public function logoutClient(Request $request) {
        $outputArray['status'] = 0;
        $code = $this->getStatusCode(1);
        $email = $request->get('email');
        //$secretKey = $request->get('secretkey');
        $allheaders = $request->headers->all();
        $secretKey = !empty($allheaders['secretkey'][0]) ? $allheaders['secretkey'][0] : "";
        $secretArr = explode('_', $secretKey);
        //echo "<pre>"; print_r($secretArr);exit;
        $userId = $secretArr[0];
        $clientUser = ClientUser::where('email', '=', $email)->where('user_id', '=', $userId)->first();
        $config = MySettings::secretHostByUserId($userId);

        if (!empty($clientUser)) {
            UserLoginState::updateOrCreate(
                    ['client_user_id' => $clientUser->id],
                    ['client_user_id' => $clientUser->id, 'login_status' => 'no']
            );
        }
        $response = [];
        $curl = curl_init();
        //$header = config('application.doselect_cred');
        foreach ($config as $domainData) {
            curl_setopt_array($curl, array(
                CURLOPT_URL => $domainData['logout_redirect_url'].'?email='.$email,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                    // CURLOPT_HTTPHEADER => $header,
                CURLOPT_HTTPHEADER => array(
                            'secretkey:'.$domainData['secret_key']
                        )
            ));
            $response = curl_exec($curl);
        }
        curl_close($curl);
        if (!empty($response)) {
            $outputArray['message'] = 'logout sucessfuly.';
            $code = $this->getStatusCode(0);
            $outputArray['status'] = 1;
        } else {
            $outputArray['message'] = 'Invalid email.';
            $code = $this->getStatusCode(1);
        }
        $outputArray['code'] = $code['code'];
        return response()->json($outputArray);
    }

}

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\JoyNotificationLog;
use DB;
use Config;
use App\UserDeviceToken;
use App\Helpers\MySettings;
use App\ClientUser;
use App\ClientUserPassword;

class ProcessUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 25;

    protected $user_id;
    protected $file;
    protected $parts;
    


    public function __construct($userId,$file,$parts)
    {   
        $this->user_id = $userId;
        $this->file = $file;
        $this->parts = $parts;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        $userToken=array();
        $userIds =[];

        Log::debug("users",array("users"=>$this->user_id,"datas"=>$this->file));

        $this->uploadUser($this->user_id,$this->file,$this->parts);

        //$this->insertLog($this->message,$this->type,$this->organization_id,$this->title,$this->id,$this->userIdContent,$userIds,$this->visibility);
    }


    public function insertLog($message,$type,$organization_id,$title,$id,$userId,$userIds,$visibility){

        $userIdList = $visibility == 2 ? implode(',', $userIds) : '';
      
        $data =[
            "content_id" =>$id,
            "user_id" =>$userId,
            "organization_id" => $organization_id,
            "status" => 1,
            "message" =>$message,
            "title" =>$title,
            "device_token" =>"test",
            "device_type" =>"test",
            "type" => $type,
            "group_users" =>$userIdList
        ];


        $response = new JoyNotificationLog($data);
        $response->save();
    }

    public function uploadUser($userId,$file,$parts) {
        $ifProcessed = 0;
        $partsCount = 0;
        $flag = 0;
        $filestatus = 'Error';
        $errorReports = array();
        
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

<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Validator;
use App\Mails;
use App\MailDetails;
use App\Libs\LogFile;

class MailController extends Controller
{

    public function create(Request $request) {
        LogFile::writeLog('create-Email', json_encode($request->all()));
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse(self::ERROR_BAD_REQUEST, [], self::getErrorMessage(self::ERROR_BAD_REQUEST));
        }
        $code = str_random(3).'-'.str_random(3);
        $mail = new Mails;
        $mail->code = $code;
        $mail->save();
        
        $mailDetail = new MailDetails;
        $mail->code = $code;
        $mail->save();
        return $this->successResponse([], "Create mail successfully");
    }

    public function createTemplate(Request $request) {
        LogFile::writeLog('create-mail-template', json_encode($request->all()));
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'template' => 'required|string',
            'language' =>  'required|string'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse(self::ERROR_BAD_REQUEST, [], self::getErrorMessage(self::ERROR_BAD_REQUEST));
        }
        $code = str_random(3).'-'.str_random(3);
        $mail = new Mails;
        $mail->code = $code;
        $mail->save();
        
        $mailDetail = new MailDetails;
        $mail->code = $code;
        $mail->save();
        return $this->successResponse([], "Create mail successfully");
    }

    public function createRequest(Request $request) {
        LogFile::writeLog('create-email-request', json_encode($request->all()));
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'data' => 'required|string',
            'language' =>  'required|string',
            'code' =>  'required|string'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse(self::ERROR_BAD_REQUEST, [], self::getErrorMessage(self::ERROR_BAD_REQUEST));
        }

    }
    
    
}



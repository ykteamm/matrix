<?php 

namespace App\Interfaces\Repositories;

interface SMSRepository {
  public function getToken();
  public function sendSMS($phone, $msg);
}
<?php

namespace App\Interfaces\Repositories;

interface HelperRepository {
  public function setDetail($price, $izoh, $user_id, $message, $status = 2);
}
<?php

namespace App\Interfaces\Repositories;

interface ShiftRepository
{
  public function unchecked($column = 'admin_check', $active = 1);
  public function history($date, $column, $active);
  public function update($shift_id, $values);
  public function updateAdminCheck($shift_id, $error, $column = 'admin_check');
  public function delete($shift_id);
}

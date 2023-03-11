<?php

namespace App\Interfaces\Repositories;

interface ShiftRepository
{
  public function unchecked($column = 'admin_check', $active = 1);
  public function checked($date, &$paginated, $column = 'admin_check', $active = 1);
  public function update($shift_id, $msg, $column = 'admin_check');
  public function delete($shift_id);
}

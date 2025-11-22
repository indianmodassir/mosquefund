<?php

namespace Modassir\Http\Model;
use Modassir\Model\Model;

class MemberModal extends Model
{
  /**
   * Targeted Table
   */
  protected $table = 'member';

  /**
   * Primary Key Column Name
   */
  protected $primaryKey = 'owner_id';
}
?>
<?php

namespace Modassir\Http\Model;
use Modassir\Model\Model;

class RequestModal extends Model
{
  /**
   * Targeted Table
   */
  protected $table = 'request';

  /**
   * Primary Key Column Name
   */
  protected $primaryKey = 'email';
}
?>
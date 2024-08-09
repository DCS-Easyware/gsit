<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
  protected $table = 'glpi_logs';
  // protected $definition = '\App\Models\Definitions\Log';
  protected $titles = ['Historical', 'Historical'];
  protected $icon = 'history';

  const CREATED_AT = null;
  const UPDATED_AT = 'date_mod';

  protected $appends = [
  ];

  protected $visible = [
  ];

  protected $with = [
  ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
  use SoftDeletes;

  // protected $definition = '\App\Models\Definitions\Log';
  protected $titles = ['Historical', 'Historical'];
  protected $icon = 'history';

  public const CREATED_AT = null;

  protected $appends = [
  ];

  protected $visible = [
  ];

  protected $with = [
  ];
}

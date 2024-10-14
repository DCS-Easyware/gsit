<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\User';
  protected $titles = ['User', 'Users'];
  protected $icon = 'user';

  protected $appends = [
    // 'category',
    // 'title',
    // 'location',
    // 'entity',
    // 'profile',
    // 'supervisor',
    // 'group',
    'completename',
  ];

  protected $visible = [
    'category',
    'title',
    'location',
    'entity',
    'profile',
    'supervisor',
    'group',
    'completename',
  ];

  protected $with = [
    'category:id,name',
    'title:id,name',
    'location:id,name',
    'entity:id,name',
    'profile:id,name',
    'supervisor:id,name',
    'group:id,name',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Usercategory');
  }

  public function title(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Usertitle');
  }

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location');
  }

  public function entity(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Entity');
  }

  public function profile(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Profile');
  }

  public function supervisor(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'user_id_supervisor');
  }

  public function group(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group');
  }

  public function getCompletenameAttribute()
  {
    if ($this->id == 0)
    {
      return 'Nobody';
    }

    $name = '';
    if (
        (!is_null($this->lastname) && !empty($this->lastname)) ||
        (!is_null($this->firstname) && !empty($this->firstname))
    )
    {
      $names = [];
      if (!is_null($this->firstname))
      {
        $names[] = $this->firstname;
      }
      if (!is_null($this->lastname))
      {
        $names[] = $this->lastname;
      }
      $name = implode(' ', $names);
    } else {
      $name = $this->name;
    }
    return $name;
  }
}

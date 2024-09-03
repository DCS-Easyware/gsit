<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Common
{
  protected $table = 'glpi_users';
  protected $definition = '\App\Models\Definitions\User';
  protected $titles = ['User', 'Users'];
  protected $icon = 'user';

  protected $appends = [
    'category',
    'title',
    'location',
    'entity',
    'profile',
    'supervisor',
    'group',
  ];

  protected $visible = [
    'category',
    'title',
    'location',
    'entity',
    'profile',
    'supervisor',
    'group',
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
    return $this->belongsTo('\App\Models\UserCategory', 'usercategories_id');
  }

  public function title(): BelongsTo
  {
    return $this->belongsTo('\App\Models\UserTitle', 'usertitles_id');
  }

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location', 'locations_id');
  }

  public function entity(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Entity', 'entities_id');
  }

  public function profile(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Profile', 'profiles_id');
  }

  public function supervisor(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id_supervisor');
  }

  public function group(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id');
  }

  protected $appends = [
    'completename',
  ];

  protected $visible = [
    'completename',
  ];

  public function getCompletenameAttribute()
  {
    if ($this->id == 0)
    {
      return 'Nobody';
    }

    $name = '';
    if (!is_null($this->realname) || !is_null($this->firstname))
    {
      $names = [];
      if (!is_null($this->firstname))
      {
        $names[] = $this->firstname;
      }
      if (!is_null($this->realname))
      {
        $names[] = $this->realname;
      }
      $name = implode(' ', $names);
    } else {
      $name = $this->name;
    }
    return $name;
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;

class Computer extends Common
{
  use PivotEventTrait;

  protected $definition = '\App\Models\Definitions\Computer';
  protected $titles = ['Computer', 'Computers'];
  protected $icon = 'laptop';

  protected $appends = [
    // 'type',
    // 'model',
    // 'state',
    // 'manufacturer',
    // 'network',
    // 'groupstech',
    // 'userstech',
    // 'user',
    // 'group',
    // 'location',
    // 'autoupdatesystem',
  ];

  protected $visible = [
    'type',
    'model',
    'state',
    'manufacturer',
    'network',
    'groupstech',
    'userstech',
    'user',
    'group',
    'location',
    'autoupdatesystem',
  ];

  protected $with = [
    'type:id,name',
    'model:id,name',
    'state:id,name',
    'manufacturer:id,name',
    'network:id,name',
    'groupstech:id,name',
    'userstech:id,name',
    'user:id,name',
    'group:id,name',
    'location:id,name',
    'autoupdatesystem:id,name',
    'softwareversions:id,name',
    'operatingsystems:id,name',
  ];

  public static function boot()
  {
    parent::boot();

    static::pivotAttached(function ($model, $relationName, $pivotIds, $pivotIdsAttributes)
    {
      if ($relationName == 'softwareversions')
      {
        $softwareversions = \App\Models\Softwareversion::with('software:name')->whereIn('id', $pivotIds)->get();
        foreach($softwareversions as $softwareversion)
        {
          $software = $softwareversion->software()->first();
          \App\v1\Controllers\Log::addEntry(
            $model,
            'version ' . $softwareversion->name . ' of software ' . $software->name . ' installed',
            $softwareversion->name . ' (' . $softwareversion->id . ')',
          );
        }
      }
    });
  }


  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Computertype');
  }

  public function model(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Computermodel');
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State');
  }

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer');
  }

  public function network(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Network');
  }

  public function groupstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'group_id_tech');
  }

  public function userstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'user_id_tech');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User');
  }

  public function group(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group');
  }

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location');
  }

  public function autoupdatesystem(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Autoupdatesystem');
  }

  public function softwareversions(): MorphToMany
  {
    return $this->morphToMany('\App\Models\Softwareversion', 'item', 'item_softwareversion');
  }

  public function operatingsystems(): MorphToMany
  {
    return $this->morphToMany(
      '\App\Models\Operatingsystem',
      'item',
      'item_operatingsystem'
    )->withPivot(
      'operatingsystemversion_id',
      'operatingsystemservicepack_id',
      'operatingsystemarchitecture_id',
      'operatingsystemkernelversion_id',
      'operatingsystemedition_id',
      'license_number',
      'licenseid',
      'installationdate',
      'winowner',
      'wincompany',
      'oscomment',
      'hostid'
    );
  }

  public function antiviruses(): HasMany
  {
    return $this->hasMany('App\Models\Computerantivirus');
  }
}

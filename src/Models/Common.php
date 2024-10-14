<?php

namespace App\Models;

use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Common extends Model
{
  use PivotEventTrait;

  protected $definition = null;
  protected $titles = ['not defined', 'not defined'];
  protected $icon = '';
  protected $table = null;

  // public const CREATED_AT = 'date_creation';
  // public const UPDATED_AT = 'date_mod';

  public static function booted()
  {
    parent::booted();

    static::updated(function ($model)
    {
      if (get_class($model) != 'App\Models\Log')
      {
        $model->changesOnUpdated();
      }
    });

    static::pivotAttached(function ($model, $relationName, $pivotIds, $pivotIdsAttributes)
    {
      $model->changesOnPivotUpdated($relationName, $pivotIds, 'add');
    });

    static::pivotDetached(function ($model, $relationName, $pivotIds)
    {
      $model->changesOnPivotUpdated($relationName, $pivotIds, 'delete');
    });
  }

  public function getTitle($nb = 1)
  {
    global $translator;

    return $translator->translatePlural($this->titles[0], $this->titles[1], $nb);
  }

  public function getIcon()
  {
    return $this->icon;
  }

  public function getNameFromID($id)
  {
    return $id;
    $items = $this->find(['id' => $id], [], 1);
    if (count($items) == 0)
    {
      return '';
    } else {
      return current($items)['name'];
    }
  }


  // function getTable()
  // {
  //   return $this->table;
  // }

  // function loadId($id)
  // {
  //   $load = $this->getFromDB($id);
  //   if ($load === false)
  //   {
  //     throw new \Exception("This item has not found", 404);
  //   }
  // }

  public function getDropdownValues()
  {
    $items = $this->orderBy('name')->get()->take(50);
    $data = [];
    foreach ($items as $item)
    {
      $data[] = [
        "name"  => '[' . $item->id . ']' . $item->name,
        "value" => $item->id
      ];
    }
    return $data;
  }

  public function getDefinitions()
  {
    if (is_null($this->definition))
    {
      return [];
    }
    return call_user_func($this->definition . '::getDefinition');
  }

  public function getRelatedPages($rootUrl)
  {
    if (is_null($this->definition) || !method_exists($this->definition, 'getRelatedPages'))
    {
      return [];
    }
    return call_user_func($this->definition . '::getRelatedPages', $rootUrl);
  }

  public function getSpecificFunction($functionName)
  {
    if (is_null($this->definition) || !method_exists($this->definition, $functionName))
    {
      return [];
    }
    return call_user_func($this->definition . '::' . $functionName);
  }

  /**
   * Get form data for this item
   *
   * @return array
   */
  public function getFormData($myItem, $otherDefs=false)
  {
    $def = $this->getDefinitions();
    if ($otherDefs !== false) $def = $otherDefs;

    foreach ($def as &$field)
    {
      if ($field['type'] == 'dropdown_remote')
      {
        if (is_null($myItem->{$field['name']}) || $myItem->{$field['name']} == false)
        {
          $field['value'] = 0;
          $field['valuename'] = '';
        }
        elseif (isset($field['multiple']))
        {
          // if ($field['name'] == 'requester')
          // {
          // print_r($myItem->{$field['name']});
          // }
          // TODO manage multiple select
          $values = [];
          $valuenames = [];
          foreach ($myItem->{$field['name']} as $val)
          {
            $values[] = $val->id;
            $valuenames[] = $val->name;
          }
          $field['value'] = implode(',', $values);
          $field['valuename'] = implode(',', $valuenames);
        } else {
          // var_dump($field['name']);                   // #EB
          // var_dump($myItem->{$field['name']}->id);    // #EB

          $field['value'] = $myItem->{$field['name']}->id;
          $field['valuename'] = $myItem->{$field['name']}->name;
        }
      } elseif ($field['type'] == 'textarea')
      {
        if (is_null($myItem->{$field['name']}))
        {
          $field['value'] = '';
        } else {
          // We convert html to markdown
          $field['value'] = \App\v1\Controllers\Toolbox::convertHtmlToMarkdown($myItem->{$field['name']});
        }
      } else {
        $field['value'] = $myItem->{$field['name']};
      }
      if (isset($field['readonly']))
      {
        $field['readonly'] = 'readonly';
      }
    }
    return $def;
  }


  /**
   * Add in changes when update fields
   */
  public function changesOnUpdated()
  {
    $changes = $this->getChanges();
    $casts = $this->getCasts();
    foreach ($changes as $key => $newValue)
    {
      if (in_array($key, ['created_at', 'updated_at']))
      {
        continue;
      }
      $oldValue = $this->original[$key];
      if (isset($casts[$key]) && $casts[$key] == 'boolean')
      {
        $newValue = (boolval($newValue) ? 'true' : 'false');
        $oldValue = (boolval($oldValue) ? 'true' : 'false');
      }
      // TODO for textarea
      if (strlen($newValue) >= 255 || strlen($oldValue) >= 255)
      {
        return;
      }

      // get the id_search_option
      $definitions = $this->getDefinitions();
      $idSearchOption = 0;
      foreach ($definitions as $definition)
      {
        if ($definition['name'] == $key)
        {
          $idSearchOption = $definition['id'];
          break;
        }
      }

      \App\v1\Controllers\Log::addEntry(
        $this,
        '{username} changed ' . $key . ' to "{new_value}"',
        $newValue,
        $oldValue,
        $idSearchOption,
      );
    }
  }

  /**
   * Add in changes when update fields
   * @param $name string  name of the field (=name in definition)
   */
  public function changesOnPivotUpdated($name, $pivotIds, $type = 'add')
  {
    return;
    // get the id_search_option
    $definitions = $this->getDefinitions();
    $idSearchOption = 0;
    $title = '';
    $item = new stdClass();
    foreach ($definitions as $definition)
    {
      if ($definition['name'] == $name)
      {
        $idSearchOption = $definition['id'];
        $title = $definition['title'];
        $item = new $definition['itemtype']();
        break;
      }
    }
    if ($type == 'add')
    {
      foreach ($pivotIds as $id)
      {
        $myItem = $item->find($id);
        \App\v1\Controllers\Log::addEntry(
          $this,
          '{username} Add ' . $title . ' to "{new_value}"',
          $myItem->name,
          null,
          $idSearchOption,
        );
      }
    }
    if ($type == 'delete')
    {
      foreach ($pivotIds as $id)
      {
        $myItem = $item->find($id);
        \App\v1\Controllers\Log::addEntry(
          $this,
          '{username} delete ' . $title . ' to "{new_value}"',
          null,
          $myItem->name,
          $idSearchOption,
        );
      }
    }
  }
}

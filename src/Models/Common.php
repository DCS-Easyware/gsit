<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use League\HTMLToMarkdown\HtmlConverter;

class Common extends Model
{
  protected $definition = null;
  protected $titles = ['not defined', 'not defined'];
  protected $icon = '';
  protected $table = null;

  const CREATED_AT = 'date_creation';
  const UPDATED_AT = 'date_mod';

  public static function booted()
  {
    parent::booted();

    static::updated(function ($model)
    {
      \App\Models\Common::changesOnUpdated($model, $model->original);
    });    
  }

  function getTitle($nb = 1)
  {
    global $translator;

    return $translator->translatePlural($this->titles[0], $this->titles[1], $nb);
  }

  function getIcon()
  {
    return $this->icon;
  }

  function getNameFromID($id)
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

  function getDropdownValues()
  {
    $items = $this->orderBy('name')->get();
    $data = [];
    foreach ($items as $item)
    {
      $data[] = [
        "name"  => $item->name,
        "value" => $item->id
      ];
    }
    return $data;
  }

  function getDefinitions()
  {
    if (is_null($this->definition))
    {
      return [];
    }
    return call_user_func($this->definition . '::getDefinition');
  }

  function getRelatedPages($rootUrl)
  {
    if (is_null($this->definition) || !method_exists($this->definition, 'getRelatedPages'))
    {
      return [];
    }
    return call_user_func($this->definition . '::getRelatedPages', $rootUrl);
  }

  /**
   * Get form data for this item
   *
   * @return array
   */
  function getFormData($myItem)
  {
    $converter = new HtmlConverter();
    $converter->getConfig()->setOption('strip_tags', true);

    $def = $this->getDefinitions();
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
          // if ($field['name'] == 'requester'){
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
          $field['value'] = $myItem->{$field['name']}->id;
          $field['valuename'] = $myItem->{$field['name']}->name;
        }
      }
      elseif ($field['type'] == 'textarea')
      {
        if (is_null($myItem->{$field['name']}))
        {
          $field['value'] = '';
        } else {
          // We convert html to markdown
          $field['value'] = $converter->convert(html_entity_decode($myItem->{$field['name']}));
        }
      } else {
        $field['value'] = $myItem->{$field['name']};
      }
    }
    return $def;
  }


  /**
   * Add in changes when update fields
   */
  public static function changesOnUpdated($model, $original)
  {
    $changes = $model->getChanges();
    $casts = $model->getCasts();
    foreach ($changes as $key => $newValue)
    {
      if (in_array($key, ['created_at', 'date_mod']))
      {
        continue;
      }
      $oldValue = $original[$key];
      if (isset($casts[$key]) && $casts[$key] == 'boolean')
      {
        $newValue = (boolval($newValue) ? 'true' : 'false');
        $oldValue = (boolval($oldValue) ? 'true' : 'false');
      }

      // TODO for textarea
      if (count_chars($newValue) >= 255 || count_chars($oldValue) >= 255)
      {
        return;
      }

      \App\Controllers\Log::addEntry(
        $model,
        '{username} changed ' . $key . ' to "{new_value}"',
        $newValue,
        $oldValue,
      );
    }
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

  /**
   * Retrieve an item from the database
   *
   * @param integer $ID ID of the item to get
   *
   * @return boolean true if succeed else false
  **/
  // function getFromDB($ID) {
  //   global $DB;
  //   // Make new database object and fill variables

  //   // != 0 because 0 is consider as empty
  //   if (strlen($ID) == 0) {
  //      return false;
  //   }

  //   $iterator = $DB->request([
  //     'FROM'   => $this->getTable(),
  //     'WHERE'  => [
  //       $this->getTable() . '.id' => \App\Controllers\Toolbox::cleanInteger($ID)
  //     ],
  //     'LIMIT'  => 1
  //   ]);

  //   if (count($iterator) == 1) {
  //     $this->fields = $iterator->next();
  //     // $this->post_getFromDB();
  //     return true;
  //   } else if (count($iterator) > 1) {
  //     Toolbox::logWarning(
  //       sprintf(
  //         'getFromDB expects to get one result, %1$s found!',
  //         count($iterator)
  //       )
  //     );
  //   }
  //   return false;
  // }

  /**
   * Retrieve all items from the database
   *
   * @param array        $condition condition used to search if needed (empty get all) (default '')
   * @param array|string $order     order field if needed (default '')
   * @param integer      $limit     limit retrieved data if needed (default '')
   *
   * @return array all retrieved data in a associative array by id
   **/
  // function find($condition = [], $order = [], $limit = 0, $start = 0, $fields = [], $leftjoin = [])
  // {
  //   global $DB;

  //   $criteria = [
  //     'FROM'   => $this->getTable()
  //   ];

  //   if (count($fields))
  //   {
  //     $criteria['SELECT'] = $fields;
  //   }

  //   if (count($condition))
  //   {
  //     $criteria['WHERE'] = $condition;
  //   }

  //   if (!is_array($order))
  //   {
  //     $order = [$order];
  //   }
  //   if (count($order)) {
  //     $criteria['ORDERBY'] = $order;
  //   }

  //   if ((int)$start > 0)
  //   {
  //     $criteria['START'] = $start;
  //   }

  //   if ((int)$limit > 0)
  //   {
  //     $criteria['LIMIT'] = $limit;
  //   }

  //   if (count($leftjoin) > 0)
  //   {
  //     $criteria['LEFT JOIN'] = $leftjoin;
  //   }

  //   // $criteria['LEFT JOIN'] = [
  //   //   'glpi_tickets_users' => [
  //   //     'FKEY' => [
  //   //       'glpi_tickets'       => 'id',
  //   //       'glpi_tickets_users' => 'tickets_id',
  //   //       ['and' => ['glpi_tickets_users.type' => '1']]
  //   //     ],
  //   //   ],
  //   //   'glpi_users' => [
  //   //     'FKEY' => [
  //   //       'glpi_tickets_users' => 'users_id',
  //   //       'glpi_users'         => 'id',
  //   //     ],
  //   //   ]
  //   // ];

  //   $data = [];
  //   $iterator = $DB->request($criteria);
  //   while ($line = $iterator->next())
  //   {
  //     $data[$line['id']] = $line;
  //   }
  //   return $data;
  // }

  // function count($condition = [])
  // {
  //   global $DB;

  //   $criteria = [
  //     'SELECT' => 'id',
  //     'FROM'   => $this->getTable(),
  //     'COUNT'  => 'cpt',
  //   ];

  //   if (count($condition))
  //   {
  //     $criteria['WHERE'] = $condition;
  //   }

  //   $iterator = $DB->request($criteria);
  //   $line = $iterator->next();
  //   return $line['cpt'];
  // }


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

  function getRelatedPages()
  {
    if (is_null($this->definition) || !method_exists($this->definition, 'getRelatedPages'))
    {
      return [];
    }
    return call_user_func($this->definition . '::getRelatedPages');
  }

  /**
   * Get form data for this item
   *
   * @return array
   */
  function getFormData($myItem)
  {
    $def = $this->getDefinitions();
    foreach ($def as &$field)
    {
      if ($field['type'] == 'dropdown_remote')
      {
        if (is_null($myItem->{$field['name']}))
        {
          $field['value'] = 0;
          $field['valuename'] = '';
        }
        else if (isset($field['multiple']))
        {
          // TODO manage multiple select
          $field['value'] = 0;
          $field['valuename'] = '';
        } else {
          $field['value'] = $myItem->{$field['name']}->id;
          $field['valuename'] = $myItem->{$field['name']}->name;
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
      \App\Controllers\Log::addEntry(
        $model,
        '{username} changed ' . $key . ' to "{new_value}"',
        $newValue,
        $oldValue,
      );
    }
  }
}

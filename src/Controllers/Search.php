<?php

namespace App\Controllers;

final class Search extends Common
{

  public function getData($item, $uri, $page = 1, $filters = [])
  {
    $itemtype = get_class($item);
    $spl_itemtype = explode('\\', $itemtype);
    $prefs = \App\Models\DisplayPreference::getForTypeUser(end($spl_itemtype), 4);
    $itemDef = $item->getDefinitions();
    $where = $this->manageFilters($itemDef, $filters);
    // columns
    $newItemDef = [];
    foreach ($itemDef as $field)
    {
      if (in_array($field['id'], $prefs))
      {
        $newItemDef[] = $field;
      }
    }

    $fields   = $this->manageFields($item, $itemDef, $prefs);
    $leftjoin = $this->manageJoins($item, $itemDef, $prefs);

    // ];
    // pagination
    $start = 0;
    $limit = 15;
    $start = ($page - 1) * $limit;

    $itemDbData = $item->find($where, [], $limit, $start, $fields, $leftjoin);
    $itemDbData = $this->getDropdownValue($newItemDef, $itemDbData, $uri);

    // TODO paging
    $cnt = $item->count([]);
    $itemDbData['paging'] = [
      'total'   => $cnt,
      'pages'   => ceil($cnt / $limit),
      'current' => $page,
      'linkpage' => $uri . '?page=',
    ];
    return $itemDbData;
  }

  function getDropdownValue($itemDef, $data, $uri)
  {
    $header = ['id'];
    foreach ($itemDef as $field)
    {
      $header[] = $field['title'];
      if ($field['type'] == 'dropdown_remote')
      {
        // get all ids for this field
        $ids = [];
        foreach ($data as &$item)
        {
          foreach ($item as $name=>$value)
          {
            if ($name == $field['name'])
            {
              if (!in_array($value, $ids))
              {
                $ids[] = $value;
              }
            }
          }
        }
        $values = $this->getItemdata($field['itemtype'], $ids);
        foreach ($data as &$item)
        {
          foreach ($item as $name=>$value)
          {
            if ($name == $field['name'])
            {
              if ($value == 0)
              {
                $item[$name] = '';
              } else {
                $item[$name] = $values[$value]['name'];
              }
            }
          }
        }
      }
      else if ($field['type'] == 'dropdown' && isset($field['values']))
      {
        foreach ($data as &$item)
        {
          foreach ($item as $name=>$value)
          {
            if ($name == $field['name'])
            {
              if ($value == 0)
              {
                $item[$name] = '';
              } else {
                $item[$name] = $field['values'][$value];
              }
            }
          }
        }
      }
    }

    // reorder array of data
    $orderedData = [];
    foreach ($data as &$item)
    {
      $newItem = [
        [
          'value' => $item['id'],
          'link'  => $uri . '/' . $item['id'],
        ],
      ];
      foreach ($itemDef as $field)
      {
        if (!isset($item[$field['name']]))
        {
          $newItem[] = [
            'value' => '',
          ];
        } else {
          $newItem[] = [
            'value' => $item[$field['name']],
          ];
        }
      }
      $orderedData[] = $newItem;
    }

    return [
      'header' => $header,
      'data'   => $orderedData,
      'allFields' => $itemDef,
    ];
  }

  function getItemdata($className, $ids)
  {
    if (count($ids) == 0)
    {
      return [];
    }
    $item = new $className();
    return $item->find(['id' => $ids]);
  }

  function manageFilters($itemDef, $params)
  {
    if (isset($params['field']) && is_numeric($params['field']))
    {
      foreach ($itemDef as $field)
      {
        if ($field['id'] == $params['field'])
        {
          if ($field['type'] == 'dropdown_remote')
          {
            return [$field['name'] => $params['value']];
          } else {
            return [$field['name'] => ['LIKE', '%' . $params['value'] . '%']];
          }
        }
      }
    }
    return [];
  }

  function manageFields($item, $itemDef, $prefs)
  {
    $fields = [$item->getTable() . '.id as id'];
    foreach ($itemDef as $field)
    {
      if ($field['name'] == 'name')
      {
        $fields[] = $item->getTable() . '.' . $field['name'] . ' as ' . $field['name'];
        continue;
      }

      if (in_array($field['id'], $prefs))
      {
        if (isset($field['relationship']) && $field['relationship'] == 'many-to-many')
        {
          $itemJoin = new $field['pivotitemtype']();
          $fields[] = $itemJoin->getTable() . '.' . $field['foreignkey'] . ' as ' . $field['name'];
        } else {
          $fields[] = $item->getTable() . '.' . $field['name'] . ' as ' . $field['name'];
        }
      }
    }
    return $fields;
  }

  function manageJoins($item, $itemDef, $prefs)
  {
    $joins = [];
    foreach ($itemDef as $field)
    {
      if (in_array($field['id'], $prefs) &&
        isset($field['relationship']) &&
        $field['relationship'] == 'many-to-many'
      )
      {
        $itemJoin = new $field['pivotitemtype']();
        $tableJoin = $itemJoin->getTable();
        $joins[$tableJoin] = [
          'FKEY' => [
            $item->getTable() => 'id',
            $tableJoin => 'tickets_id',
          ],
        ];
        if (isset($field['pivotfilters']))
        {
          foreach ($field['pivotfilters'] as $key=>$value)
          {
            $joins[$tableJoin]['FKEY'][] = [
              'and' => [
                $tableJoin . '.' . $key => $value,
              ]
            ];
          }
        }
      }
    }
    print_r($joins);
    return $joins;
  }
}

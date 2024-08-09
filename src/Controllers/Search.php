<?php

namespace App\Controllers;

final class Search extends Common
{
  public function getData($item, $uri, $page = 1, $filters = [])
  {
    $itemtype = get_class($item);
    $spl_itemtype = explode('\\', $itemtype);
    $prefs = \App\Models\Displaypreference::getForTypeUser(end($spl_itemtype), 4);
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

    $start = 0;
    $limit = 15;
    $start = ($page - 1) * $limit;

    // Apply filters
    foreach ($where as $key => $value)
    {
      if (is_array($value))
      {
        $item = $item->where($key, $value[0], $value[1]);
      } else {
        $item = $item->where($key, $value);
      }
    }

    $cnt = $item->count();
    $items = $item->offset($start)->take($limit)->get();
    $itemDbData = $this->prepareValues($newItemDef, $items, $uri);

    $itemDbData['paging'] = [
      'total'   => $cnt,
      'pages'   => ceil($cnt / $limit),
      'current' => $page,
      'linkpage' => $uri . '?page=',
    ];
    return $itemDbData;
  }

  private function prepareValues($itemDef, $data, $uri)
  {
    $header = ['id'];
    foreach ($itemDef as $field)
    {
      $header[] = $field['title'];
    }

    $allData = [];
    foreach ($data as $item)
    {
      $myData = [];
      $myData['id'] = [
        'value' => $item->id,
        'link'  => $uri . '/' . $item['id'],
      ];

      foreach ($itemDef as $field)
      {
        if ($field['type'] == 'dropdown_remote')
        {
          if (is_null($item->{$field['name']}) || empty($item->{$field['name']}))
          {
            $myData[$field['name']] = [
              'value' => '',
            ];
          } else {
            if (isset($field['count']))
            {
              $elements = [];
              foreach ($item->{$field['name']} as $t)
              {
                $elements[] = $t->{$field['count']};
              }
              $myData[$field['name']] = [
                'value' => array_sum($elements),
              ];
            }
            elseif (isset($field['multiple']))
            {
              $elements = [];
              foreach ($item->{$field['name']} as $t)
              {
                $elements[] = $t->name;
              }
              $myData[$field['name']] = [
                'value' => implode(', ', $elements),
              ];
            } else {
              $myData[$field['name']] = [
                'value' => $item->{$field['name']}->name,
              ];
            }
          }
        } elseif ($field['type'] == 'dropdown')
        {
          $myData[$field['name']] = [
            'value' => $field['values'][$item->{$field['name']}],
          ];
        } else {
          $myData[$field['name']] = [
            'value' => $item->{$field['name']},
          ];
        }
      }
      $allData[] = $myData;
    }

    return [
      'header' => $header,
      'data'   => $allData,
      'allFields' => $itemDef,
    ];
  }

  private function manageFilters($itemDef, $params)
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
}

<div class="ui blue dividing header">
  <i class="big <?=$headers['icon']?> icon"></i>
  <div class="content">
    <?=$headers['title']?>
    <div class="sub header"><?=$fields['paging']['total']?> items</div>
  </div>
</div>

<div class="ui secondary segment">
  <form class="ui form">
    <div class="thread fields">
      <div class="field">
        <div class="ui selection dropdown searchfield" style="min-width: 220px;">
          <input type="hidden" name="field">
          <i class="dropdown icon"></i>
          <div class="default text">Select a field to search</div>
          <div class="scrollhint menu">
            <?php foreach ($definition as $field): ?>
              <div
                class="item"
                data-type="<?=$field['type']?>"
                data-itemtype="<?=isset($field['itemtype'])? $field['itemtype']:''?>"
                data-value="<?=$field['id']?>"
              ><?=$field['title']?></div>
            <?php endforeach ?>
          </div>
        </div>
      </div>
      <div class="field">
        <!-- Disable by default [input] -->
        <div class="ui input" hidden id="search-input">
          <input type="text" placeholder="value...">
        </div>
        <!-- Disable by default [dropdown remote] -->
        <div
          class="ui selection dropdown remotedropdown"
          hidden
          id="search-dropdown"
          data-url="dropdown"
          data-itemtype=""
        >
          <input type="hidden" placeholder="value...">
          <div class="default text">my test dropdown</div>
          <div class="menu">
          </div>
        </div>
      </div>
      <div class="field">
        <button class="ui primary button" type="submit">Search</button>
      </div>
    </div>
  </form>
</div>

<table class="ui sortable celled striped blue table">
  <thead>
    <th></th>
    <?php foreach ($fields['header'] as $title): ?>
      <th><?=$title?></th>
    <?php endforeach ?>
  </tr></thead>
  <tbody>
  <?php foreach ($fields['data'] as $item): ?>
    <tr>
      <td class="collapsing">
        <div class="ui fitted mini toggle checkbox">
          <input type="checkbox"> <label></label>
        </div>
      </td>
      <?php foreach ($item as $value): ?>
        <?php if (isset($value['link'])): ?>
          <td><a href="<?=$value['link']?>"><?=$value['value']?></a></td>
        <?php endif ?>
        <?php if (!isset($value['link'])): ?>
          <?php if (is_array($value['value'])): ?>
            <td class="left <?php if (isset($value['value']['color'])):
                echo $value['value']['color'] . " ";
              endif;
              if (isset($value['value']['displaystyle'])):
                echo $value['value']['displaystyle'];
              endif ?>"
            >
            <?php if (isset($value['value']['color'])): ?>
              <span class="ui <?=$value['value']['color']?> text">
                <?php if (isset($value['value']['icon'])): ?>
                  <i class="<?=$value['value']['icon']?> icon"></i>
                <?php endif ?>
                <?=$value['value']['title']?>
              </span>
              <?php else: ?>
                <?=$value['value']['title']?>
              <?php endif ?>
            </td>
          <?php else: ?>
            <td><?=$value['value']?></td>
          <?php endif ?>
        <?php endif ?>
      <?php endforeach ?>
    </tr>
  <?php endforeach ?>
  </tbody>
  <tfoot>
    <tr><th colspan="<?=count(current($fields)) + 1?>">
      <div class="ui right floated pagination menu">
        <a class="icon item">
          <i class="left chevron icon"></i>
        </a>
        <?php for($i=1; $i <= $fields['paging']['pages']; $i++): ?>
          <?php if ($i > ($fields['paging']['current'] - 2) && ($i < $fields['paging']['current'])): ?>
            <a href="<?=$fields['paging']['linkpage'] . $i?>" class="item"><?=$i?></a>
          <?php endif ?>
          <?php if ($fields['paging']['current'] == $i): ?>
            <a href="<?=$fields['paging']['linkpage'] . $i?>" class="active item"><?=$i?></a>
          <?php endif ?>
          <?php if ($i < ($fields['paging']['current'] + 2) && ($i > $fields['paging']['current'])): ?>
            <a href="<?=$fields['paging']['linkpage'] . $i?>" class="item"><?=$i?></a>
          <?php endif ?>
          <?php if ($i == ($fields['paging']['current'] + 2)): ?>
            <a class="item">...</a>
          <?php endif ?>
          <?php if ($i == $fields['paging']['pages'] && $fields['paging']['current'] != $i): ?>
            <a href="<?=$fields['paging']['linkpage'] . $i?>" class="item"><?=$i?></a>
          <?php endif ?>
        <?php endfor ?>
        <a class="icon item">
          <i class="right chevron icon"></i>
        </a>
      </div>
    </th>
  </tr></tfoot>
</table>
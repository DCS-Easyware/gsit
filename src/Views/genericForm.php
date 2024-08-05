<div class="ui blue dividing header">
  <i class="big laptop icon"></i>
  <div class="content">
    <?=$name?>
    <div class="sub header"><?=current($fields)['value']?></div>
  </div>
</div>

<?php if (count($relatedPages) > 0): ?>
  <div class="ui equal width labeled icon menu">
    <?php foreach ($relatedPages as $item): ?>
      <a class="item">
        <i class="icon blue <?=$item['icon']?>"></i>
        <?=$item['title']?>
        <!-- <div class="floating ui blue label">22</div> -->
      </a>
    <?php endforeach ?>
  </div>
<?php endif ?>

<form method="post" class="ui form">
  <button class="ui button right floated" type="submit">Save</button>
  <?php foreach ($fields as $item): ?>
    <div class="field">
      <label><?=$item['title']?></label>
      <?php if ($item['type'] == 'input'): ?>
        <input type="text" name="<?=$item['name']?>" value="<?=$item['value']?>">
      <?php endif ?>

      <?php if ($item['type'] == 'dropdown'): ?>
        <div class="ui selection dropdown">
          <input type="hidden" name="<?=$item['name']?>" value="1">
          <i class="dropdown icon"></i>
          <div class="default text">Select value...</div>
          <div class="menu">
          </div>
        </div>
      <?php endif ?>

      <?php if ($item['type'] == 'dropdown_remote'): ?>
        <div
          class="ui selection dropdown remotedropdown"
          data-url="http://127.0.0.1/gsit/dropdown"
          data-itemtype="<?=$item['itemtype']?>"
        >
          <input type="hidden" name="<?=$item['name']?>" value="<?=$item['value']?>">
          <i class="dropdown icon"></i>
          <?php if ($item['value'] == 0): ?>
            <div class="default text">Select value...</div>
          <?php endif ?>
          <?php if ($item['value'] > 0): ?>
            <div class="text"><?=$item['valuename']?></div>
          <?php endif ?>
          <div class="menu">
          </div>
        </div>
      <?php endif ?>

      <?php if ($item['type'] == 'textarea'): ?>
        <textarea rows="3" name="<?=$item['name']?>"><?=$item['value']?></textarea>
      <?php endif ?>
    </div>
  <?php endforeach ?>
  <button class="ui button right floated" type="submit">Save</button>
</form>

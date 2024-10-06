<div class="ui connected feed">
  <?php foreach ($history as $item): ?>
    <div class="event">
      <div class="label">
        <i class="circular colored inverted exchange alternate brown icon"></i>
      </div>
      <div class="content">
        <div class="summary">
          <a class="user">
            <?=$item->user_name?>
          </a> <?=$item['summary']?>
          <div class="date">
            <?=$item->updated_at?>
          </div>
        </div>
        <div class="extra text">
          <span><?=$item->old_value?></span>
          <span> => </span>
          <span><?=$item->new_value?></span>
        </div>
      </div>
    </div>
  <?php endforeach ?>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="/gsit/fomantic-ui/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="/gsit/assets/main.css">
  <script type="text/javascript" src="/gsit/fomantic-ui/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="/gsit/fomantic-ui/semantic.min.js"></script>
  <script type="text/javascript" src="/gsit/fomantic-ui/jquery.tablesort.min.js"></script>
  <title><?=$title?></title>
</head>
<body>

  <div>
    <div class="ui left vertical visible sidebar menu">
    <div class="item">
      <div class="ui icon input">
        <input type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>
    </div>
    <?php foreach ($menu as $item): ?>
      <div class="item">
        <div class="header">
          <?=$item['name']?>
          <i class="<?=$item['icon']?> icon"></i>
        </div>
        <div class="menu">
          <?php foreach ($item['sub'] as $subitem): ?>
            <a class="item <?=$subitem['class']?>" href="<?=$subitem['link']?>">
              <?=$subitem['name']?>
              <i class="<?=$subitem['icon']?> icon"></i>
            </a>
          <?php endforeach ?>
        </div>
      </div>
    <?php endforeach ?>
    </div>

    <!-- <div class="ui resizable scrolling wide long container" style="margin: 40px; margin-left: 300px !important"> -->
    <div class="pusher" style="margin: 20px;">
      <?=$content?>
    </div>
  </div>

  <script type="text/javascript">
    $('.ui.dropdown')
        .dropdown({
        })
    ;
    $('.remotedropdown')
      .dropdown({
        // minCharacters: 2,
        saveRemoteData: false,
        apiSettings: {
          encodeParameters: false,
          cache: false,
          url: '{url}',
          method: 'post',
          beforeSend: function(settings) {
            // cancel request if no itemtype
            if(!$(this).data('itemtype')) {
              return false;
            }
            settings.data.itemtype = $(this).data('itemtype');
            settings.data = JSON.stringify(settings.data);
            return settings;
          }          
        }      
      });

    $('table').tablesort();

    $('.searchfield')
      .dropdown({
        action: 'activate',
        onChange: function(text, value, element) {
          type = element[0].attributes['data-type'].value;
          if (type === 'input') {
            $('#search-input').prop({
              hidden: false
            });
            $('#search-input input').prop({
              name: 'value'
            });
            $('#search-dropdown').prop({
              hidden: true
            });
            $('#search-dropdown input').removeProp('name');
          } else {
            itemtype = element[0].attributes['data-itemtype'].value;
            $('#search-input').prop({
              hidden: true
            });
            $('#search-input input').removeProp('name');
            $('#search-dropdown').prop({
              hidden: false,
            });
            $('#search-dropdown').data('itemtype', itemtype);
            $('#search-dropdown input').prop({
              name: 'value'
            });
          }
        }
      });

      <?php if (isset($message)): ?>
      $.toast({
        title: 'LOOK',
        message: '<?=$message?>',
        showProgress: 'top',
        classProgress: 'green',
        progressUp: true,
      });
      <?php endif ?>

  </script>

</body>
</html>


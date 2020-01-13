<!DOCTYPE xtml PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<?php
  $getJsonData = file_get_contents('eResourceList.json');
  $decodeJsonData = json_decode($getJsonData, true);
?>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>資料庫</title>
  <link rel="stylesheet" type="text/css" href="lib/style.css"/>
</head>
<body onload="init();">
  <section>
    <h1>資料庫列表</h1>
    <div id="databaseList">
      <div class="search-wrap">
        <div class="search-frame">
          <input type="text" class="search" placeholder="搜尋" />
        </div>
      </div>
      <table class="databaseList-table">
        <thead>
          <tr>
            <th class="sort" data-sort="id">編號</th>
            <th class="sort" data-sort="name">資源名稱</th>
            <th class="sort" data-sort="type">類型</th>
            <th class="sort" data-sort="city">語文</th>
          </tr>
        </thead>
        <tbody class="list" id="databaseList">
<?php
  foreach ($decodeJsonData['rows'] as $row) {
    echo '<tr>
            <td class="id" data-label="編號">'.$row['id'].'</td>
            <td class="name" data-label="資源名稱">
              <a href="'.$row['url'].'">'
                .$row['resourceName'].
              '</a>
            </td>
            <td class="type" data-label="類型">'.$row['type'].'</td>
            <td class="city" data-label="語文">'.$row['language'].'</td>
          </tr>';
  }
?>
        </tbody>
      </table>
      <ul class="pagination"></ul>
    </div>
  </section>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script type="text/javascript">
  function init() {
    console.log('test');
  }
  var options = {
    valueNames: [ 'id', 'name', 'type', 'city' ],
    page: 10,
    pagination: true
  };

  // Init list
  var contactList = new List('databaseList', options);

  var idField = $('#id-field'),
      nameField = $('#name-field'),
      typeField = $('#type-field'),
      cityField = $('#city-field'),
      addBtn = $('#add-btn'),
      editBtn = $('#edit-btn').hide();

  // Sets callbacks to the buttons in the list
  // refreshCallbacks();

  addBtn.click(function() {
    contactList.add({
      id: Math.floor(Math.random()*110000),
      name: nameField.val(),
      type: typeField.val(),
      city: cityField.val()
    });
    clearFields();
    // refreshCallbacks();
  });

  editBtn.click(function() {
    var item = contactList.get('id', idField.val())[0];
    item.values({
      id:idField.val(),
      name: nameField.val(),
      type: typeField.val(),
      city: cityField.val()
    });
    clearFields();
    editBtn.hide();
    addBtn.show();
  });

  // function refreshCallbacks() {
  //   // Needed to add new buttons to jQuery-extended object
  //   editBtns = $(editBtns.selector);
    
  //   editBtns.click(function() {
  //     var itemId = $(this).closest('tr').find('.id').text();
  //     var itemValues = contactList.get('id', itemId)[0].values();
  //     idField.val(itemValues.id);
  //     nameField.val(itemValues.name);
  //     ageField.val(itemValues.age);
  //     cityField.val(itemValues.city);
      
  //     editBtn.show();
  //     addBtn.hide();
  //   });
  // }

  function clearFields() {
    nameField.val('');
    typeField.val('');
    cityField.val('');
  }
</script>
<style type="text/css">
  .pagination li {
    display:inline-block;
    padding:5px;
  }
</style>


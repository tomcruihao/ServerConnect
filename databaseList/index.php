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
</head>
<body onload="init();">
  <div id="databaseList">
    <input type="text" class="search" placeholder="Search contact" />
    <table>
      <thead>
        <tr>
          <th class="sort" data-sort="id">編號</th>
          <th class="sort" data-sort="name">資源名稱</th>
          <th class="sort" data-sort="age">類型</th>
          <th class="sort" data-sort="city">語文</th>
        </tr>
      </thead>
      <tbody class="list" id="databaseList">
<?php
  foreach ($decodeJsonData['rows'] as $row) {
    echo '<tr>
            <td class="id">'.$row['id'].'</td>
            <td class="name">
              <a href="'.$row['url'].'">'
                .$row['resourceName'].
              '</a>
            </td>
            <td class="age">27</td>
            <td class="city">'.$row['language'].'</td>
          </tr>';
  }
?>
      </tbody>
    </table>
  </div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script type="text/javascript">
  function init() {
    console.log('test');
  }
  var options = {
    valueNames: [ 'id', 'name', 'age', 'city' ]
  };

  // Init list
  var contactList = new List('databaseList', options);

  var idField = $('#id-field'),
      nameField = $('#name-field'),
      ageField = $('#age-field'),
      cityField = $('#city-field'),
      addBtn = $('#add-btn'),
      editBtn = $('#edit-btn').hide(),
      removeBtns = $('.remove-item-btn'),
      editBtns = $('.edit-item-btn');

  // Sets callbacks to the buttons in the list
  refreshCallbacks();

  addBtn.click(function() {
    contactList.add({
      id: Math.floor(Math.random()*110000),
      name: nameField.val(),
      age: ageField.val(),
      city: cityField.val()
    });
    clearFields();
    refreshCallbacks();
  });

  editBtn.click(function() {
    var item = contactList.get('id', idField.val())[0];
    item.values({
      id:idField.val(),
      name: nameField.val(),
      age: ageField.val(),
      city: cityField.val()
    });
    clearFields();
    editBtn.hide();
    addBtn.show();
  });

  function refreshCallbacks() {
    // Needed to add new buttons to jQuery-extended object
    removeBtns = $(removeBtns.selector);
    editBtns = $(editBtns.selector);
    
    removeBtns.click(function() {
      var itemId = $(this).closest('tr').find('.id').text();
      contactList.remove('id', itemId);
    });
    
    editBtns.click(function() {
      var itemId = $(this).closest('tr').find('.id').text();
      var itemValues = contactList.get('id', itemId)[0].values();
      idField.val(itemValues.id);
      nameField.val(itemValues.name);
      ageField.val(itemValues.age);
      cityField.val(itemValues.city);
      
      editBtn.show();
      addBtn.hide();
    });
  }

  function clearFields() {
    nameField.val('');
    ageField.val('');
    cityField.val('');
  }
</script>

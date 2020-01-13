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
          <th class="sort" data-sort="name">Name</th>
          <th class="sort" data-sort="age">Age</th>
          <th class="sort" data-sort="city">City</th>
        </tr>
      </thead>
      <tbody class="list" id="databaseList">
<?php
  foreach ($decodeJsonData.row as $row) {
    echo '<tr>';
    echo '<td class="id" style="display:none;">1</td>';
    echo '<td class="name">Jonny</td>';
    echo '<td class="age">27</td>';
    echo '<td class="city">Stockholm</td>';
    echo '<td class="edit"><button class="edit-item-btn">Edit</button></td>';
    echo '<td class="remove"><button class="remove-item-btn">Remove</button></td>';
    echo '</tr>';
  }
?>
      </tbody>
    </table>
    <table>
      <td class="name">
        <input type="hidden" id="id-field" />
        <input type="text" id="name-field" placeholder="Name" />
      </td>
      <td class="age">
        <input type="text" id="age-field" placeholder="Age" />
      </td>
      <td class="city">
        <input type="text" id="city-field" placeholder="City" />
      </td>
      <td class="add">
        <button id="add-btn">Add</button>
        <button id="edit-btn">Edit</button>
      </td>
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

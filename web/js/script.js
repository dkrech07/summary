var addNewItemElement = document.querySelector('.add-new-item');
var settingsElement = document.querySelector('.settings-item');
var summaryTableElement = document.querySelector('.summary-table');
var refreshElement = document.querySelector('.refresh');

refreshElement.addEventListener('click', evt=>{
  var data = {
    'refres': true
  };

  $.ajax({
    url: '/site/index',
    type: 'POST',
    data: data,
    success: function (response) {
      // var itemData = JSON.parse(response);
      // var itemData = JSON.stringify(response);
      // console.log(data);
      // console.log(response);
    }
  });
  location.reload();
});

// Подстветка статусов на элементах списка
var summaryElement = summaryTableElement.querySelectorAll('.summary-item');
summaryElement.forEach(element => {
  statusElement = element.querySelector('.status');
  if (statusElement.dataset.status == 3) {
    statusElement.style.color = 'blue';
  }
  if (statusElement.dataset.status == 2) {
    statusElement.style.color = 'green';
  }
  if (statusElement.dataset.status == 1) {
    statusElement.style.color = 'red';
  }
});

// Создание записи

addNewItemElement.addEventListener('click', evt => {
  evt.preventDefault();
  $('#NewItemModal').modal('show');

  var newItemModalElement = document.querySelector('#NewItemModal');
  var newAudioElement = newItemModalElement.querySelector('.new-audio');
  var newDetailElement = newItemModalElement.querySelector('.new-detail');

  newAudioElement.addEventListener('click', evt => {
    $('#NewItemModal').modal('hide');
    $('#audioModal').modal('show');
    var newAudioForm = document.querySelector('#audio');
    // newAudioForm.reset();
  });

  newDetailElement.addEventListener('click', evt => {
    $('#NewItemModal').modal('hide');
    $('#detailModal').modal('show');
    var newDetailForm = document.querySelector('#detail');
    newDetailForm.reset();
  });
});

// Редактирование подробного и краткого описания
var itemEditElement = summaryTableElement.querySelectorAll('.item-edit');

var detailEditElement = summaryTableElement.querySelectorAll('.detail-edit');
var summaryEditElement = summaryTableElement.querySelectorAll('.summary-edit');

itemEditElement.forEach(element => {
  element.addEventListener('click', evt => {
    var editParam = element.classList[1];

    if (editParam === 'detail') {
      var data = {
        'item_id_detail': element.parentNode.id
      };

      $.ajax({
        url: '/site/edit',
        type: 'POST',
        data: data,
        success: function (response) {
          var itemData = JSON.parse(response);
          // var itemData = JSON.stringify(response);
          // console.log(data);
          // console.log(itemData);
          var itemModalElement = document.querySelector('#' + editParam + 'Modal');

          var tabs = itemModalElement.querySelector('.tabs');

          var tabsElements = tabs.querySelectorAll('.btn');
          if (tabsElements) {
            tabsElements.forEach(element => {
              tabs.removeChild(element);
            });
          }

          itemData.forEach((element, index, array) => {
            var tabElement = document.createElement("button");
            if (index < 1) {
              tabElement.className = "btn btn-primary";
            } else {
              tabElement.className = "btn btn-secondary";
            }
            tabElement.type = 'button';
            tabElement.textContent = 'Вариант ' + (index + 1);
            tabElement.id = index;
            tabs.appendChild(tabElement);

            var itemModalElementTitle = itemModalElement.querySelector('#itemform-' + 'title');
            var itemModalElementInput = itemModalElement.querySelector('#itemform-' + editParam);
            itemModalElementTitle.value = itemData[0]['title'];
            itemModalElementInput.value = itemData[0][editParam + '_text'];

            tabElement.addEventListener('click', evt => {
              tabsElements.forEach(item => {
                if (item.classList.contains('btn-primary')) {
                  item.classList.remove('btn-primary');
                }
                item.classList.add('btn-secondary');
              });

              itemModalElementTitle.value = itemData[index]['title'];
              itemModalElementInput.value = itemData[index][editParam + '_text'];

              tabElement.classList.remove('btn-secondary');
              tabElement.classList.add('btn-primary');
            });
          });

          var tabsElements = tabs.querySelectorAll('.btn');

          if (itemData) {
            $('#' + editParam + 'Modal').modal('show');
          }
        }
      });

    } else if (editParam === 'summary') {
      var data = {
        'item_id_summary': element.parentNode.id
      };

      console.log(editParam);

      $.ajax({
        url: '/site/edit',
        type: 'POST',
        data: data,
        success: function (response) {
          var itemData = JSON.parse(response);
          var itemModalElement = document.querySelector('#' + editParam + 'Modal');

          var itemModalElementTitle = itemModalElement.querySelector('#itemform-' + 'title');
          var itemModalElementInput = itemModalElement.querySelector('#itemform-' + editParam);
          itemModalElementTitle.value = itemData['title'];
          itemModalElementInput.value = itemData[editParam + '_text'];

          console.log(data);
          console.log(itemData);

          if (itemData) {
            $('#' + editParam + 'Modal').modal('show');
          }
        }
      });
    }

  });
});

settingsElement.addEventListener('click', evt => {
  evt.preventDefault();
  $('#accountModal').modal('show');
});

// $('#audioModal').modal('show');

$(document).on('pjax:beforeSend', function () {
  // $('.appeal-list').hide();
  $('#loader').show();
})

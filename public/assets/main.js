(function (window, document) {
  'use strict';
  
  function confirmDel(event) {
    event.preventDefault();
    //console.log(event.target.parentNode.href);
    let token = document.getElementsByName('_token')[0].value;
    if(confirm('Deseja realmente remover este item?')){
      let ajax = new XMLHttpRequest();
      ajax.open('DELETE', event.target.parentNode.href);
      ajax.setRequestHeader('X-CSRF-TOKEN', token);
      ajax.onreadystatechange = function () {
        if(ajax.readyState === 4 && ajax.status === 200){
          window.location.href = window.location.pathname;
        }
      };
      ajax.send();
    }else{
      return false;
    }
  }

  if(document.querySelector('.js-del')){
    let btn = document.querySelectorAll('.js-del');
    for(let i = 0; i < btn.length; i++){
      btn[i].addEventListener('click', confirmDel, false);
    }
  }

  function getProducts() {
    let ajax = new XMLHttpRequest();
    let productsData;
    ajax.open('GET', window.location.pathname + '/json', false);
    ajax.onreadystatechange = function () {
      if(ajax.readyState === 4 && ajax.status === 200){
        productsData = JSON.parse(ajax.responseText);
      }
    }
    ajax.send();
    return productsData;
  }

  function updateTable() {
    let tableBody = document.querySelector('table tbody');
    let row;
    let productsData = getProducts();
    tableBody.innerHTML = '';
    productsData.forEach(item=>{
      console.log(item);
      let nameCell = document.createElement('td');
      nameCell.scope = 'col';
      nameCell.innerText = item.name;
      let locationCell = document.createElement('td');
      locationCell.scope = 'col';
      locationCell.innerText = item.location;
      let editBtn = document.createElement('button');
      editBtn.className = 'btn btn-sm btn-primary pl-3 pr-3';
      editBtn.innerText = 'Editar';
      let editA = document.createElement('a');
      editA.href = 'products/' + item.id + '/edit';
      editA.appendChild(editBtn);
      let removeBtn = document.createElement('button');
      removeBtn.className = 'btn btn-sm btn-danger';
      removeBtn.innerText = 'Remover';
      let removeA = document.createElement('a');
      removeA.href = '/products/' + item.id;
      removeA.className = 'js-del';
      removeA.appendChild(removeBtn);
      let actioncell = document.createElement('td');
      actioncell.scope = 'col';
      actioncell.appendChild(editA);
      actioncell.appendChild(removeA);
      row = document.createElement('tr');
      row.appendChild(nameCell);
      row.appendChild(locationCell);
      row.appendChild(actioncell);
      tableBody.appendChild(row);
    });
  }

  if(document.querySelector('.table')){
    setInterval(updateTable, 2000);
  }
})(window, document);
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

  function getLocations() {
    let ajax = new XMLHttpRequest();
    let LocationsData;
    ajax.open('GET', '/locations/json', false);
    ajax.onreadystatechange = function () {
      if(ajax.readyState === 4 && ajax.status === 200){
        LocationsData = JSON.parse(ajax.responseText);
      }
    }
    ajax.send();
    return LocationsData;
  }

  function updateTable() {
    let table = document.querySelector('table tbody');
    let row;
    let productsData = getProducts();
    let locationsData = getLocations();
    console.log(locationsData);
    productsData.forEach(item=>{
      console.log(item);
      let idcell = document.createElement('td');
      idcell.scope = 'col';
      idcell.innerText = item.id;
      let locationcell = document.createElement('td');
      locationcell.scope = 'col';
      locationcell.innerText = locationsData.filter((lData)=>{
        lData.id == item.id_location
      });
      let editBtn = document.createElement('button');
      editBtn.className = 'btn btn-primary btn-sm pr-3 pl-3';
      editBtn.innerText = 'Editar';
      let editA = document.createElement('a');
      editA.href = 'products/' + item.id + '/edit';
      editA.appendChild(editBtn);
      let removeBtn = document.createElement('button');
      removeBtn.className = 'btn btn-danger btn-sm';
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
      row.appendChild(idcell);
      row.appendChild(locationcell);
      row.appendChild(actioncell);
    });
    table.appendChild(row);
  }

  if(document.querySelector('.table')){
    setInterval(updateTable, 2000);
  }
})(window, document);
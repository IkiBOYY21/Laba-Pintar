document.addEventListener('click', function(e){
  if(e.target && e.target.matches('.remove-item')){
    e.target.closest('.item-row').remove();
  }
});
document.getElementById && document.getElementById('addItem') && document.getElementById('addItem').addEventListener('click', function(){
  var container = document.getElementById('items');
  if(!container) return;
  var row = document.querySelector('.item-row');
  if(!row) return;
  var clone = row.cloneNode(true);
  clone.querySelectorAll('input').forEach(i=>i.value='1');
  container.appendChild(clone);
});

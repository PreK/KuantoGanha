// Script para alternar entre modos claro e escuro
document.getElementById('darkModeToggle').addEventListener('change', function(event){
  if(event.target.checked) {
    document.body.classList.add('dark-mode');
    document.querySelector('.sidebar').classList.add('dark-mode');
  } else {
    document.body.classList.remove('dark-mode');
    document.querySelector('.sidebar').classList.remove('dark-mode');
  }
});
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loginLink').addEventListener('click', function() {
        loadContent('login.php');
    });

    document.getElementById('registerLink').addEventListener('click', function() {
    loadContent('register.php');
});

    function loadContent(page) {
    const xhr = new XMLHttpRequest();
    xhr.onload = function() {
    if (this.status === 200) {
    document.getElementById('mainContent').innerHTML = this.responseText;
} else {
    document.getElementById('mainContent').innerHTML = 'Erro ao carregar a página';
}
};
    xhr.open('GET', 'ext/' + page, true);
    xhr.send();
}
});
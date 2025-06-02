$(document).on('click', '.spa-link', function (e) {
  e.preventDefault();
  const page = $(this).data('page');
  $('#conteudo').load(page);
  
});
window.onload = init;

function init() {
	var uploader = document.getElementById('drop-area');
	var submitter = document.getElementById('drop-submit');
	uploader.addEventListener('change', function() {
		$(submitter).click();
	});
}
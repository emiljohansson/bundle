window.onload = init;

function init() {
	var uploader = document.getElementById('drop-area');
	var submitter = document.getElementById('drop-submit');
	if (uploader === null) {
		return;
	}
	uploader.addEventListener('change', function() {
		$(submitter).click();
	});
}

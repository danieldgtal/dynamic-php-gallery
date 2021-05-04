$(document).ready(function () {
	$(".modal_thumbnails").click(function () {
		$("#set_user_image").attr("disabled", "false");
	});
});
tinymce.init({
	selector: "textarea",
});

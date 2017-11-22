countPos = 0;

$(document).ready(function () {
	$('#add_pos').on("click", function(event){
		event.preventDefault();
		if (countPos >= 10) {
			alert('Maximum position of 10');
			return;
		}
		countPos++;
		$('#position_fields').append(
			'<div id="position'+countPos+'" class="card">'
			+'<div class="card-body">'
			+'<div class="form-group row">'
			+'<label class="col-form-label col-sm-2" for="year">Year: </label>'
			+'<div class="col-sm-4">'
			+'<input class="form-control" type="number" name="year" min="1900" max="2020" value="2017">'
			+'</div>'
			+'<div class="col-sm-6">'
			+'<button type="button" onclick="$(\'#position'+countPos+'\').remove();countPos--;return;" style="float: right;" id="del_pos" class="btn btn-danger btn-sm">-</button>'
			+'</div></div>'
			+'<div class="form-group">'
			+'<label for="desc">Description</label>'
			+'<textarea class="form-control" name="desc" placeholder="Enter a brief description of the position you occupied." ></textarea>'
			+'</div></div></div>'
			);
	});
});

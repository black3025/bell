function success(msg){
	Swal.fire(
		'Success',
		msg,
		'success'
	  )
}

function error(msg){
	Swal.fire({
		title: 'Error!',
		text: msg,
		icon: 'error',
		confirmButtonText: 'OK'
	})
}

function warning(msg){
	Swal.fire({
		title: 'Unable to process!',
		text: msg,
		icon: 'warning',
		confirmButtonText: 'Proceed'
	})
}

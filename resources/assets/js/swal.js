success(msg)
{
    Swal.fire(
        'Success!',
        msg,
        'success'
      )
}

error(msg)
{
    Swal.fire({
        icon: 'error',
        title: 'Something went wrong!',
        text: msg,
      })

}

warning(msg)
{
    Swal.fire({
        icon: 'warning',
        title: 'Something went wrong!',
        text: msg,
      })
}
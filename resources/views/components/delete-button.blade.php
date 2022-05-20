<form style="margin-left: 5px" action="{{$route}}" method="POST">
    @csrf
    <button type="button" class="btn btn-sm btn-danger" onclick="popModal(this)">
        <i class="fa fa-trash"></i>
    </button>
</form>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function popModal(_this){
        Swal.fire({
            title: "@lang('admin.Are you sure?')",
            text: '@lang("admin.You will not be able to revert this!")',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "@lang('admin.Yes, delete it!')"
        }).then((result) => {
            if (result.isConfirmed) {
               _this.form.submit();
            }
        })
    }

</script>

@extends('layouts.admin')
@section('title', 'Manage Categories')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">All Categories</h4>
            {{-- {{ $errors }}--}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">All Categories</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="w-100">
    <a href="{{ route('category.create') }}" class="btn btn-primary">Add New</a>
    <div class="row justify-content-center">
        <div class="col-md-12 mt-4">
        <div class="card p-4 rounded cShadow table-responsive">
                <table id="datatable" class="table table-bordered  table-hover dt-responsive display nowrap">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Image</th>
                            <th>Slug/URL</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $('#datatable').DataTable({
        
        serverSide: true,
        processing: true,
        ajax: '{{ route('categories.all') }}',
        columns: [
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'image',
                name: 'image',
            },
            {
                data: 'slug',
                name: 'slug',
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'actions',
                name: 'actions'
            },
        ]
    });
</script>
<script>
    $(document).ready(function() {
        $('#datatable').on('click', '.delete-btn', function(e) {
            e.preventDefault(); // Prevent the form submission
            const form = $(this).closest('form');
            const rowId = $(this).data('row-id');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-2",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "It will delete all data related to this category and You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the form submission to delete the record
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Handle cancellation if needed
                }
            });
        });
    });
</script>
@endsection
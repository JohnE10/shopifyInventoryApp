@extends('layouts.layout')

@section('content')

<!-- if the ID is valid, show results -->
@if($errors == 0)
    <div class="row mb-3">
        <div class="col-6 text-center">
            <h3 class="fw-bold">Item Data</h3>
        </div>
    </div>

    <div class="row fw-bold">

        <div class="col-1 text-end">
            <p>&nbsp;</p>
        </div>

        <div class="col-1 text-start fs-5">
            <p>ID</p>
        </div>

        <div class="col-4 ps-5 fs-5">
            <p>Title</p>
        </div>

    </div>

    <div class="row">
        <div class="col-1 text-end">
            
        </div>

        <div class="col-1 text-start">
            {{ $product_id }}
        </div>

        <div class="col ps-5">
            <a href="{{ $product_url }}">{{ $title }}</a>
        </div>

    </div>
    <div class="mt-5">
        <button data-bs-toggle="modal" data-bs-target="#show-modal" style="border: none; 
        background: none!important; padding: 0!important; color: #0D6EFD;">Click here
        </button> to display info for another item.
    </div>

<!-- if the ID number is not valid, let user know -->
@elseif($errors == 1)
    <p>Item ID not valid.</p>
    <button data-bs-toggle="modal" data-bs-target="#show-modal" style="border: none; 
    background: none!important; padding: 0!important; color: #0D6EFD;">
        Click here</button> to try a different ID.
@endif

{{-- Start show modal --}}

<div class="modal fade" id="show-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Get Item By ID</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/show" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="showID ">Enter Item ID:&nbsp;</label>
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- End show modal --}}

@endsection

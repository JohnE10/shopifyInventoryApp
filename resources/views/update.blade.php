@extends('layouts.layout')

@section('content')

<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

    <div class="content">
        <div class="invent-form">
            <h1>Update Product</h1>
            <p>Upadate a product.</p>
            <form action="/update" method="POST">
                @csrf
                <label>Item Identifier:&nbsp;</label>
                <input type="text" id="itemId" name="itemId"><br>
                <input type="submit" value="List Item">
            </form>
        </div>
        <div>
            <p></p>
        </div>

    </div>
</div>

@endsection

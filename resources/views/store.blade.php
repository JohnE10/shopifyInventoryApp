@extends('layouts.layout')

@section('content')

<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

    <div class="content">
        <div class="invent-form">
            <h1>Add Product to database</h1>
            <form action="/addToDB" method="POST">
                @csrf
                <label>Item Identifier (from inventory list):&nbsp;</label>
                <input type="text" id="itemId" name="itemId"><br>
                <input type="submit" value="Submit">
            </form>
        </div>
        <div>
            <p></p>
        </div>

    </div>
</div>

@endsection

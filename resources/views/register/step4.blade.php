@extends('layouts.app')
@include('/header')

@section('content')
 
    <h3>Review Details</h3>
    <form action="<?php echo URL::to('/').'/store';?>" method="post" >
        {{ csrf_field() }}
            <table class="table">
                <tr>
                    <td>Name:</td>
                    <td><strong>{{$register->name}}</strong></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td><strong>{{$register->description}}</strong></td>
                </tr>
                <tr>
                    <td>Image:</td>
                    <td><strong><img alt="Product Image" src="/storage/productimg/{{$register->productImg}}"/></strong></td>
                </tr>
            </table>
        <a type="button" href="<?php echo URL::to('/').'/register1';?>" class="btn btn-warning">Back to Step 1</a>
        <a type="button" href="<?php echo URL::to('/').'/register2';?>" class="btn btn-warning">Back to Step 2</a>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
@endsection 
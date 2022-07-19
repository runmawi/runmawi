@extends('errors::layout')

@section('title', __('Service Unavailable'))
@section('code', '503')

@section('message')
    <img src="https://3.imimg.com/data3/OD/DQ/MY-9110935/web-site-maintenance-service-and-technical-support-500x500.gif" >
    <div>Sorry, we are now undergoing maintenance.<br>Please check back soon.</div>
@endsection
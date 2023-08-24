@extends('errors::layout')

@section('title', __('Service Unavailable'))
@section('code', '503')

@section('message')
    <div>Your OTT is down due to Subscription Failure. <br />Please connect with your site administrator immediately to help you!</div>
    <img width="200" style="margin-top: 30px;" src="https://flicknexs.com/assets/new.svg" >

@endsection
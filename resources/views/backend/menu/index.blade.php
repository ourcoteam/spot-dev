@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('Menus')}}</h1>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            {!! Menu::render() !!}
        </div>
    </div>

@endsection

@section('modal')
    {!! Menu::scripts() !!}
@endsection

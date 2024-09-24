@extends('layouts.app')

@auth
{{-- {{ dd(Auth::user()->role) }} --}}
@php
    $userRole = Auth::user()->role;
    $roleConfig = config('roles.' . $userRole, config('roles.default'));
   
@endphp


@section('main-content')
    @if(in_array(Request::path(), ['static-sign-up', 'static-sign-in']))
        @include('layouts.navbars.guest.nav')
        @yield('content')
        @include('layouts.footers.guest.footer')
    @else
        @include("layouts.navbars.{$userRole}.sidebar")
        <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
            @include("layouts.navbars.{$userRole}.nav")
            
            @if(Request::is('rtl'))
                <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg overflow-hidden rtl">
                    @include("layouts.navbars.{$userRole}.nav-rtl")
                    <div class="container-fluid py-4">
                        @yield('content')
                        @include("layouts.footers.{$userRole}.footer")
                    </div>
                </main>
            @elseif(Request::is('virtual-reality'))
                <div class="border-radius-xl mt-3 mx-3 position-relative" style="background-image: url('../assets/img/vr-bg.jpg'); background-size: cover;">
                    <main class="main-content mt-1 border-radius-lg">
                        @yield('content')
                    </main>
                </div>
                @include("layouts.footers.{$userRole}.footer")
            @elseif(in_array(Request::path(), array_merge($roleConfig['special_routes'] ?? [], ['profile'])))
                @yield('content')
            @else
                <div class="container-fluid py-4">
                    @yield('content')
                    @include("layouts.footers.{$userRole}.footer")
                </div>
            @endif
        </div>

        @if($roleConfig['extra_components'] ?? false)
            @foreach($roleConfig['extra_components'] as $component)
                @include($component)
            @endforeach
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var alert = document.querySelector('.alert');
                    if (alert) {
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                        setTimeout(function() {
                            alert.remove();
                        }, 2000);
                    }
                }, 2000);
            });
        </script>
    @endif
@endsection
@endauth
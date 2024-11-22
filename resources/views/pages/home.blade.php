@extends('layouts.default')
@section('content')
    <div class="banner">
        <div class="banner__container">
            <div class="banner__inner">
                <img src="{{ Vite::asset('resources/images/banner.png') }}" alt="banner" />
                <div class="banner__info">
                    <div class="banner__title">
                        Выбери свою игру
                    </div>

                    <div class="banner__subtitle">
                        Добро пожаловать на нашу торговую площадку
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="games">
        <div class="games__container">
            <div class="strips-list">
                @include('includes.gamestrip', [
                    'listings' => array_slice(array_filter($listings, function ($item) {
                        return $item['game'] === 'CS2';
                    }), 0, 6),
                    'game' => 'CS2',
                    'iconUrl' => Vite::asset('resources/icons/cs2.png'),
                ])
                @include('includes.gamestrip', [
                    'listings' => array_slice(array_filter($listings, function ($item) {
                        return $item['game'] === 'Dota2';
                    }), 0, 6),
                    'game' => 'Dota 2',
                    'iconUrl' => Vite::asset('resources/icons/dota2.png'),
                ])
                @include('includes.gamestrip', [
                    'listings' => array_slice(array_filter($listings, function ($item) {
                        return $item['game'] === 'Rust';
                    }), 0, 6),
                    'game' => 'Rust',
                    'iconUrl' => Vite::asset('resources/icons/rust.png'),
                ])
            </div>
        </div>
    </div>
@endsection

@section('styles')
    @vite(['resources/scss/homePage.scss', 'resources/scss/card.scss', 'resources/scss/gamestrip.scss'])
@endsection

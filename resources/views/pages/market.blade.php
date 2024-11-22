@extends('layouts.default')

@section('styles')
    @vite(['resources/scss/market.scss', 'resources/scss/listingList.scss', 'resources/scss/filter.scss', 'resources/scss/card.scss'])
@endsection

@section('content')
    <div class="market__container">
        <div class="main__inner">
            @include('includes.filter', [
                'categories' => $categories,
                'filters' => $filters,
                'minPrice' => 0,
                'maxPrice' => 10000,
            ])

            <div class="market">
                <div class="market__title">
                    {{ session('marketGame') }}
                </div>

                <div class="market__listings">
                    @include('includes.listingList', ['listings' => $listings, 'search' => $search])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function handleClickFilter(element) {
            const parent = element.parentNode;
            const body = parent.querySelector('.accordion__itemBody');

            body?.classList.toggle('accordion__itemBody_show');
            element?.classList.toggle('active');
        }

        function handleSubmitFilter(e) {
            const checkerElements = document.getElementsByClassName('checker');
            const minPrice = document.getElementById('minPrice');
            const maxPrice = document.getElementById('maxPrice');

            const selectedIds = [];

            for (let i = 0; i < checkerElements.length; i++) {
                const checkbox = checkerElements[i].querySelector('input[type=checkbox]');

                if (checkbox.checked) {
                    selectedIds.push(checkbox.id);
                }
            }

            const selectedIdsString = selectedIds.join(',');

            const url = new URL(window.location.href);

            const params = new URLSearchParams(url.search);

            params.set('filter', selectedIdsString);
            params.set('minPrice', minPrice.value);
            params.set('maxPrice', maxPrice.value);

            url.search = params.toString();

            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);

            // Получение значений параметров из URL
            const filterIds = params.get('filter')?.split(',') || [];
            const minPriceValue = params.get('minPrice');
            const maxPriceValue = params.get('maxPrice');

            // Установка значений minPrice и maxPrice
            if (minPriceValue) {
                document.getElementById('minPrice').value = minPriceValue;
            }
            if (maxPriceValue) {
                document.getElementById('maxPrice').value = maxPriceValue;
            }

            // Установка значений чекбоксов
            filterIds.forEach(id => {
                const checkbox = document.getElementById(id);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }); // Закрывающая скобка и скобка вызова функции были добавлены здесь
    </script>
@endsection

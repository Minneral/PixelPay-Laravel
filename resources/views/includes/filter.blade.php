<div class="filter">
    <div class="accordion">
        <div class="accordion__item">
            <div class="accordion__itemHeader" onclick="handleClickFilter(this)">
                Стоимость
            </div>

            <div class="accordion__itemBody">
                <div class="price">
                    <div class="price__item">
                        <span>От:</span>
                        <input type="text" value="{{ $minPrice }}" name="minPrice" id="minPrice"/>
                    </div>
                    <div class="price__item">
                        <span>До:</span>
                        <input type="text" value="{{ $maxPrice }}" name="maxPrice" id="maxPrice"/>
                    </div>
                </div>

            </div>
        </div>

        @foreach ($categories as $category)
            <div class="accordion__item">
                <div class="accordion__itemHeader" onclick="handleClickFilter(this)">
                    {{ $category['category'] }}
                </div>

                <div class="accordion__itemBody">
                    @foreach ($filters as $filter)
                        @if ($filter['category'] === $category['category'])
                            <div class="checker">
                                <input type="checkbox" id="{{ $filter['id'] }}" />
                                <label for="{{ $filter['id'] }}">{{ $filter['filter_name'] }}</label>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach

        <button onclick="handleSubmitFilter()">Применить фильтр</button>
    </div>
</div>

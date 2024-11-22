@if (!function_exists('renderMenuList'))
    @php
        function renderMenuList($items, $isFirstLevel = true)
        {
            $html = '';
            foreach ($items as $index => $item) {
                $html .= '<li class="menu__item ' . ($isFirstLevel ? 'menu__firstLevel' : '') . '">';
                $html .= '<a href="' . url('/market?query=') . $item['name'] . '">';
                $html .= '<div class="menu__itemTitle ' . ($isFirstLevel ? 'menu__firstTitle' : '') . '">';
                $html .= $item['name'];
                if ($isFirstLevel && $index === 0) {
                    $html .= '<span class="triangle">▶</span>';
                }
                $html .= '</div>';
                if (isset($item['children'])) {
                    $html .= '<ul class="submenu">' . renderMenuList($item['children'], false) . '</ul>';
                }
                $html .= '</a>';
                $html .= '</li>';
            }
            return $html;
        }
    @endphp
@endif

<ul class="menu">
    {!! renderMenuList($data) !!}
</ul>

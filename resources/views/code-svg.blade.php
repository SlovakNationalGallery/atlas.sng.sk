<svg width="84" height="84" fill="none" xmlns="http://www.w3.org/2000/svg">
    @for ($indexY = 0; $indexY < 3; $indexY++)
        @for ($indexX = 0; $indexX < 3; $indexX++)
            <circle cx="{{ 12 + $indexX * 30 }}" cy="{{ 12 + $indexY * 30 }}" r="10" stroke="{{ $color }}"
            stroke-width="4" fill="{{ ($code[$indexY * 3 + $indexX] == '1') ? $color : 'none'}}" />
        @endfor
    @endfor
</svg>

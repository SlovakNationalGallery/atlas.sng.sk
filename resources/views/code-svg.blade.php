<svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
    @for ($indexY = 0; $indexY < 3; $indexY++)
        @for ($indexX = 0; $indexX < 3; $indexX++)
            <circle cx="{{ 4 + $indexX * 12 }}" cy="{{ 4 + $indexY * 12 }}" r="3.30435" stroke="{{ $color }}"
            stroke-width="1.3913" fill="{{ ($code[$indexY * 3 + $indexX] == '1') ? $color : 'none'}}" />
        @endfor
    @endfor
</svg>

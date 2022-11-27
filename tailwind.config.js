module.exports = {
    content: ['./resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.vue'],
    theme: {
        extend: {
            animation: {
                grow: 'grow 300ms ease-in-out 800ms forwards, grow 300ms ease-in-out 1900ms reverse forwards',
                peek: 'peek 300ms ease-in-out 800ms forwards, peek 300ms ease-in-out 1900ms reverse forwards',
            },
            borderWidth: {
                1: '1px',
            },
            keyframes: (theme) => ({
                peek: {
                    '0%': { transform: 'translateY(0)' },
                    '100%': { transform: 'translateY(max(-50vw, -16rem))' },
                },
                grow: {
                    '0%': {
                        color: theme('colors.white'),
                        fontSize: theme('fontSize.sm'),
                    },
                    '100%': {
                        color: theme('colors.green'),
                        fontSize: theme('fontSize.base'),
                    },
                },
            }),
            padding: (theme) => ({
                bar: `calc(1.5 * ${theme('fontSize.sm')} + ${theme('spacing.8')})`,
                full: '100%',
            }),
            strokeWidth: {
                3: '3',
            },
        },
        colors: {
            none: 'none',
            black: '#1e1e1e',
            white: '#fff',
            red: '#f44336',
            green: '#0DF043',
            gray: {
                softest: '#DDDEE3',
                soft: '#B9BBC6',
                medium: '#A0A1B1',
                dark: '#6D6E7D',
            },
            transparent: 'transparent',
        },
        fontFamily: {
            sans: ['GTWalsheim', 'sans-serif'],
        },
        fontSize: {
            sm: ['14px'],
            base: ['18px'],
            lg: ['20px'],
            xl: ['22px'],
            '2xl': ['24px'],
        },
        fontWeight: {
            normal: '400',
            bold: '700',
        },
        height: (theme) => ({
            auto: 'auto',
            ...theme('spacing'),
            full: '100%',
            screen: 'calc(var(--vh) * 100)',
        }),
        minHeight: (theme) => ({
            0: '0',
            ...theme('spacing'),
            full: '100%',
            screen: 'calc(var(--vh) * 100)',
        }),
    },
    corePlugins: {
        aspectRatio: false,
    },
    plugins: [require('@tailwindcss/aspect-ratio')],
}

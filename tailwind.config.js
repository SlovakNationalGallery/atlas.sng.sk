module.exports = {
    content: ['./resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.vue'],
    theme: {
        extend: {
            padding: {
                full: '100%',
            },
        },
        colors: {
            black: '#000',
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
    plugins: [],
}

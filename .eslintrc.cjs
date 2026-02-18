module.exports = {
    root: true,
    env: {
        browser: true,
        es2021: true,
        node: true,
    },
    extends: [
        'eslint:recommended',
        'plugin:import/recommended',
        'plugin:prettier/recommended',
    ],
    parserOptions: {
        ecmaVersion: 2021,
        sourceType: 'module',
    },
    plugins: ['import', 'prettier'],
    rules: {
        'prettier/prettier': 'warn',
        'no-unused-vars': ['warn', { argsIgnorePattern: '^_' }],
        'import/order': [
            'warn',
            {
                groups: ['builtin', 'external', 'internal', 'parent', 'sibling', 'index'],
                'newlines-between': 'always',
            },
        ],
    },
    ignorePatterns: ['public/js/*.js'],
};

const path = require('path');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports  = {
    entry: {
        app: path.resolve(__dirname, './themes/default/js/app.js'),
        style: path.resolve(__dirname, './themes/default/css/style.less'),
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, './bundle'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: [/node_modules/],
                use: [
                    {
                        loader: 'babel-loader',
                        options: { presets: ['latest'] }
                    }
                ]
            },
            {
                test: /\.less$/,
                use: ExtractTextPlugin.extract({
                    use: [
                        {loader: 'css-loader', options: {minimize: true, sourceMap: true}},
                        {
                            loader: "less-loader",
                            options: {
                                minimize: true,
                                sourceMap: true
                            }
                        }
                    ]
                })
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin({
            filename: "[name].css",
            allChunks: true
        })
    ],
    devtool: 'source-map'
};

const path = require('path')
const HTMLWebpackPlugin =  require('html-webpack-plugin')
const {CleanWebpackPlugin} = require('clean-webpack-plugin')

module.exports = {
    context: path.resolve(__dirname,'public/templates'),
    mode: "development",
    entry: {
        main: '/index.js'
    },
    output: {
        filename: "[name].[contenthash].js",
        path: path.resolve(__dirname,'templates')
    },
    resolve: {
        extensions: ['.js','.json','.png'],
        alias: {
          //  '@models': path.resolve(__dirname,'src/models'),
           // '@controllers': path.resolve(__dirname,'controllers'),
          //  '@': path.resolve(__dirname,'src')
        }
    },
    plugins: [
        new HTMLWebpackPlugin({
            template: "/index.html"
        }),
        new CleanWebpackPlugin()
    ],
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ['style-loader','css-loader']
            },
            {
                test: /\.(png|svg|jpg|jpeg|gif)$/i,
                type: 'asset/resource'
            },
            {
                test: /\.xml$/,
                use: ['xml-loader']
            },
            {
                test: /\.js$/,
                include: path.resolve(__dirname, './templates'),
                use: {
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'webfonts',
                        publicPath: '../webfonts',
                    },
                }
            },
        ]
    }
}

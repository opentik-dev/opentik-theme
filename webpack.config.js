const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  entry: {
    main: './assets/src/js/main.js'
  },
  output: {
    filename: 'js/[name].js',
    path: path.resolve(__dirname, 'assets/dist'),
    publicPath: '/wp-content/themes/opentik-theme/assets/dist/'
  },
  module: {
    rules: [
      {
        test: /\.css$/i,
        use: [MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader']
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'css/[name].css'
    })
  ],
  resolve: {
    extensions: ['.js']
  }
};

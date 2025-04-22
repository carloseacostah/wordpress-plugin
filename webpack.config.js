/* webpack */
const path = require('path');

module.exports = {
  entry: './scss/main.scss',
  output: {
    path: path.resolve(__dirname, 'css'),
    filename: 'style.js',
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          'style-loader',
          'css-loader',
          'sass-loader'
        ]
      }
    ]
  }
};
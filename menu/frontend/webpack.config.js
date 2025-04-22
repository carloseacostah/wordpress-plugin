const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  mode: 'development', // o 'production' para la versión final
  entry: './src/index.js', // Punto de entrada principal de tus archivos JavaScript
  output: {
    filename: 'bundle.js', // Nombre del archivo JavaScript de salida
    path: path.resolve(__dirname, 'dist'), // Carpeta donde se guardará el archivo de salida
    publicPath: '/wp-content/plugins/menu/frontend/dist/', // Ruta pública para los assets (importante para WordPress)
  },
  devtool: 'inline-source-map', // Útil para depuración en desarrollo
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env', '@babel/preset-react'],
          },
        },
      },
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader, // Extrae el CSS en archivos separados
          'css-loader',               // Interpreta `@import` y `url()` como `import`/`require()`
          'sass-loader',              // Compila Sass a CSS (si usas Sass/SCSS)
        ],
      },
      {
        test: /\.(png|svg|jpg|jpeg|gif)$/i,
        type: 'asset/resource',
        generator: {
          filename: 'images/[name].[ext]', // Opcional: estructura de carpetas para imágenes
        },
      },
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/i,
        type: 'asset/resource',
        generator: {
          filename: 'fonts/[name].[ext]', // Opcional: estructura de carpetas para fuentes
        },
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'style.css', // Nombre del archivo CSS de salida
    }),
  ],
};
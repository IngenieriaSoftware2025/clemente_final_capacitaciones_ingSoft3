const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
module.exports = {
  mode: "development",
  entry: {
    ///
    "js/app": "./src/js/app.js",
    "js/inicio": "./src/js/inicio.js",
    "js/login/login": "./src/js/login/login.js",
    "js/aplicacion/index": "./src/js/aplicacion/index.js",
    "js/asignacionpermisos/index": "./src/js/asignacionpermisos/index.js",
    "js/historial/index": "./src/js/historial/index.js",
    "js/mapas/index": "./src/js/mapas/index.js",
    "js/permisos/index": "./src/js/mapas/index.js",
    "js/usuarios/index": "./src/js/usuarios/index.js",
    "js/registro/index": "./src/js/registro/index.js",
    "js/permisos/index": "./src/js/permisos/index.js",
    "js/mapas/index": "./src/js/mapas/index.js",
    "js/compania/index": "./src/js/compania/index.js",
    "js/capacitacion/index": "./src/js/capacitacion/index.js",
    "js/instructor/index": "./src/js/instructor/index.js",
    "js/areaentrenamiento/index": "./src/js/areaentrenamiento/index.js",
    "js/horarioentrenamiento/index": "./src/js/horarioentrenamiento/index.js",
    "js/estadisticasentrenamiento/index":"./src/js/estadisticasentrenamiento/index.js",
  },
  output: {
    filename: "[name].js",
    path: path.resolve(__dirname, "public/build"),
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "styles.css",
    }),
  ],
  module: {
    rules: [
      {
        test: /\.(c|sc|sa)ss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },
          "css-loader",
          "sass-loader",
        ],
      },
      {
        test: /\.(png|svg|jpe?g|gif)$/,
        type: "asset/resource",
      },
    ],
  },
};

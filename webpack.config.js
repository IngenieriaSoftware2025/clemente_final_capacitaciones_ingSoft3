const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
module.exports = {
  mode: "development",
  entry: {

    'js/app' : './src/js/app.js',
    'js/inicio' : './src/js/inicio.js',
    "js/login/login": "./src/js/login/login.js",
    "js/aplicacion/index": "./src/js/aplicacion/index.js",
    "js/asignacionpermisos/index": "./src/js/asignacionpermisos/index.js",
    "js/comisiones/index": "./src/js/comisiones/index.js",
    "js/comisionpersonal/index": "./src/js/comisionpersonal/index.js",
    // "js/historial/index": "./src/js/historial/index.js",
    "js/estadisticas/index": "./src/js/estadisticas/index.js",
    "js/mapas/index": "./src/js/mapas/index.js",
    "js/permisos/index": "./src/js/mapas/index.js",
     "js/usuarios/index": "./src/js/usuarios/index.js",

    "js/app": "./src/js/app.js",
    "js/inicio": "./src/js/inicio.js",
    "js/registro/index": "./src/js/registro/index.js",
    "js/login/login": "./src/js/login/login.js",
    "js/marcas/index": "./src/js/marcas/index.js",
    "js/modelos/index": "./src/js/modelos/index.js",
    "js/clientes/index": "./src/js/clientes/index.js",
    "js/inventario/index": "./src/js/inventario/index.js",
    "js/reparaciones/index": "./src/js/reparaciones/index.js",
     "js/roles/index": "./src/js/roles/index.js",
     "js/permisos/index": "./src/js/permisos/index.js",
     "js/ventas/index": "./src/js/ventas/index.js",
     "js/estadisticas/index": "./src/js/estadisticas/index.js",
     "js/rolesPermisos/index": "./src/js/rolesPermisos/index.js",
     "js/actividades/index": "./src/js/actividades/index.js",
      "js/mapas/index": "./src/js/mapas/index.js",


     
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
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

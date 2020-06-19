module.exports = {
  lintOnSave: false,
  devServer: {
    hot: false,
    hotOnly: false,
    liveReload: false
  },
  // Turning off hot reload because it fucks with document related functions
  chainWebpack: config => {
    config.plugins.delete('hmr');
  }
};

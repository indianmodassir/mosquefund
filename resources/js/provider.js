function ajax(url, options, type) {
  if (typeof url === 'object') {
    options = url;
    url = options.url;
  }

  options = options || {};

  options.type = options.type || type;
  options.url = 'routes/request';
  options.headers = {request: url};
  return $.ajax(options);
}

function post(url, options) {
  return ajax(url, options, 'post');
}

function get(url, options) {
  return ajax(url, options, 'get');
}
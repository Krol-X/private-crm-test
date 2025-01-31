import axios from 'axios';

const _base_url = import.meta.env.API_URL || window.location.host;

export class RestApi {
  #url_postfix = undefined;
  #data = undefined;
  #token = undefined;

  constructor(methods, base_url = _base_url) {
    this.#load_methods(methods, base_url);
  }

  #load_methods(methods, base_url, protocol = 'http') {
    for (const method_name of Object.keys(methods)) {
      const it = methods[method_name];
      const request_url = `${protocol}://` + `${base_url}/${it.path}`.replace('//', '/');
      it.method ||= 'get';

      this[method_name] = async function (config) {
        if (it.serializer) {
          [this.#data, this.#url_postfix] = await it.serializer(this.#data, this.#url_postfix);
        }

        const url = this.#url_postfix ? `${request_url}/${this.#url_postfix}` : request_url;
        let axios_config = {
          method: it.method,
          url,
          ...config
        };

        if (this.#data !== undefined) {
          if (it.method === 'get') {
            axios_config.params = this.#data;
          } else {
            axios_config.data = this.#data;
          }
        }
        if (this.#token !== undefined) {
          axios_config.headers ||= {};
          axios_config.headers['Authorization'] = `Bearer ${this.#token}`;
        }

        const response = await axios(axios_config);
        this.flush();

        let data = response.data;
        if (it.deserializer) {
          data = it.deserializer(data);
        }

        return data;
      }.bind(this);
    }
  }

  flush(and_token = false) {
    this.#url_postfix = undefined;
    this.#data = undefined;
    if (and_token) {
      this.#token = undefined;
    }
  }

  with_postfix(new_postfix) {
    this.#url_postfix = new_postfix;
    return this;
  }

  with(new_data) {
    this.#data = new_data;
    return this;
  }

  with_token(new_token) {
    this.#token = new_token;
    return this;
  }
}

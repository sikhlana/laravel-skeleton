import _each from 'lodash/each';
import axios from 'axios';
import helper from './helper';

export default {
    get(url, params, config = {}) {
        return this.request('get', url, {...config, params});
    },

    post(url, data, config = {}) {
        return this.request('post', url, {...config, data});
    },

    put(url, data, config = {}) {
        return this.request('put', url, {...config, data});
    },

    delete(url, config = {}) {
        return this.request('delete', url, config);
    },

    request(method, url, config = {}) {
        config = {
            ...config,
            method,
            url,
        };

        return axios.request(config)
            .catch((err) => {
                if ('response' in err) {
                    const response = err.response;

                    if ('data' in response) {
                        const data = response.data;
                        helper.notify('error', data.message || response.statusText);

                        if ('errors' in data) {
                            _each(data.errors, (message, key) => {
                                const $el = window.$(document.getElementById(`ctrl_${key}`));

                                $el.popup({
                                    content: message[0],
                                    position: 'right center',
                                    on: 'manual',
                                }).popup('show');
                            });
                        }
                    } else {
                        helper.notify('error', response.statusText);
                    }
                } else {
                    helper.notify('error', 'Please check the console for more information.');
                    console.error(err);
                }

                return Promise.reject(err);
            });
    }
}

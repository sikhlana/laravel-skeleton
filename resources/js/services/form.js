import api from './api';
import helper from './helper';

export default {
    init(form, config = {}) {
        form.querySelectorAll('[name]').forEach((field) => {
            field.addEventListener('change', () => {
                window.$(field).popup('destroy');
            });
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            window.app.$emit('notify.close');

            this.submit(form, config)
                .then(({ data, allowRedirection}) => {
                    if (allowRedirection && 'redirect' in data) {
                        helper.redirect(data.redirect);
                    }
                });
        });
    },

    submit(form, config = {}) {
        const data = new FormData(form);
        const redirect = helper.truth(form.dataset.redirect);
        const method = form.getAttribute('method') || 'get';
        const url = form.getAttribute('action') || window.location.href;

        if (helper.truth(form.dataset.return)) {
            data.append('_return', 'on');
        }

        form.classList.add('loading');

        return api.request(method, url, {...config, data})
            .then((response) => {
                response.allowRedirection = redirect;
                const data = response.data;

                if ('warning' in data) {
                    helper.notify('warning', data.warning);
                } else {
                    helper.notify('success', data.message || response.headers['x-message'] || 'Changes have been successfully saved.', 1200);
                }

                return response;
            })
            .finally(() => {
                form.classList.remove('loading');
            });
    },
}

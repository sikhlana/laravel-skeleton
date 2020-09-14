import form from './form';

export default {
    activate(el) {
        const $ = window.$;

        el.querySelectorAll('.ui.modal').forEach((el) => {
            if (this.truth(el.dataset.modalInit)) {
                return;
            }

            $(el).modal({
                blurring: this.truth(el.dataset.blurring),
            });

            el.dataset.modalInit = 'yes';
        });

        el.querySelectorAll('.ui.dropdown').forEach((el) => {
            if (this.truth(el.dataset.dropdownInit)) {
                return
            }

            $(el).dropdown({
                on: el.dataset.on || 'click',
                action: el.dataset.action || 'activate',
                allowAdditions: this.truth(el.dataset.allowAdditions),
                allowCategorySelection: this.truth(el.dataset.allowCategorySelection),
                placeholder: el.dataset.placeholder || 'auto',
                clearable: this.truth(el.dataset.clearable),
                fullTextSearch: this.truth(el.dataset.fullTextSearch),
            });

            el.dataset.dropdownInit = 'yes';
        });

        document.querySelectorAll('.ajax.form').forEach((el) => {
            if (this.truth(el.dataset.ajaxInit)) {
                return;
            }

            form.init(el);
            el.dataset.ajaxInit = 'yes';
        });

        document.querySelectorAll('.overlay.trigger').forEach((el) => {
            if (this.truth(el.dataset.overlayInit)) {
                return;
            }

            el.addEventListener('click', (e) => {
                e.preventDefault();
                window.app.$emit('overlay', el, e);
            });

            el.dataset.overlayInit = 'yes';
        })
    },

    notify(type, message, timeout = 0) {
        window.app.$emit('notify', ...arguments);
    },

    truth(val) {
        return val === true || val === 1 || val === '1' || val === 'on' || val === 'yes' || val === 'true' || val === 'si';
    },

    redirect(target, timeout = 1500) {
        setTimeout(() => {
            if (window.location.href === target) {
                window.location.reload();
            } else {
                window.location.href = target;
            }
        }, timeout);
    },
}

import '~/css/app.scss';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/svelte';
import { mount } from 'svelte';

import Default from './layouts/Default.svelte';
import store from './store';

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('./pages/**/*.svelte', { eager: true });
    const page = pages[`./pages/${name}.svelte`];
    return { default: page.default, layout: Default };
  },
  setup({ el, App, props }) {
    mount(App, { target: el, props });
  }
});

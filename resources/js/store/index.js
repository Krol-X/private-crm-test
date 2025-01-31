import { modal_store } from './modal.svelte.js';
import { events_store } from './events.svelte.js';
import { rations_store } from '@/store/rations.svelte.js';

export default {
  modal: modal_store,
  events: events_store,
  rations: rations_store
};

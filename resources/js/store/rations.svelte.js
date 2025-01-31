import { ListStore } from '@/lib/list_store.svelte.js';

import api from '@/api';

export class RationsStore extends ListStore {
  async fetch(order_id) {
    return this.query(api.rations.with(order_id).list);
  }
}

export const rations_store = new RationsStore();

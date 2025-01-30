export class EventsStore {
  #handlers = new Map();

  assign(event_name, handler, replace = false) {
    if (!this.#handlers.has(event_name) || replace) {
      this.#handlers.set(event_name, new Set());
    }
    this.#handlers.get(event_name).add(handler);
  }

  unassign(event_name, handler) {
    if (this.#handlers.has(event_name)) {
      this.#handlers.get(event_name).delete(handler);
    }
  }

  unassignAll(event_name) {
    if (this.#handlers.has(event_name)) {
      this.#handlers.get(event_name).clear();
    }
  }

  async dispatch(event_name, wait = false) {
    if (!this.#handlers.has(event_name)) {
      return [];
    }

    const handlers = this.#handlers.get(event_name);
    const promises = [...handlers].map((handler) => handler());

    return wait ? await Promise.all(promises) : promises;
  }
}

export const events_store = new EventsStore();

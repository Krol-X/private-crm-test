export class ListStore {
  #items = $state([]);
  #is_loading = $state(false);

  async mutate(func) {
    this.#is_loading = true;
    const response_data = await func();
    this.#is_loading = false;

    return response_data;
  }

  async query(func) {
    this.#items = await this.mutate(func);

    return this.#items;
  }

  get list() {
    return this.#items;
  }

  get is_loading() {
    return this.#is_loading;
  }
}

export class ModalStore {
  #component = $state(null);
  #params = $state({});
  #with_blur = $state(false);

  get component() {
    return this.#component;
  }

  get params() {
    return $state.snapshot(this.#params);
  }

  open(component, params, with_blur) {
    this.#component = component;
    this.#params = params || {};
    this.#with_blur = with_blur;
  }

  close() {
    this.#component = null;
  }

  get blur() {
    return this.#with_blur;
  }
}

export const modal_store = new ModalStore();

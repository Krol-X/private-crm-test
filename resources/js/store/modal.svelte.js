export class Modal {
  #component = $state(null);
  #with_blur = $state(false);

  get component() {
    return this.#component;
  }

  open(component, with_blur) {
    this.#component = component;
    this.#with_blur = with_blur;
  }

  close() {
    this.#component = null;
  }

  get blur() {
    return this.#with_blur;
  }
}

export const modal = new Modal();

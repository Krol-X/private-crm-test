<script>
  import { setContext } from 'svelte';
  let { children, component: Modal = $bindable(null), opacity = 0.35, blur = false } = $props();

  import { isFunction } from '../utils/types';
</script>

<div class="modal-container">
  <div class="content" class:lock-scroll={Modal} class:blur={Modal && blur}>
    {@render children?.()}
  </div>

  {#if Modal}
    <div class="modal" style="background-color: rgba(0, 0, 0, {opacity});">
      {#if isFunction(Modal)}
        {@render Modal()}
      {:else}
        <Modal />
      {/if}
    </div>
  {/if}
</div>

<style>
  .modal-container {
    position: relative;
  }
  .lock-scroll {
    position: fixed;
    width: 100%;
    overflow: hidden;
  }
  .blur {
    filter: blur(4px);
  }
  .modal {
    position: absolute;
    left: 0;
    top: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
</style>

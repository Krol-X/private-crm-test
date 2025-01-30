<script>
  const { children, store } = $props();

  import Menu from './Components/Menu.svelte';
  import { Modal } from '@/lib/structe/index.js';
</script>

<Modal component={store?.modal.component} blur={store?.modal.blur}>
  <div class="layout">
    <header>
      <Menu />
    </header>

    <main>
      {@render children?.()}
    </main>
  </div>
</Modal>

<style>
  .layout {
    @apply flex flex-col w-screen h-screen;
  }

  main {
    @apply flex-1 overflow-auto p-4;
  }
</style>
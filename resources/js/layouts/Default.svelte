<script>
  const { children, store } = $props();

  import { Modal } from '@/lib/structe/index.js';
</script>

<Modal component={store?.modal.component} blur={store?.modal.blur}>
  <main>
    {@render children?.()}
  </main>
</Modal>

<style>
  main {
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
  }
</style>
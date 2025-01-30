<script>
  import { onMount, onDestroy } from 'svelte';
  import store from '@/store';

  import OrderForm from '@/components/forms/OrderForm.svelte';

  let { orders } = $props();

  function openModal() {
    store.modal.open(OrderForm);
  }

  onMount(() => {
    store.events.assign('new-item', openModal, true);
  });

  onDestroy(() => {
    store.events.unassign('new-item', openModal);
  });
</script>

Orders

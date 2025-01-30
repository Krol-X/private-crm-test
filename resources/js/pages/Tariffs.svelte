<script>
  import { onMount, onDestroy } from 'svelte';

  import store from '@/store';
  import { Column, Row } from '@/lib/structe/index.js';
  import TariffForm from '@/components/forms/TariffForm.svelte';

  let { tariffs } = $props();

  function openModal(params) {
    store.modal.open(TariffForm, { fields: params ?? {} });
  }

  onMount(() => {
    store.events.assign('new-item', openModal, true);
  });

  onDestroy(() => {
    store.events.unassign('new-item', openModal);
  });
</script>

<Column class="tariffs">
  {#each tariffs as tariff(tariff.id)}
    <Column class="border border-black p-1" click={() => openModal(tariff)}>
      <Row class="w-full justify-between">
        <div>Id</div>
        <div>{tariff.id}</div>
      </Row>
      <Row class="w-full justify-between">
        <div>Имя рациона</div>
        <div>{tariff.ration_name}</div>
      </Row>
      <Row class="w-full justify-between">
        <div>Готовить за день</div>
        <div>{tariff.cooking_day_before ? 'Да' : 'Нет'}</div>
      </Row>
    </Column>
  {/each}
</Column>

<style>
  :global(.tariffs) {
    max-width: 32rem;
    margin-left: auto;
    margin-right: auto;

    gap: 1rem;
  }
</style>

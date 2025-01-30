<script>
  import { onMount, onDestroy } from 'svelte';
  import store from '@/store';
  import { Column, Row } from '@/lib/structe/index.js';
  import OrderForm from '@/components/forms/OrderForm.svelte';

  let { orders, tariffs } = $props();

  const scheduleTypeLabels = {
    EVERY_DAY: 'Каждый день',
    EVERY_OTHER_DAY: 'Через день',
    EVERY_OTHER_DAY_TWICE: 'Через день дважды'
  };

  function openModal(params) {
    if (tariffs.length > 0) {
      store.modal.open(OrderForm, { fields: params ?? {}, tariffs });
    } else {
      alert('Добавьте хотя-бы один тариф!');
    }
  }

  onMount(() => {
    store.events.assign('new-item', openModal, true);
  });

  onDestroy(() => {
    store.events.unassign('new-item', openModal);
  });
</script>

<Column class="orders">
  {#each orders as order(order.id)}
    <Column class="border border-black p-2 rounded-lg" click={() => openModal(order)}>
      <Row class="w-full justify-between">
        <div>ID заказа</div>
        <div>{order.id}</div>
      </Row>
      <Row class="w-full justify-between">
        <div>Клиент</div>
        <div>{order.client_name}</div>
      </Row>
      <Row class="w-full justify-between">
        <div>Телефон</div>
        <div>{order.client_phone}</div>
      </Row>
      <Row class="w-full justify-between">
        <div>Тариф</div>
        <div>{order.tariff_id}</div>
      </Row>
      <Row class="w-full justify-between">
        <div>Расписание</div>
        <div>{scheduleTypeLabels[order.schedule_type]}</div>
      </Row>
      <Row class="w-full justify-between">
        <div>Даты доставки</div>
        <div>
          {new Date(order.first_date).toLocaleDateString()} -
          {new Date(order.last_date).toLocaleDateString()}
        </div>
      </Row>
      {#if order.comment}
        <Row class="w-full justify-between">
          <div>Комментарий</div>
          <div class="text-gray-600">{order.comment}</div>
        </Row>
      {/if}
    </Column>
  {/each}
</Column>

<style>
  :global(.orders) {
    max-width: 48rem;
    margin-left: auto;
    margin-right: auto;
    gap: 1rem;
  }
</style>

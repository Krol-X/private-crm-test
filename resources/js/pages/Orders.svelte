<script>
  import { onMount, onDestroy } from 'svelte';

  import { SCHEDULE } from '@/constants';
  import store from '@/store';

  import OrderForm from '@/components/forms/OrderForm.svelte';
  import { Column, Row } from '@/lib/structe';

  let { orders, tariffs } = $props();

  function openModal(params) {
    if (tariffs.meta.total > 0) {
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
  {#each orders.data as order(order.id)}
    <Column class="border-2 border-black hover:border-blue-600 p-2 rounded-lg cursor-pointer"
            click={() => openModal(order)}
    >
      <Row class="w-full justify-between">
        <div>ID заказа</div>
        <div>{order.id}</div>
      </Row>
      <hr class="border-inherit" />
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
        <div>{order.tariff?.ration_name}</div>
      </Row>
      <Row class="w-full justify-between">
        <div>Расписание</div>
        <div>{SCHEDULE[order.schedule_type]}</div>
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
          <div>{order.comment}</div>
        </Row>
      {/if}
    </Column>
  {/each}
</Column>

<style>
  :global(.orders) {
    max-width: 32rem;
    margin-left: auto;
    margin-right: auto;
    gap: 1rem;
  }
</style>
